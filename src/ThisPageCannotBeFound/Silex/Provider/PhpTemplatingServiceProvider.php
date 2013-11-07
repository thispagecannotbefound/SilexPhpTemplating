<?php

namespace ThisPageCannotBeFound\Silex\Provider;

use Silex\ServiceProviderInterface;

/**
 * @author Abel de Beer <abel@thispagecannotbefound.com>
 */
class PhpTemplatingServiceProvider implements ServiceProviderInterface {

	public function boot(\Silex\Application $app) {

	}

	public function register(\Silex\Application $app) {
		if (!class_exists('Symfony\\Component\\Templating\\PhpEngine')) {
			throw new \LogicException('You must register the Symfony Templating Component to use the PhpTemplatingServiceProvider');
		}
	}

}
