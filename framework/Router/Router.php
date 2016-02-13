<?php

namespace Framework\Router;

/**
* Router.php
*/

class Router{

	/**
	 * Variable for keeping routes
	 *
	* @var array
	*/

	protected static $map = array();

	/**
	 * Push values in var map for following parsing
	 *
	 * Router constructor.
	 * @param array $routing_map
	 */

	public function __construct($routing_map = array()){
		self::$map = $routing_map;
	}

	/** The method parses route.
	 * If the rout exists returns correct way, in other way returns null.
	 *
	 * @param $url
	 * @return null
	 */

	public function parseRoute($url) {

		$route_found = null;

		foreach (self::$map as $route) {

			$pattern = $this->prepare($route);

			if (preg_match($pattern, $url, $params)) {

				preg_match($pattern, str_replace(array('{', '}'), '', $route['pattern']), $param_names);

				$params = array_map('urldecode', $params);
				$params = array_combine($param_names, $params);

				array_shift($params); // Get rid of 0 element
				$route_found = $route;
				$route_found['params'] = $params;

				break;
			}
		}

		return $route_found;
	}

	/**
	 * Create a rout from current params
	 *
	 * @param $route_name
	 * @param array $params
	 */
	public function buildRoute($route_name, $params = array()){
		// @TODO: Your code...
	}

	/**
	 * Returns prepared route for parsing
	 *
	 * @param $route
	 * @return mixed|string
	 */
	private function prepare($route){
		$pattern = preg_replace('~\{[\w\d_]+\}~Ui','([\w\d_]+)', $route['pattern']);
		$pattern = '~^'. $pattern.'$~';

		return $pattern;
	}
}
