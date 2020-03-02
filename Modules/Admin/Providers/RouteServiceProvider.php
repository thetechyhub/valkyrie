<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider{

	/**
	 * The module namespace to assume when generating URLs to actions for Browser.
	 *
	 * @var string
	 */
	protected $browser_moduleNamespace = 'Modules\Admin\Http\Controllers';

	/**
	 * The module namespace to assume when generating URLs to actions for API.
	 *
	 * @var string
	 */
	protected $api_moduleNamespace = 'Modules\Admin\Http\Controllers\API';

  /**
   * Called before routes are registered.
   *
   * Register any model bindings or pattern based filters.
   *
   * @return void
   */
  public function boot(){
    parent::boot();
  }

  /**
   * Define the routes for the application.
   *
   * @return void
   */
  public function map(){
    $this->mapApiRoutes();
    $this->mapWebRoutes();
  }

  /**
   * Define the "web" routes for the application.
   *
   * These routes all receive session state, CSRF protection, etc.
   *
   * @return void
   */
  protected function mapWebRoutes(){
		Route::domain($this->domain("admin"))
      ->name('admin.')
      ->middleware('web')
			->namespace($this->browser_moduleNamespace)
			->group(module_path('Admin', '/Routes/web.php'));
  }

  /**
   * Define the "api" routes for the application.
   *
   * These routes are typically stateless.
   *
   * @return void
   */
  protected function mapApiRoutes(){
    Route::domain($this->domain("admin"))
      ->name('admin.')
      ->middleware('api')
      ->namespace($this->api_moduleNamespace)
      ->group(module_path('Admin', '/Routes/api.php'));
  }


	/**
   * Set the domain of the application based on the env variable
   *
   * @return void
   */
	private function domain(string $subdomain = ''){
		if (strlen($subdomain) > 0) {
			$subdomain = "{$subdomain}.";
		}

		return config('app.domain_prefix') . $subdomain . config('app.domain');
	}
}
