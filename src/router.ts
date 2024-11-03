
import Vue from 'vue'
import Router from 'vue-router'
import { generateUrl } from '@nextcloud/router'
import Home from './Home.vue'
import AppDetails from './AppDetails.vue'
import WelcomeView from './WelcomeView.vue'

Vue.use(Router)

export default new Router({
	mode: 'history',
	base: generateUrl('/apps/open_api/'),
	linkActiveClass: 'active',
	routes: [
		{
			path: '/',
			component: resolve => resolve(Home),
			children: [
				{
					path: '',
					component: WelcomeView,
				},
				{
					path: 'swagger/:app',
					component: AppDetails,
				},
			],
		},
	],
})
