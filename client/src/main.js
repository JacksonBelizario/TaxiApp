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
		// 	path: "/projetos",
		// 	name: "Projetos",
		// 	component: () => import(`@/components/Projetos.vue`),
		// 	beforeEnter: (to, from, next) => {
		// 		if(from.path != "/") return;
		// 		/**
		// 		 * Administração e Gestão
		// 		 */
		// 		if([1, 2].includes(store.getters.usuario.usuario_cargo) || NODE_ENV == "development") {
		// 			next();
		// 		}
		// 	}
		// },
		// {
		// 	path: "/usuario/:id?",
		// 	name: "Usuario",
		// 	component: Usuario,
		// 	props: true,
		// 	beforeEnter: (to, from, next) => {
		// 		/**
		// 		 * Administração e Gestão
		// 		 */
		// 		/**
		// 		 * O usuário acessa edição apenas de seu próprio perfil
		// 		 */
		// 		if([1, 2].includes(store.getters.usuario.usuario_cargo) || to.params.id == store.getters.usuario.id_pessoa || NODE_ENV == "development") {
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
