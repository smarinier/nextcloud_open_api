<template>
	<NcAppContent>
		<NcAppContentDetails>
			<div v-if="isLoading">
				<NcLoadingIcon :size="64" appearance="dark" name="Loading on light background" />
			</div>
			<div v-else class="api-content">
				<router-view />
			</div>
		</NcAppContentDetails>
	</NcAppContent>
</template>

<script>
import NcAppContent from '@nextcloud/vue/dist/Components/NcAppContent.js'
import NcAppContentDetails from '@nextcloud/vue/dist/Components/NcAppContentDetails.js'
import NcLoadingIcon from '@nextcloud/vue/dist/Components/NcLoadingIcon.js'
import { useAppsStore } from './store'

const store = useAppsStore()

export default {
	name: 'ApiContent',
	components: {
		NcAppContent,
		NcAppContentDetails,
		NcLoadingIcon,
	},
	computed: {
		isLoading() {
			return store.loading
		},
	},
}
</script>

<style lang="scss">
.api-content {
	height: 100%;
	width: 100%;

	&__header {
		display: flex;
		align-items: center;
		// Do not grow or shrink (vertically)
		flex: 0 0;
		max-width: 100%;
		// Align with the navigation toggle icon
		margin-block: var(--app-navigation-padding, 4px);
		margin-inline: calc(var(--default-clickable-area, 44px) + 2 * var(--app-navigation-padding, 4px)) var(--app-navigation-padding, 4px);

		min-height: var(--default-clickable-area);
		font-weight: 700;

		&__version {
			margin-left: 20px;
		}
	}
}

.app-content-details {
	display: flex;
	justify-content: center;
	align-items: center;
	height: 100%;
}

</style>
