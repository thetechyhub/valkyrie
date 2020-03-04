<?php

namespace Modules\Identity\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class IdentityServiceProvider extends ServiceProvider{
	
  /**
   * Boot the application events.
   *
   * @return void
   */
  public function boot(){
    $this->registerConfig();
    // $this->registerTranslations();
    // $this->registerViews();
    $this->registerFactories();
    $this->loadMigrationsFrom(module_path('Identity', 'Database/Migrations'));
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register(){
    $this->app->register(RouteServiceProvider::class);
  }

  /**
   * Register config.
   *
   * @return void
   */
  protected function registerConfig(){
    $this->publishes([
      module_path('Identity', 'Config/config.php') => config_path('identity.php'),
    ], 'config');
    $this->mergeConfigFrom(
      module_path('Identity', 'Config/config.php'), 'identity'
    );
  }

  /**
   * Register views.
   *
   * @return void
   */
  public function registerViews(){
    $viewPath = resource_path('views/modules/identity');
    $sourcePath = module_path('Identity', 'Resources/views');

    $this->publishes([
      $sourcePath => $viewPath
    ],'views');

    $this->loadViewsFrom(array_merge(array_map(function ($path) {
      return $path . '/modules/identity';
    }, Config::get('view.paths')), [$sourcePath]), 'identity');
  }

  /**
   * Register translations.
   *
   * @return void
   */
  public function registerTranslations(){
    $langPath = resource_path('lang/modules/identity');

    if (is_dir($langPath)) {
      $this->loadTranslationsFrom($langPath, 'identity');
    } else {
      $this->loadTranslationsFrom(module_path('Identity', 'Resources/lang'), 'identity');
    }
  }

  /**
   * Register an additional directory of factories.
   *
   * @return void
   */
  public function registerFactories(){
    if (! app()->environment('production') && $this->app->runningInConsole()) {
      app(Factory::class)->load(module_path('Identity', 'Database/factories'));
    }
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides(){
    return [];
  }
}
