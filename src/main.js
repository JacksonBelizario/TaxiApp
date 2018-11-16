import Vue from "vue";
import "./plugins/vuetify";
import App from "./App.vue";
import "roboto-fontface/css/roboto/roboto-fontface.css";
import "material-design-icons-iconfont/dist/material-design-icons.css";
import VueGeolocation from "vue-browser-geolocation";

Vue.config.productionTip = false;

Vue.use(VueGeolocation);

new Vue({
	render: h => h(App)
}).$mount("#app");
