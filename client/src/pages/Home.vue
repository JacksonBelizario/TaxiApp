<template>
  <v-app id="home">
    <v-navigation-drawer
      v-model="drawer"
      fixed
      clipped
      class="grey lighten-4"
      app
    >
      <v-list
        dense
        class="grey lighten-4"
      >
        <template v-for="(item, i) in items">
          <v-layout
            v-if="item.heading"
            :key="i"
            row
            align-center
          >
            <v-flex xs6>
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-flex>
            <v-flex xs6 class="text-xs-right">
              <v-btn small flat>edit</v-btn>
            </v-flex>
          </v-layout>
          <v-divider
            v-else-if="item.divider"
            :key="i"
            dark
            class="my-3"
          ></v-divider>
          <v-list-tile
            v-else
            :key="i"
            @click=""
          >
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title class="grey--text">
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar color="amber" app absolute clipped-left>
      <v-toolbar-side-icon @click.native="drawer = !drawer"></v-toolbar-side-icon>
      <span class="title ml-3 mr-5">Taxi&nbsp;<span class="font-weight-light">App</span></span>
      <v-spacer></v-spacer>
        <v-tooltip bottom>
          <v-btn
            slot="activator"
            :href="source"
            icon
            large
            target="_blank"
            @click.stop="showRoute = !showRoute"
          >
            <v-icon v-if="!loading">near_me</v-icon>
            <v-progress-circular  v-else indeterminate color="grey darken-4"></v-progress-circular>
          </v-btn>
          <span>Definir Rota</span>
      </v-tooltip>
    </v-toolbar>
    <v-content :style="{position: 'relative'}">
        <v-card
          v-if="showRoute"
         class="d-inline-block elevation-12"
            :style="{position: 'absolute', top: '10px', left: '20px', right: '20px'}">
          <v-navigation-drawer
            permanent stateless value="true" width="100%">
            <v-list dense>
              <v-list-tile @click.stop="geolocateme">
                <v-list-tile-action>
                  <v-icon>my_location</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>{{ location.origin }}</v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-list-tile @click.stop="toggleDialog">
                <v-list-tile-action>
                  <v-icon>place</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>{{ location.destination }}</v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
            </v-list>
          </v-navigation-drawer>
        </v-card>
        <here-map ref="mapView" :app-id="map.appId" :app-code="map.appCode" :mHeigth="map.height" :onGetPos="onGetPos" :onGetDestiny="onGetDestiny" :onResultSearch="onResultSearch" />
        <dialog-search ref="dialogSearch" :selectLocation="selectDestiny" :onSearch="onSearch" :locations="locationsSearch" :setDestination="setDestination" />
    </v-content>
  </v-app>
</template>

<script>
export default {
	components: {
		HereMap: () => import("@/components/HereMap.vue"),
		DialogSearch: () => import("@/components/DialogSearch.vue")
	},
	data: () => ({
		showRoute: false,
		loading: false,
		map: {
			appId: "sbpvVSquAAGctcKCQrLy",
			appCode: "ErDGsA7NQz1Pd3BXiEKc-Q",
			height: null
		},
		location: {
			origin: "Origem",
			destination: "Destino"
		},
		locationsSearch: [],
		drawer: null,
		items: [
			{ icon: "lightbulb_outline", text: "Notes" },
			{ icon: "touch_app", text: "Reminders" },
			{ divider: true },
			{ icon: "settings", text: "Sair" },
		]
	}),
	props: {
		source: String
	},
	mounted() {
		this.map.height = this.$el.clientHeight;
	},
	methods: {
		geolocateme() {
			this.loading = true;
			//const self = this;
			this.$getLocation({
				enableHighAccuracy: true, //defaults to false
				timeout: Infinity, //defaults to Infinity
				maximumAge: 0 //defaults to 0
			})
				.then(coordinates => {
					this.loading = false;
					this.$refs.mapView.setOrigin(coordinates);
					//self.$emit("center-location", coordinates);
				})
				.catch(err => {
					this.loading = false;
				});
		},
		onGetPos(res) {
			this.location.origin = res.label;
		},
		selectDestiny() {
			this.$refs.mapView.setDestinyByClick();
			this.toggleDialog();
		},
		onGetDestiny(res) {
			this.location.destination = res.label;
		},
		toggleDialog() {
			this.$refs.dialogSearch.toggleDialog();
		},
		onSearch(res) {
			console.log("onSearch", res);
			this.$refs.mapView.searchLocation(res);
		},
		onResultSearch(res) {
			console.log("onResultSearch", res);
			this.locationsSearch = res;
		},
		setDestination(coord) {
			console.log("setDestination");
			this.$refs.mapView.setDestination(coord);
			this.toggleDialog();
		}
	}
};
</script>

<style>
#keep .v-navigation-drawer__border {
	display: none;
}
</style>
