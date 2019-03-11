<?php
namespace PivotPlugin\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;
use Plenty\Plugin\Routing\ApiRouter;

/**
 * Class HelloWorldRouteServiceProvider
 * @package PivotPlugin\Providers
 */
class HelloWorldRouteServiceProvider extends RouteServiceProvider
{
	/**
	 * @param Router $router
	 */
	/*public function map(Router $router)
	{
		$router->get('hello', 'PivotPlugin\Controllers\ContentController@sayHello');
        $router->get('test', 'PivotPlugin\Controllers\ContentControllerNew@showTopItems');
        $router->get('pivot', 'PivotPlugin\Controllers\ContentControllerNew@showPivot');
	}*/

    public function map(ApiRouter $api)
    {
        $api->version(['v1'], ['namespace' => 'PivotPlugin\Controllers', 'middleware' => ['oauth']], function ($api)
        {
            $api->get('/pivot', 'ContentControllerNew@showPivot');
        });
    }

	public function register()
        {
          
        }

}
