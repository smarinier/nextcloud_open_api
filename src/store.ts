
import { defineStore, PiniaVuePlugin, setActivePinia, createPinia } from 'pinia'
import axios from '@nextcloud/axios'
import { showError } from '@nextcloud/dialogs'
import { generateUrl } from '@nextcloud/router'
import Vue from 'vue'

const showApiError = () => showError(t('settings', 'An error occurred during the request. Unable to proceed.'))

export interface IAppstoreApp {
	id: string
	name: string
	version: string
	preview?: string
}

// use pinia
Vue.use(PiniaVuePlugin)
export const pinia = createPinia();
setActivePinia(pinia);

export const useAppsStore = defineStore('open_api-apps', {
	state: () => ({
		loading: true,
		apps: [] as IAppstoreApp[],
	}),

	actions: {

		async loadApps() {
			if (this.apps.length > 0) {
				return
			}

			try {
				this.loading = true
				const { data } = await axios.get<{ apps: IAppstoreApp[] }>(generateUrl('/apps/open_api/openapi'))

				this.$patch({
					apps: data,
				})
			} catch (error) {
				showApiError()
			} finally {
				this.loading = false
			}
		},

		getAppById(appId: string): IAppstoreApp|null {
			return this.apps.find(({ id }) => id === appId) ?? null
		},
	},
})
