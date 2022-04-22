<?php

declare(strict_types=1);

namespace PHPUnitForGraphQLAPI\GraphQLAPITesting\RESTAPI;

use function add_action;

use PHPUnitForGraphQLAPI\GraphQLAPITesting\RESTAPI\Controllers\AbstractRESTController;
use WC_REST_Controller;

abstract class AbstractRESTAPIEndpointManager
{
	public string $version = 'v1';

	public string $endpoint = '';

	/**
	 * @var WC_REST_Controller[]|string[]
	 */
	public array $controllers = [];

	public function __construct()
	{
		$this->initialize();
	}

	public function initialize()
	{
		if (!class_exists('WP_REST_Server')) {
			return;
		}

		add_action('rest_api_init', $this->registerRoutes(...));
	}

	public function registerRoutes(): void
	{
		foreach ($this->getControllers() as $controller) {
			$this->controllers[get_class($controller)] = $controller;
			$controller->register_routes();
		}
	}

	/**
	 * @return AbstractRESTController[]
	 */
	abstract protected function getControllers(): array;
}
