<template>
  <v-app id="keep">
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
      <span class="title ml-3 mr-5">Google&nbsp;<span class="font-weight-light">Keep</span></span>
      <v-text-field
        solo-inverted
        flat
        hide-details
        label="Search"
        prepend-inner-icon="search"
      ></v-text-field>
      <v-spacer></v-spacer>
    </v-toolbar>
    <v-content>
      <v-container fluid>
        <here-map :app-id="map.appId" :app-code="map.appCode" :coords="map.coords" />
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
	components: {
		HereMap: () => import("./components/HereMap.vue")
	},
	data: () => ({
		map: {
			appId: "sbpvVSquAAGctcKCQrLy",
			appCode: "ErDGsA7NQz1Pd3BXiEKc-Q",
			coords: null
		},
		drawer: null,
		items: [
			{ icon: "lightbulb_outline", text: "Notes" },
			{ icon: "touch_app", text: "Reminders" },
			{ divider: true },
			{ heading: "Labels" },
			{ icon: "add", text: "Create new label" },
			{ divider: true },
			{ icon: "archive", text: "Archive" },
			{ icon: "delete", text: "Trash" },
			{ divider: true },
			{ icon: "settings", text: "Settings" },
			{ icon: "chat_bubble", text: "Trash" },
			{ icon: "help", text: "Help" },
			{ icon: "phonelink", text: "App downloads" },
			{ icon: "keyboard", text: "Keyboard shortcuts" }
		]
	}),
	props: {
		source: String
	},
	mounted() {
		this.$getLocation({
			enableHighAccuracy: true, //defaults to false
			timeout: Infinity, //defaults to Infinity
			maximumAge: 0 //defaults to 0
		}).then(coordinates => {
			console.log(coordinates);
			this.map.coords = coordinates;
		});
	}
};
</script>

<style>
#keep .v-navigation-drawer__border {
	display: none;
}
</style>
