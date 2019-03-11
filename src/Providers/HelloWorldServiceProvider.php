<?php
namespace PivotPlugin\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Modules\Item\Item\Models;



/**
 * Class HelloWorldServiceProvider
 * @package PivotPlugin\Providers
 */
class HelloWorldServiceProvider extends ServiceProvider
{

	/**
	 * Register the service provider.
	 */
	public function register()
	{
		$this->getApplication()->register(HelloWorldRouteServiceProvider::class);


	}
}
