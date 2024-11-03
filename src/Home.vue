<template>
	<NcContent id="content" app-name="open_api">
		<LeftSidebar />
		<ApiContent />
	</NcContent>
</template>

<script>
import NcContent from '@nextcloud/vue/dist/Components/NcContent.js'
import LeftSidebar from './LeftSidebar.vue'
import ApiContent from './ApiContent.vue'
import { useAppsStore } from './store'

const store = useAppsStore()

export default {
	name: 'Home',
	components: {
		NcContent,
		LeftSidebar,
		ApiContent,
	},
	beforeMount() {
		store.loadApps()
	},
	beforeCreate() {
		if (this.$root.$data.canAccessApp === 'false') {
			this.$router.push({
				path: '/unauthorized',
			})
		}
	},
}
</script>
