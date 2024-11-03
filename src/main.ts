import Vue from 'vue'
import router from './router'
import { useAppsStore, pinia } from './store'
import App from './App.vue'
import { translate as t, translatePlural as n } from '@nextcloud/l10n'
import 'swagger-ui/dist/swagger-ui.css';

Vue.mixin({
	methods: {
		t,
		n,
	},
})

Vue.config.devtools = process.env.NODE_ENV !== 'production'  // Debug mode

const store = useAppsStore()

export default new Vue({
	el: '#content',
	router,
	store,
	pinia,
	render: (h) => h(App),
})
