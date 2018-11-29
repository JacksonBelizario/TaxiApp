import Vue from "vue";
import VueRouter from "vue-router";
import "./plugins/vuetify";
import App from "./App.vue";
import "roboto-fontface/css/roboto/roboto-fontface.css";
import "material-design-icons-iconfont/dist/material-design-icons.css";
import VueGeolocation from "vue-browser-geolocation";
import axios from './backend/vue-axios'

Vue.config.productionTip = false;

Vue.use(VueGeolocation);
Vue.use(VueRouter);

const router = new VueRouter({
	mode: 'history',
	routes: [
		{
			path: '/',
			redirect: '/login',
			name: 'App',
			component: App,
			children: [
				{
					path: "/login",
					name: "Login",
					component: () => import(`@/pages/Login.vue`),
				},
				{
					path: "/home",
					name: "Home",
					component: () => import(`@/pages/Home.vue`),
				},
			]
		},
		// {
		// 	path: "/sample/:id?",
		// 	name: "Sample",
		// 	component: Sample,
		// 	props: true,
		// 	beforeEnter: (to, from, next) => {
		// 		if([1, 2].includes(localStorage.token)) {
		// 			next();
		// 		}
		// 	}
		// },
	]
  })

new Vue({
	router,
	axios,
	render: h => h(App)
}).$mount("#app");
