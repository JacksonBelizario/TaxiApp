<template>
  <div>
    <div style="width: 100%; height: 500px; z-index=auto" id="mapContainer"></div>
  </div>
</template>
<script>
import { taxisvg2 } from "../assets/svgs.js";
import car from "../assets/car.png";
export default {
	name: "here-map",
	props: {
		appId: String,
		appCode: String,
		coords: Object
	},
	data() {
		return {
			map: null
		};
	},
	computed: {},
	methods: {
		addMarker(coords, svg = null) {
			if (svg) {
				const icon = new H.map.Icon(svg);
				const marker = new H.map.Marker(coords, { icon: icon });
				this.map.addObject(marker);
			} else {
				const marker = new H.map.Marker(coords);
				this.map.addObject(marker);
			}
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
		}
	},
	mounted() {
		const platform = new H.service.Platform({
			app_id: this.appId,
			app_code: this.appCode,
			useHTTPS: true
		});
		// Obtain the default map types from the platform object:
		const defaultLayers = platform.createDefaultLayers();

		// Instantiate (and display) a map object:
		this.map = new H.Map(
			this.$el.querySelector("#mapContainer"),
			defaultLayers.normal.map,
			{
				zoom: 10,
				center: { lat: -22.2312915, lng: -54.8297066 }
			}
		);

		const coords = this.coords || { lat: -22.2312915, lng: -54.8297066 };
		this.addMarker(coords);
		this.map.setCenter(coords);
		this.randomCoords(coords);

		let behavior = new H.mapevents.Behavior(
			new H.mapevents.MapEvents(this.map)
		);
		let ui = H.ui.UI.createDefault(this.map, defaultLayers);
	}
};
</script>
