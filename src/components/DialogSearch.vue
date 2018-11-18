<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-card>
        <v-toolbar dark color="amber" >
          <v-btn icon dark @click="dialog = false">
            <v-icon>arrow_back</v-icon>
          </v-btn>
			<v-spacer></v-spacer>
			<v-text-field
				v-model="search"
				solo-inverted
				flat
				hide-details
				label="Pesquisar"
				prepend-inner-icon="search"
				@input="onSearch(search)"
			></v-text-field>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-list three-line subheader>
          <v-list-tile @click.stop="selectLocation">
                <v-list-tile-action>
                  <v-icon>place</v-icon>
                </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>Escolher local no mapa</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
        <v-divider></v-divider>
        <v-list three-line subheader>
          <v-subheader>Locais</v-subheader>
          <v-list-tile avatar v-for="(location, key) of locations" :key="key"
		  	@click.stop="setDestination(location.coord)"
			>
            <v-list-tile-content>
              <v-list-tile-title>{{ location.name }}</v-list-tile-title>
              <v-list-tile-sub-title>{{ location.address }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
export default {
	name: "dialog-search",
	props: {
		onSearch: Function,
		selectLocation: Function,
		locations: Array,
		setDestination: Function
	},
	data: () => ({
		dialog: false,
		search: ""
	}),
	methods: {
		toggleDialog() {
			this.dialog = !this.dialog;
		}
	}
};
</script>