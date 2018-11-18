<template>
  <div>
    <div :style="{width: mapWidth, height: mapHeigth, zIndex:'auto'}" id="mapContainer"></div>
  </div>
</template>

<script>
import car from "../assets/car.png";
export default {
	name: "here-map",
	props: [
		"appId",
		"appCode",
		"mWidth",
		"mHeigth",
		"onGetPos",
		"onGetDestiny",
		"onResultSearch"
	],
	data() {
		return {
			map: null,
			platform: null,
			explore: null,
			geocoder: null,
			router: null,
			origin: null,
			destiny: null,
			coords: null,
			coords2: null,
			taxis: [],
			routeLine: null,
			pageHeight: "500px",
			mapWidth: this.mWidth || "100%",
			mapHeigth: this.mHeigth ? `${this.mHeigth}px` : "500px"
		};
	},
	computed: {},
	methods: {
		setOrigin(coords) {
			this.coords = coords;
			this.map.setCenter(coords);
			if (this.origin == null) {
				this.origin = this.addMarker(coords);
				this.setDummyTaxis(coords);
			} else {
				this.origin.setPosition(coords);
			}
			this.getInfoLocation(coords)
				.then(res => {
					if (this.onGetPos) this.onGetPos(res);
				})
				.catch(error => {
					console.warn(error);
				});
			this.map.getViewPort().resize();
			if (this.coords2) this.calculateRouteFromAtoB(coords, this.coords2);
		},
		setDestinyByClick() {
			this.clearDestination();
			// Attach an event listener to map display
			// obtain the coordinates and display in an alert box.
			this.map.addEventListener("tap", evt => {
				if (this.destiny == null) {
					const coords2 = this.map.screenToGeo(
						evt.currentPointer.viewportX,
						evt.currentPointer.viewportY
					);
					this.setDestination(coords2);
				}
			});
		},
		clearDestination() {
			if (this.destiny) {
				this.map.removeObject(this.destiny);
				this.destiny = null;
			}
			if (this.routeLine) {
				this.map.removeObject(this.routeLine);
				this.routeLine = null;
			}
		},
		setDestination(coords2) {
			this.clearDestination();
			this.coords2 = coords2;
			this.destiny = this.addMarker(coords2);
			this.getInfoLocation(coords2)
				.then(res => {
					if (this.onGetDestiny) this.onGetDestiny(res);
				})
				.catch(error => {
					console.warn(error);
				});
			if (this.coords) this.calculateRouteFromAtoB(this.coords, coords2);
		},
		addMarker(coords, svg = null) {
			let marker;
			if (svg) {
				const icon = new H.map.Icon(svg);
				marker = new H.map.Marker(coords, { icon: icon });
			} else {
				marker = new H.map.Marker(coords);
			}
			this.map.addObject(marker);
			return marker;
		},
		getRandom(max, min) {
			return Math.random() * (max - min) + min;
		},
		getRandomPos(lat, lng) {
			let maxLat = lat * 1.001;
			let minLat = lat / 1.001;
			let maxLng = lng * 1.001;
			let minLng = lng / 1.001;
			return {
				lat: this.getRandom(maxLat, minLat),
				lng: this.getRandom(maxLng, minLng)
			};
		},
		setDummyTaxis(coord) {
			for (let i = 0; i < 10; i++) {
				this.taxis.push(
					this.addMarker(this.getRandomPos(coord.lat, coord.lng), car)
				);
			}
		},
		getInfoLocation(coords) {
			return new Promise((resolve, reject) => {
				this.geocoder.reverseGeocode(
					{
						prox: `${coords.lat},${coords.lng},100`,
						mode: "retrieveAddresses",
						maxresults: "1",
						jsonattributes: 1
					},
					({ response }) => {
						if (response.view[0].result.length) {
							resolve(
								response.view[0].result[0].location.address
							);
						} else {
							reject(
								"Não foi possível obter dados da localização"
							);
						}
					},
					error => {
						reject(error);
					}
				);
			});
		},
		calculateRouteFromAtoB(coords, coords2) {
			this.router.calculateRoute(
				{
					mode: "fastest;car",
					representation: "display",
					routeattributes: "waypoints,summary,shape,legs",
					maneuverattributes: "direction,action",
					waypoint0: `${coords.lat},${coords.lng}`,
					waypoint1: `${coords2.lat},${coords2.lng}`
				},
				result => {
					if (result.response && result.response.route) {
						// Pick the first route from the response:
						let route = result.response.route[0];

						// Create a linestring to use as a point source for the route line
						let linestring = new H.geo.LineString();

						// Push all the points in the shape into the linestring:
						route.shape.forEach(function(point) {
							var parts = point.split(",");
							linestring.pushLatLngAlt(parts[0], parts[1]);
						});

						// Create a polyline to display the route:
						this.routeLine = new H.map.Polyline(linestring, {
							style: { lineWidth: 5 }
						});

						// Add the route polyline to the map:
						this.map.addObject(this.routeLine);

						// Set the map's viewport to make the whole route visible:
						this.map.setViewBounds(this.routeLine.getBounds());
					} else {
						console.warn(
							"Não há rotas disponíveis para estas coordenadas"
						);
					}
				},
				err => {
					console.warn(err);
				}
			);
		},
		searchLocation(searchText) {
			// Call the geocode method with the geocoding parameters
			if (this.coords) {
				this.searchPlaces(searchText)
					.then(res => {
						this.onResultSearch(res);
					})
					.catch(err => {
						console.warn(err);
					});
			} else {
				this.searchStreets(searchText)
					.then(res => {
						this.onResultSearch(res);
					})
					.catch(err => {
						console.warn(err);
					});
			}
		},
		searchStreets(searchText) {
			return new Promise((resolve, reject) => {
				// Call the geocode method with the geocoding parameters
				this.geocoder.search(
					{
						jsonattributes: 1,
						country: "brazil",
						searchText
					},
					({ response }) => {
						if (response.view.length) {
							var result = response.view[0].result;
							if (result) {
								const locations = result.map(location => {
									if (location.place) {
										return {
											name: location.place.name,
											address:
												location.place.locations[0]
													.address.label,
											coord: {
												lat:
													location.place.locations[0]
														.displayPosition
														.latitude,
												lng:
													location.place.locations[0]
														.displayPosition
														.longitude
											}
										};
									}
									return {
										name: location.location.address.label,
										address:
											location.location.address.label,
										coord: {
											lat:
												location.location
													.displayPosition.latitude,
											lng:
												location.location
													.displayPosition.longitude
										}
									};
								});
								resolve(locations);
							}
						}
						resolve([]);
					},
					e => {
						reject(e);
					}
				);
			});
		},
		searchPlaces(searchText) {
			return new Promise((resolve, reject) => {
				if (this.coords == null)
					reject("Coordenadas de origem não definida");
				var search = new H.places.Search(
					this.platform.getPlacesService()
				);
				// Call the geocode method with the geocoding parameters
				search.request(
					{
						at: `${this.coords.lat},${this.coords.lng}`,
						q: searchText
					},
					{},
					({ results }) => {
						if (results.items) {
							console.log("searchPlaces", results.items);
							const places = results.items.map(place => {
								return {
									name: place.title,
									address: place.vicinity,
									coord: {
										lat: place.position[0],
										lng: place.position[1]
									}
								};
							});
							resolve(places);
						}
						resolve([]);
					},
					e => {
						reject(e);
					}
				);
			});
		}
	},
	created() {
		//this.$root.$on("center-location", this.centerMylocation);
	},
	mounted() {
		this.platform = new H.service.Platform({
			app_id: this.appId,
			app_code: this.appCode,
			useHTTPS: true
		});
		// Obtain the default map types from the platform object:
		const defaultLayers = this.platform.createDefaultLayers();

		// Instantiate (and display) a map object:
		this.map = new H.Map(
			this.$el.querySelector("#mapContainer"),
			defaultLayers.normal.map,
			{
				zoom: 10,
				center: { lat: -22.2312915, lng: -54.8297066 }
			}
		);

		const behavior = new H.mapevents.Behavior(
			new H.mapevents.MapEvents(this.map)
		);
		// Obtain an Explore object through which to submit search requests:
		this.explore = new H.places.Explore(this.platform.getPlacesService());

		this.geocoder = this.platform.getGeocodingService();
		this.router = this.platform.getRoutingService();

		const ui = H.ui.UI.createDefault(this.map, defaultLayers, "pt-BR");
	}
};
</script>
