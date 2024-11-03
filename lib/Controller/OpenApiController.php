<?php

namespace OCA\OpenApiUI\Controller;

use OCA\OpenApiUI\ResponseDefinitions;
use OCP\App\IAppManager;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\Attribute\OpenAPI;
use OCP\AppFramework\Http\Attribute\PublicPage;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IURLGenerator;

/**
 * @psalm-import-type OpenApiUIAppsListInfo from ResponseDefinitions
 * @psalm-import-type OpenApiUIAppInfo from ResponseDefinitions
 * @psalm-import-type OpenApiUIOpenApi from ResponseDefinitions
 */

class OpenApiController extends Controller {

	public const CORE_KEY = '_core_';

	public function __construct(
		private IAppManager $appManager,
		private IURLGenerator $urlGenerator,
	) {
	}

	/**
	 * List open apis available
	 *
	 * @return JSONResponse<Http::STATUS_OK, OpenApiUIAppsListInfo, array{}>, array<empty>, array{}>
	 *
	 * 200: Application list returned successfully
	 */
	#[NoCSRFRequired]
	#[PublicPage]
	public function index(): JSONResponse {
		$search = $this->appManager->getInstalledApps();
		$always = $this->appManager->getAlwaysEnabledApps();
		$apps = [];
		foreach ($search as $app) {
			if ($this->appManager->isEnabledForUser($app)) {
				$appPath = $this->appManager->getAppPath($app);
				if (file_exists($appPath . '/openapi.json')) {
					$appInfo = $this->appManager->getAppInfo($app);
					$appInfo = array_filter($appInfo, function ($k) {
						return in_array($k, ['id', 'name', 'version']);
					}, ARRAY_FILTER_USE_KEY);
					$appInfo['standard'] = in_array($app, $always);
					$preview = $this->getPreview($app, $appPath);
					if ($preview !== null) {
						$appInfo['preview'] = $preview;
					}
					$apps[] = $appInfo;
				}
			}
		}
		if (file_exists(\OC::$SERVERROOT . '/core/openapi.json')) {
			$apps[] = [
				'id' => self::CORE_KEY,
				'name' => 'Core Nextcloud API',
				'version' => \OC_Util::getVersionString(),
				'standard' => true,
				'preview' => $this->urlGenerator->imagePath('core', 'logo/logo.svg')
			];
		}

		return new JSONResponse($apps);
	}

	/**
	 * get OpenAPI definition for an app appId
	 *
	 * @param string $appId Application ID
	 *
	 * @return JSONResponse<Http::STATUS_OK, OpenApiUIOpenApi, array{}>|JSONResponse<Http::STATUS_FORBIDDEN|Http::STATUS_NOT_FOUND, array<empty>, array{}>
	 *
	 * 200: Application OpenApi description returned successfully
	 * 403: Application OpenApi is not available for current user
	 * 404: Application OpenApi description not found
	 */
	#[NoCSRFRequired]
	#[PublicPage]
	public function get(string $appId): JSONResponse {

		if ($appId === self::CORE_KEY) {
			$filepath = \OC::$SERVERROOT . '/core/openapi.json';
		} else {
			if (!$this->appManager->isEnabledForUser($appId)) {
				return new JSONResponse([], Http::STATUS_FORBIDDEN);
			}
			$filepath = $this->appManager->getAppPath($appId) . '/openapi.json';
		}

		if (file_exists($filepath)) {
			$json = file_get_contents($filepath);
			$res = json_decode($json);
			return new JSONResponse($res);
		} else {
			return new JSONResponse([], Http::STATUS_NOT_FOUND);
		}
	}

	private function getPreview(string $app, string $appPath) : ?string {
		$appIcon = $appPath . '/img/' . $app . '.svg';
		if (file_exists($appIcon)) {
			return $this->urlGenerator->imagePath($app, $app . '.svg');
		} else {
			$appIcon = $appPath . '/img/app.svg';
			if (file_exists($appIcon)) {
				return $this->urlGenerator->imagePath($app, 'app.svg');
			}
		}
		return null;
	}
}
