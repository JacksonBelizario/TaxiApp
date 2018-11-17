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
		"onGetDestiny"
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
				this.randomCoords(coords);
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
		},
		setDestinyByClick() {
			if (this.destiny) {
				this.map.removeObject(this.destiny);
				this.destiny = null;
				if (this.routeLine) {
					this.map.removeObject(this.routeLine);
				}
			}
			// Attach an event listener to map display
			// obtain the coordinates and display in an alert box.
			this.map.addEventListener("tap", evt => {
				if (this.destiny == null) {
					const coords2 = this.map.screenToGeo(
						evt.currentPointer.viewportX,
						evt.currentPointer.viewportY
					);
					this.coords2 = coords2;
					this.destiny = this.addMarker(coords2);
					this.getInfoLocation(coords2)
						.then(res => {
							if (this.onGetDestiny) this.onGetDestiny(res);
						})
						.catch(error => {
							console.warn(error);
						});
					this.calculateRouteFromAtoB();
				}
			});
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
		randomCoords(coord) {
			for (let i = 0; i < 10; i++) {
				this.addMarker(this.getRandomPos(coord.lat, coord.lng), car);
			}
		},
		searchLocation(searchText) {
			// Get an instance of the geocoding service:

			// Call the geocode method with the geocoding parameters,
			// the callback and an error callback function (called if a
			// communication error occurs):
			this.geocoder.geocode(
				{ searchText },
				result => {
					var locations = result.Response.View[0].Result,
						position,
						marker;
					// Add a marker for each location found
					for (i = 0; i < locations.length; i++) {
						position = {
							lat: locations[i].Location.DisplayPosition.Latitude,
							lng: locations[i].Location.DisplayPosition.Longitude
						};
						// marker = new H.map.Marker(position);
						// map.addObject(marker);
					}
				},
				e => {
					console.warn(e);
				}
			);
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
		calculateRouteFromAtoB() {
			this.router.calculateRoute(
				{
					mode: "fastest;car",
					representation: "display",
					routeattributes: "waypoints,summary,shape,legs",
					maneuverattributes: "direction,action",
					waypoint0: `${this.coords.lat},${this.coords.lng}`,
					waypoint1: `${this.coords2.lat},${this.coords2.lng}`
				},
				({ response }) => {
					let route, routeShape, linestring;
					if (response.route) {
						// Pick the first route from the response:
						route = response.route[0];
						// Pick the route's shape:
						routeShape = route.shape;

						// Create a linestring to use as a point source for the route line
						linestring = new H.geo.LineString();

						// Push all the points in the shape into the linestring:
						routeShape.forEach(function(point) {
							var parts = point.split(",");
							linestring.pushLatLngAlt(parts[0], parts[1]);
						});

						// Create a polyline to display the route:
						this.routeLine = new H.map.Polyline(linestring, {
							style: { strokeColor: "blue", lineWidth: 10 }
						});

						// Add the route polyline and the two markers to the map:
						this.map.addObject(this.routeLine);

						// Set the map's viewport to make the whole route visible:
						this.map.setViewBounds(this.routeLine.getBounds());
					}
				},
				errr => {
					console.warn(err);
				}
			);
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
