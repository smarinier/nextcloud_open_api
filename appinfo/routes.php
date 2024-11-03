<?php

return ['routes' => [
	[
		'name' => 'page#index',
		'url' => '/',
		'verb' => 'GET',
	],
	[
		'name' => 'openApi#index',
		'url' => '/openapi',
		'verb' => 'GET'
	],
	[
		'name' => 'openApi#get',
		'url' => '/openapi/{appId}',
		'verb' => 'GET'
	],
	// The following route is there to prevent redirection to NC's general homepage
	// when reloading a page in the application (If we don't add it all pages that
	// don't have a route registered here redirect to NC's general homepage upon refresh)
	[
		'name' => 'page#index',
		'url' => '/{path}',
		'verb' => 'GET',
		'requirements' => ['path' => '.*'],
		'defaults' => ['path' => 'dummy'],
		'postfix' => 'catchall',
	]
],
];
