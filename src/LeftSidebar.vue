<template>
	<NcAppNavigation>
		<NcAppNavigationCaption heading-id="nextcloud-api-heading"
			is-heading="true"
			name="Nextcloud Apis" />
		<NcAppNavigationList aria-labelledby="nextcloud-api-heading">
			<NcAppNavigationItem v-for="app in standardApps"
				:key="app.id"
				:name="app.name"
				:to="{path: `/swagger/${app.id}`}">
				<template #icon>
					<AppIcon v-if="app.preview"
						:href="app.preview" />
					<ApiIcon v-else />
				</template>
			</NcAppNavigationItem>
		</NcAppNavigationList>
		<NcAppNavigationCaption heading-id="standard-api-heading"
			is-heading="true"
			name="Application Apis" />
		<NcAppNavigationList aria-labelledby="standard-api-heading">
			<NcAppNavigationItem v-for="app in installedApps"
				:key="app.id"
				:name="app.name"
				:to="{path: `/swagger/${app.id}`}">
				<template #icon>
					<AppIcon v-if="app.preview"
						:href="app.preview" />
					<ApiIcon v-else />
				</template>
			</NcAppNavigationItem>
		</NcAppNavigationList>
	</NcAppNavigation>
</template>

<script>
import NcAppNavigation from '@nextcloud/vue/dist/Components/NcAppNavigation.js'
import NcAppNavigationCaption from '@nextcloud/vue/dist/Components/NcAppNavigationCaption.js'
import NcAppNavigationList from '@nextcloud/vue/dist/Components/NcAppNavigationList.js'
import NcAppNavigationItem from '@nextcloud/vue/dist/Components/NcAppNavigationItem.js'
import AppIcon from './AppIcon.vue'
import ApiIcon from 'vue-material-design-icons/Api.vue'
import { useAppsStore } from './store'

const store = useAppsStore()

export default {
	name: 'LeftSidebar',
	components: {
		NcAppNavigation,
		NcAppNavigationList,
		NcAppNavigationItem,
		NcAppNavigationCaption,
		AppIcon,
		ApiIcon,
	},
	computed: {
		apps() {
			const apps = store.apps
				.sort(function(a, b) {
					// core nextcloud always first
					if (a.id === '_core_') return -1
					if (b.id === '_core_') return 1
					return OC.Util.naturalSortCompare(a.name, b.name)
				})
			return apps
		},
		standardApps() {
			return this.apps.filter(app => app.standard)
		},
		installedApps() {
			return this.apps.filter(app => !app.standard)
		},
	},
}
</script>
