<?php

namespace ThisPageCannotBeFound\Silex\Tests;

use Silex\Application;
use ThisPageCannotBeFound\Silex\Provider\PhpTemplatingServiceProvider;

/**
 * @author Abel de Beer <abel@thispagecannotbefound.com>
 */
class PhpTemplatingServiceProviderTest extends \PHPUnit_Framework_TestCase {

	/** @var Application */
	protected $app;

	protected function setUp() {
		$this->app = new Application();
	}

	public function testTemplatingComponentNotInstalledThrows() {
		$expectedMessage = 'You must register the Symfony Templating Component to use the PhpTemplatingServiceProvider';

		try {
			$this->app->register(new PhpTemplatingServiceProvider());
		} catch (\Exception $exception) {
			$this->assertInstanceOf('LogicException', $exception);
			$this->assertEquals($expectedMessage, $exception->getMessage());
		}
	}

}
