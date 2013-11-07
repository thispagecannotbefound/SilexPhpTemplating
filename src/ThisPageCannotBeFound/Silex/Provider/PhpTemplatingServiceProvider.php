<?php

namespace ThisPageCannotBeFound\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Templating\Helper\SlotsHelper;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

/**
 * @author Abel de Beer <abel@thispagecannotbefound.com>
 */
class PhpTemplatingServiceProvider implements ServiceProviderInterface {

	public function boot(Application $app) {

	}

	public function register(Application $app) {
		if (!class_exists('Symfony\\Component\\Templating\\PhpEngine')) {
			throw new \LogicException('You must register the Symfony Templating Component to use the PhpTemplatingServiceProvider');
		}

		$app['templating.paths'] = $app->share(function() use($app) {
					return array();
				});

		$app['templating.helpers'] = $app->share(function() use($app) {
					return array();
				});

		$app['templating'] = $app->share(function() use($app) {
					$engine = $app['templating.engine'];

					// set helpers
					$helpers = array_merge($app['templating.helpers'],
							$app['templating.default_helpers']);
					$engine->setHelpers($helpers);

					// add app global
					$engine->addGlobal('app', $app);

					return $engine;
				});

		$app['templating.engine'] = $app->share(function() use($app) {
					return new PhpEngine($app['templating.parser'], $app['templating.loader']);
				});

		$app['templating.parser'] = $app->share(function() use($app) {
					return new TemplateNameParser();
				});

		$app['templating.loader'] = $app->share(function() use($app) {
					$paths = (array) $app['templating.paths'];
					$nameParam = '%name%';

					foreach ($paths as $key => $path) {
						// add name param if it is missing
						if (strpos($path, $nameParam) === false) {
							if (substr($path, -1) !== '/') {
								$path .= '/';
							}

							$path .= $nameParam;
							$paths[$key] = $path;
						}
					}

					return new FilesystemLoader($paths);
				});

		$app['templating.default_helpers'] = $app->share(function() use($app) {
					return array(new SlotsHelper());
				});
	}

}
