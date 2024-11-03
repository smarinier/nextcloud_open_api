<template>
	<div id="swagger-ui" />
</template>
<script>
import JSSwaggerUI from 'swagger-ui'
import { getRootUrl, generateUrl } from '@nextcloud/router'

const DisableAuthorizePlugin = function() {
	return {
		wrapComponents: {
			authorizeBtn: () => () => null,
		},
	}
}
export default {
	name: 'SwaggerUI',
	props: {
		appid: { type: String, default: '' },
	},
	mounted() {
		const rootUrl = getRootUrl()
		JSSwaggerUI({
			url: generateUrl('apps/open_api/openapi/' + this.appid),
			dom_id: '#swagger-ui',
			presets: [
				JSSwaggerUI.presets.apis,
			],
			plugins: [
				DisableAuthorizePlugin,
			],
			requestInterceptor: (req) => {
				if (rootUrl !== '/') {
					const p1 = req.url.indexOf('//')
					if (p1 > 0) {
						const p2 = req.url.indexOf('/', p1 + 2)
						if (p2 > 0) {
							req.url = req.url.substr(0, p2) + rootUrl + req.url.substr(p2)
						}
					}
				}
				return req
			},
			layout: 'BaseLayout',
		})
	},
}
</script>
