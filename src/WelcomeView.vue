<template>
	<div class="open_api-welcome">
		<NcIconSvgWrapper class="open_api-icon" :svg="IconApi" />
		<div class="open_api-intro">
			{{ text.intro }}
		</div>
		<div class="open_api-descriptions">
			{{ text.description }}
		</div>
		<div class="open_api-help">
			{{ text.help }}
			<NcActions>
				<NcActionLink :href="url.help" target="_blank">
					<template #icon>
						<OpenInNew :size="20" />
					</template>
					Nextcloud OpenApi extractor
				</NcActionLink>
			</NcActions>
		</div>
	</div>
</template>

<script>
import { t } from '@nextcloud/l10n'
import NcIconSvgWrapper from '@nextcloud/vue/dist/Components/NcIconSvgWrapper.js'
import NcActionLink from '@nextcloud/vue/dist/Components/NcActionLink.js'
import NcActions from '@nextcloud/vue/dist/Components/NcActions.js'
import OpenInNew from 'vue-material-design-icons/OpenInNew.vue'

import IconApi from '../img/app-black.svg?raw'

export default {
	name: 'WelcomeView',

	components: {
		NcIconSvgWrapper,
		NcActions,
		NcActionLink,
		OpenInNew,
	},
	setup() {
		// This icons are static data, so you do not need to put them into `data` which will make them reactive
		return {
			IconApi
		}
	},
	computed: {

		text() {
			return {
				intro: t('open_api', 'Choose the application you want to try APIs with.'),
				description: t('open_api', 'Try out and execute API calls. APIs are only available according to your user rights. API calls are authorized according to your user rights.'),
				help: t('open_api', 'If you want your application to be listed here, you can just create an openapi.json file following the Nextcloud documentation.'),
			}
		},
		url() {
			return {
				help: 'https://github.com/nextcloud/openapi-extractor',
			}
		},
	},
}
</script>

<style scoped>
.open_api-welcome {
	height: 100%;
	padding: calc(var(--default-grid-baseline) * 4);
	display: flex;
	align-items: center;
	flex-direction: column;
	justify-content: center;
}

.open_api-icon {
	display: flex;
	align-items: center;
	justify-content: center;
	width: 64px;
	height: 64px;
	margin: 0 auto 15px;
	opacity: 0.4;
	background-repeat: no-repeat;
	background-position: center;
	background-size: 64px;
}

.open_api-intro {
	margin-bottom: 10px;
	text-align: center;
	font-weight: bold;
	font-size: 20px;
	line-height: 30px;
}

.open_api-description {
	color: var(--color-text-maxcontrast);
}

.open_api-help {
	font-style: italic;
	margin-top: 20px;
	font-size: 14px;
	display: inline-flex;
	line-height: 34px;
}

.open_api-help a.button-vue {
	display: inline-flex;
}
</style>
