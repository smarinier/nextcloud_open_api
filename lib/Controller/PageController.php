<?php

namespace OCA\OpenApiUI\Controller;

use OCA\OpenApiUI\AppInfo\Application;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\Attribute\OpenAPI;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\Util;

#[OpenAPI(scope: OpenAPI::SCOPE_IGNORE)]
class PageController extends Controller {
	public function __construct() {
	}

	/**
	 * Application's main page
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	#[NoCSRFRequired]
	#[NoAdminRequired]
	public function index(): TemplateResponse {
		Util::addScript(Application::APP_ID, 'open_api-main');		// js/open_api-main.js
		Util::addStyle(Application::APP_ID, 'open_api-main');		// css/open_api-main.css

		return new TemplateResponse('open_api', 'index');
	}
}
