<?php

namespace ThisPageCannotBeFound\Silex\Application;

use Symfony\Component\HttpFoundation\Response;

/**
 * Twig trait.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
trait PhpTemplatingTrait {

	/**
	 * Renders a view and returns a Response.
	 *
	 * To stream a view, pass an instance of StreamedResponse as a third argument.
	 *
	 * @param string   $view       The view name
	 * @param array    $parameters An array of parameters to pass to the view
	 * @param Response $response   A Response instance
	 *
	 * @return Response A Response instance
	 */
	public function render($view, array $parameters = array(),
			Response $response = null) {
		if (null === $response) {
			$response = new Response();
		}

		$response->setContent($this->renderView($view, $parameters));

		return $response;
	}

	/**
	 * Renders a view.
	 *
	 * @param string $view       The view name
	 * @param array  $parameters An array of parameters to pass to the view
	 *
	 * @return Response A Response instance
	 */
	public function renderView($view, array $parameters = array()) {
		return $this['templating']->render($view, $parameters);
	}

}
