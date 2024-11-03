<?php

namespace OCA\OpenApiUI\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap {
	public const APP_ID = 'open_api';

	/**
	 * Application constructor.
	 *
	 * @param array $params
	 * @throws \OCP\AppFramework\QueryException
	 */
	public function __construct(array $params = []) {
		parent::__construct(self::APP_ID, $params);
	}

	public function register(IRegistrationContext $context): void {
	}

	public function boot(IBootContext $context): void {
	}

	public static function getL10N() {
		return \OC::$server->getL10N(Application::APP_ID);
	}
}
