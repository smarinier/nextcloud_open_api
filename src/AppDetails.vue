<template>
	<div>
		<div class="api-content__header">
			<span>{{ appDetails.name }}</span><span class="api-content__header__version">{{ appDetails.version }}</span>
		</div>
		<SwaggerUI :key="appDetails.id" :appid="appDetails.id" />
	</div>
</template>

<script>
import { useAppsStore } from './store'
import SwaggerUI from './SwaggerUI.vue'

const store = useAppsStore()

export default {
	name: 'AppDetails',
	components: {
		SwaggerUI,
	},
	computed: {
		// The title to display at the top of the page
		appDetails() {
			return store.getAppById(this.$route.params.app)
		},
	},
}
</script>
