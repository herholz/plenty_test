<?php
namespace PivotPlugin\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Class HelloWorldRouteServiceProvider
 * @package PivotPlugin\Providers
 */
class HelloWorldRouteServiceProvider extends RouteServiceProvider
{
	/**
	 * @param Router $router
	 */
	public function map(Router $router)
	{
		$router->get('hello', 'PivotPlugin\Controllers\ContentController@sayHello');
        $router->get('test', 'PivotPlugin\Controllers\ContentControllerNew@showTopItems');
        $router->get('pivot', 'PivotPlugin\Controllers\ContentControllerNew@showPivot');
	}

	public function register()
        {
          
        }

}
