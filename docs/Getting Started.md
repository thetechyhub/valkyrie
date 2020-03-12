# Getting Started

## Create new Laravel project

```
  composer create-project --prefer-dist laravel/laravel workshop "6.*"
```

## Clean up

Delete some of the default Laravel folders and files, this is just to keep things neat.

* Remove the default routes inside the routes folder, don't delete the folder **just the code**.
* Remove the default `Auth` controllers **folder**.
* Remove the default `models`, `migrations`, `seed` and `factories` **files**.
* Remove all resource **folders** except for the `lang` folder.
* Run composer dumpautoload to make sure there are no issues.


## The Modules Package

Thanks to [nWidart](https://github.com/nWidart), there is a package available that helps in creating 
the boilerplate structure and the necessary setup.

The package can be found on [Github](https://github.com/nWidart/laravel-modules) and there is also a link to the documentation if you want to read more.

Install the package by running 

```
  composer require nwidart/laravel-modules
```


Then publish the config file

```
  php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

Next you need to add the following code to your `composer.json` and run `composer dumpautoload`.

```

{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
-->   "Modules\\": "Modules/"
    }
  }
}

```

This line of code will tell Laravel where to look to find your modules. After running `composer dumpautoload`, 
open up the `config` file, which can be found in the in `config/modules.php` and update the following lines.

```
'generator' => [
      'config' => ['path' => 'Config', 'generate' => true],
      'command' => ['path' => 'Console', 'generate' => true],
      'migration' => ['path' => 'Database/Migrations', 'generate' => true],
      'seeder' => ['path' => 'Database/Seeders', 'generate' => true],
      'factory' => ['path' => 'Database/factories', 'generate' => true],
      'model' => ['path' => 'Entities', 'generate' => true],
      'routes' => ['path' => 'Routes', 'generate' => true],
      'controller' => ['path' => 'Http/Controllers', 'generate' => true],
      'filter' => ['path' => 'Http/Middleware', 'generate' => true],
      'request' => ['path' => 'Http/Requests', 'generate' => false], <------
      'provider' => ['path' => 'Providers', 'generate' => true],
      'assets' => ['path' => 'Resources/assets', 'generate' => true],
      'lang' => ['path' => 'Resources/lang', 'generate' => true],
      'views' => ['path' => 'Resources/views', 'generate' => true],
      'test' => ['path' => 'Tests/Unit', 'generate' => true],
      'test-feature' => ['path' => 'Tests/Feature', 'generate' => true],
      'repository' => ['path' => 'Repositories', 'generate' => true],  <------
      'event' => ['path' => 'Events', 'generate' => false],
      'listener' => ['path' => 'Listeners', 'generate' => false],
      'policies' => ['path' => 'Policies', 'generate' => false],
      'rules' => ['path' => 'Rules', 'generate' => false],
      'jobs' => ['path' => 'Jobs', 'generate' => false],
      'emails' => ['path' => 'Emails', 'generate' => false],
      'notifications' => ['path' => 'Notifications', 'generate' => false],
      'resource' => ['path' => 'Transformers', 'generate' => false],
  ],
],
```

This tells the package which files to generate and where they should be created. Next update the `composer` attribute.

```
'composer' => [
  'vendor' => 'thetechyhub',
  'author' => [
    'name' => 'The Techy Hub',
    'email' => 'thetechyhub@gmail.com',
  ],
],
```

## Create Internal Module

The package that we installed, has some helpful artisan commands that can help us create new modules. 

Run `php artisan module:make Core` to generate a new module named Core. The line will create a new folder in the root
of your project. Inside that folder you will see your module `Core`.

The default structure of the module does not match what we need, so we will need to modify it.


### The Default Structure

```
app/
bootstrap/
vendor/
Modules/
  ├── Core/
      ├── Assets/
      ├── Config/
      ├── Console/
      ├── Database/
          ├── Migrations/
          ├── Seeders/
      ├── Entities/
      ├── Http/
          ├── Controllers/
          ├── Middleware/
          ├── Requests/
      ├── Providers/
          ├── BlogServiceProvider.php
          ├── RouteServiceProvider.php
      ├── Resources/
          ├── assets/
              ├── js/
                ├── app.js
              ├── sass/
                ├── app.scss
          ├── lang/
          ├── views/
      ├── Routes/
          ├── api.php
          ├── web.php
      ├── Repositories/
      ├── Tests/
      ├── composer.json
      ├── module.json
      ├── package.json
      ├── webpack.mix.js

```


### The Needed Structure


```
app/
bootstrap/
vendor/
Modules/
  ├── Core/
    ├── src/
      ├── Config/
      ├── Database/
      ├── Entities/
      ├── Providers/
      ├── Repositories/
      ├── Tests/
      Core.php
    ├── composer.json
    ├── module.json
```


### Understanding the Service Provider

Service providers are the connection points between your package and Laravel. A service provider is responsible for 
binding things into Laravel's service container and informing Laravel where to load package resources such as views, 
configuration, and localization files, ([Laravel](https://laravel.com/docs/5.8/packages#service-providers), 2020).

Each module has a service provider that defines the module resources. By default this file (which can be found inside the `Provider` dirctory)
has some predefined function calls inside the `boot` method. which help register the module resources.

Since we changed our module default structure, we will need to update the `CoreServiceProvider.php` to match our modification.

* Update the `boot` method:
Before:
```
 /**
   * Boot the application events.
   *
   * @return void
   */
  public function boot(){
    $this->registerTranslations();
    $this->registerConfig();
    $this->registerViews();
    $this->registerFactories();
    $this->loadMigrationsFrom(module_path('UI', 'Database/Migrations'));
  }
```
We will remove the **registerTranslations**, **registerViews**, and update the path to the **loadMigrationsFrom** folder.
After:
```
 /**
   * Boot the application events.
   *
   * @return void
   */
  public function boot(){
    $this->registerConfig();
    $this->registerFactories();
    $this->loadMigrationsFrom(module_path('Core', 'src/Database/Migrations')); <---
  }
```

Since we have removed the calling of the registerTranslations and registerViews functions, we can remove the function within this file as well. Scroll down and you will see these two functions. **Remove them**.


* Update the `register` method:

The register method has one job, which is to call the `RoutesServiceProvider` this provider is what register our routes.
Since this module is an internal module, we don't need that Service Provider, so remove the following line and delete the `RouteServiceProvider` class.

```
$this->app->register(RouteServiceProvider::class);
```

* Create the module Interface:

Inside the `src` folder, create a new class that has the same name as the module name. For instance `Core.php` for this module.
This would allow other module to interact with this module through using this class. For now just add the namespace and keep the class empty.

* Update registerConfig method:

Inside the `registerConfig` function, change the code to the below one:
```
/**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Core', 'src/Config/config.php') => config_path('core.php'), <---
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Core', 'src/Config/config.php'), 'core' <---
        );
    }
```
* Update the registerFactories method

Inside the `registerFactories` function, change the code to the below one:
```
/**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Core', 'src/Database/factories'));
        }
    }
```

### Updating composer 

This step is only necessary because we changed the default structure of the module, so you don't repeat this step for other modules.

Inside the main composer.json in the root of your project add the following line.

```
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "Modules/",
-->   "Core\\": "Modules/Core/src"
    }
  }
}


```

The extra line will map the namespace `Modules\Core` to `Modules\Core\src` without having to do this yourself 
everytime you need to use this module from other modules.


### Finally Run Composer Dumpautoload

That is it your module is ready


## Create Public Facing Module

```
Comming Soon

```






