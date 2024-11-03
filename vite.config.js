import { createAppConfig } from '@nextcloud/vite-config'
import { defineConfig } from 'vite'
import path from 'path';

export default createAppConfig({
    // entry points: {name: script}
    main: 'src/main.ts'
}, {
	config: defineConfig({
		resolve: {
			alias: {
		  		'@': path.resolve(__dirname, 'src')
			}
	  	},
	})
})

