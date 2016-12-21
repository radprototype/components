# Laravel-Components

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rad-laravel/components.svg?style=flat-square)](https://packagist.org/packages/rad-laravel/components)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/rad-laravel/components/master.svg?style=flat-square)](https://travis-ci.org/rad-laravel/components)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/rad-laravel/components.svg?maxAge=86400&style=flat-square)](https://scrutinizer-ci.com/g/rad-laravel/components/?branch=master)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/25320a08-8af4-475e-a23e-3321f55bf8d2.svg?style=flat-square)](https://insight.sensiolabs.com/projects/25320a08-8af4-475e-a23e-3321f55bf8d2)
[![Quality Score](https://img.shields.io/scrutinizer/g/rad-laravel/components.svg?style=flat-square)](https://scrutinizer-ci.com/g/rad-laravel/components)
[![Total Downloads](https://img.shields.io/packagist/dt/rad-laravel/components.svg?style=flat-square)](https://packagist.org/packages/rad-laravel/components)


- [Installation](#installation)
- [Configuration](#configuration)
- [Naming Convension](#naming-convension)
- [Folder Structure](#folder-structure)
- [Creating Component](#creating-a-component)
- [Artisan Commands](#artisan-commands)
- [Facades](#facades)
- [Entity](#entity)
- [Auto Scan Vendor Directory](#auto-scan-vendor-directory)
- [Publishing Components](#publishing-components)


<a name="installation"></a>
## Installation

### Quick

Just clone it or install using composer point to this repo.

#### Add Service Provider

Add the following service provider in `config/app.php`.

```php
'providers' => [
  Rad\Components\ServiceProvider::class,
],
```

Add the following aliases to `aliases` array in the same file.

```php
'aliases' => [
  'Component' => Rad\Components\Facades\Component::class,
],
```

Publish the package's configuration file by running :

```
php artisan vendor:publish --provider="Rad\Components\ServiceProvider"
```

<a name="configuration"></a>
## Configuration

- `components` - Used for save the generated components.
- `assets` - Used for save the components's assets from each components.
- `migration` - Used for save the components's migrations if you publish the components's migrations.
- `seed` - Used for save the components's seeds if you publish the components's seeds.
- `generator` - Used for generate components folders.
- `scan` - Used for allow to scan other folders.
- `enabled` - If `true`, the package will scan other paths. By default the value is `false`
- `paths` - The list of path which can scanned automatically by the package.
- `composer`
- `vendor` - Composer vendor name.
- `author.name` - Composer author name.
- `author.email` - Composer author email.
- `cache`
- `enabled` - If `true`, the scanned components (all components) will cached automatically. By default the value is `false`
- `key` - The name of cache.
- `lifetime` - Lifetime of cache.

## Setting up components folders for first use

```
php artisan component:setup
```

<a name="creating-a-component"></a>
## Creating A Component

To create a new component you can simply run :

```
php artisan component:make <component-name>
```

- `<component-name>` - Required. The name of component will be created.

**Create a new component**

```
php artisan component:make Blog
```

**Create multiple components**

```
php artisan component:make Blog User Auth
```

By default if you create a new component, that will add some resources like controller, seed class or provider automatically. If you don't want these, you can add `--plain` flag, to generate a plain component.

```shell
php artisan component:make Blog --plain
#OR
php artisan component:make Blog -p
```

<a name="naming-convension"></a>
**Naming Convension**

Because we are autoloading the components using `psr-4`, we strongly recommend using `StudlyCase` convension.

<a name="folder-structure"></a>
**Folder Structure**

```
your-laravel/app/Components/
  ├── Blog/
      ├── Config/
      ├── Console/
      ├── Database/
          ├── Migrations/
          ├── Seeds/
      ├── Emails/
      ├── Events/
      ├── Http/
          ├── Controllers/
          ├── Middleware/
          ├── Requests/
          ├── routes.php
      ├── Jobs/
      ├── Models/
      ├── Notifications/
      ├── Providers/
      ├── Repositories/
      ├── Resources/
          ├── assets/
          ├── lang/
          ├── views/
      ├── Tests/
      ├── composer.json
      ├── component.json
      ├── start.php
```

<a name="artisan-commands"></a>
## Artisan Commands

Setting up components folders for first use

```
php artisan component:setup
```

Create new component.

```
php artisan component:make blog
```

Use the specified component.

```
php artisan component:use blog
```

Show all components in command line.

```
php artisan component:list
```

Create new command for the specified component.

```
php artisan component:make-command CustomCommand blog

php artisan component:make-command CustomCommand --command=custom:command blog

php artisan component:make-command CustomCommand --namespace=Components\Blog\Commands blog
```

Create new migration for the specified component.

```
php artisan component:make-migration create_users_table blog

php artisan component:make-migration create_users_table --fields="username:string, password:string" blog

php artisan component:make-migration add_email_to_users_table --fields="email:string:unique" blog

php artisan component:make-migration remove_email_from_users_table --fields="email:string:unique" blog

php artisan component:make-migration drop_users_table blog
```

Rollback, Reset and Refresh The Components Migrations.

```
php artisan component:migrate-rollback

php artisan component:migrate-reset

php artisan component:migrate-refresh
```

Rollback, Reset and Refresh The Migrations for the specified component.

```
php artisan component:migrate-rollback blog

php artisan component:migrate-reset blog

php artisan component:migrate-refresh blog
```

Migrate from the specified component.

```
php artisan component:migrate blog
```

Migrate from all components.

```
php artisan component:migrate
```

Create new seed for the specified component.

```
php artisan component:make-seed users blog
```

Seed from the specified component.

```
php artisan component:seed blog
```

Seed from all components.

```
php artisan component:seed
```

Create new controller for the specified component.

```
php artisan component:make-controller SiteController blog
```

Publish assets from the specified component to public directory.

```
php artisan component:publish-asset blog
```

Publish assets from all components to public directory.

```
php artisan component:publish-asset
```

Create new model for the specified component.

```
php artisan component:make-model User blog

php artisan component:make-model User blog --fillable="username,email,password"
```

Create new service provider for the specified component.

```
php artisan component:make-provider MyServiceProvider blog
```

Publish migration for the specified component or for all components.

This helpful when you want to rollback the migrations. You can also run `php artisan migrate` instead of `php artisan component:migrate` command for migrate the migrations.

For the specified component.

```
php artisan component:publish-migration blog
```

For all components.

```
php artisan component:publish-migration
```

Publish seed for the specified component or for all components.

This helpful when you want to rollback the seeds. You can also run `php artisan db:seed` instead of `php artisan component:seed` command for migrate the seeds.

For the specified component.

```
php artisan component:publish-seed blog
```

For all components.

```
php artisan component:publish-seed
```

Publish component configuration files

```
php artisan component:publish-config <component-name>
```

- (optional) `component-name`: The name of the component to publish configuration. Leaving blank will publish all components.
- (optional) `--force`: To force the publishing, overwriting already published files

Enable the specified component.


```
php artisan component:enable blog
```

Disable the specified component.

```
php artisan component:disable blog
```

Generate new middleware class.

```
php artisan component:make-middleware Auth
```

Generate new mailable class.

```
php artisan component:make-mail WelcomeEmail
```

Generate new notification class.

```
php artisan component:make-notification InvoicePaid
```

Update dependencies for the specified component.

```
php artisan component:update ComponentName
```

Update dependencies for all components.

```
php artisan component:update
```

Show the list of components.

```
php artisan component:list
```

<a name="facades"></a>
## Facades

Get all components.

```php
Component::all();
```

Get all cached components.

```php
Component::getCached()
```

Get ordered components. The components will be ordered by the `priority` key in `component.json` file.

```php
Component::getOrdered();
```

Get scanned components.

```php
Component::scan();
```

Find a specific component.

```php
Component::find('name');
// OR
Component::get('name');
```

Find a component, if there is one, return the `Component` instance, otherwise throw `Rad\Components\Exeptions\ComponentNotFoundException`.

```php
Component::findOrFail('component-name');
```

Get scanned paths.

```php
Component::getScanPaths();
```

Get all components as a collection instance.

```php
Component::toCollection();
```

Get components by the status. 1 for active and 0 for inactive.

```php
Component::getByStatus(1);
```

Check the specified component. If it exists, will return `true`, otherwise `false`.

```php
Component::has('blog');
```

Get all enabled components.

```php
Component::enabled();
```

Get all disabled components.

```php
Component::disabled();
```

Get count of all components.

```php
Component::count();
```

Get component path.

```php
Component::getPath();
```

Register the components.

```php
Component::register();
```

Boot all available components.

```php
Component::boot();
```

Get all enabled components as collection instance.

```php
Component::collections();
```

Get component path from the specified component.

```php
Component::getComponentPath('name');
```

Get assets path from the specified component.

```php
Component::assetPath('name');
```

Get config value from this package.

```php
Component::config('composer.vendor');
```

Get used storage path.

```php
Component::getUsedStoragePath();
```

Get used component for cli session.

```php
Component::getUsedNow();
// OR
Component::getUsed();
```

Set used component for cli session.

```php
Component::setUsed('name');
```

Get components's assets path.

```php
Component::getAssetsPath();
```

Get asset url from specific component.

```php
Component::asset('blog::img/logo.img');
```

Install the specified component by given component name.

```php
Component::install('Rad/hello');
```

Update dependencies for the specified component.

```php
Component::update('hello');
```

<a name="entity"></a>
## Component Entity

Get an entity from a specific component.

```php
$component = Component::find('blog');
```

Get component name.

```php
$component->getName();
```

Get component name in lowercase.

```php
$component->getLowerName();
```

Get component name in studlycase.

```php
$component->getStudlyName();
```

Get component path.

```php
$component->getPath();
```

Get extra path.

```php
$component->getExtraPath('Assets');
```

Disable the specified component.

```php
$component->enable();
```

Enable the specified component.

```php
$component->disable();
```

Delete the specified component.

```php
$component->delete();
```

<a name="namespaces"></a>
## Custom Namespaces

When you create a new component it also registers new custom namespace for `Lang`, `View` and `Config`. For example, if you create a new component named blog, it will also register new namespace/hint blog for that component. Then, you can use that namespace for calling `Lang`, `View` or `Config`. Following are some examples of its usage:

Calling Lang:

```php
Lang::get('blog::group.name');
```

Calling View:

```php
View::make('blog::index')

View::make('blog::partials.sidebar')
```

Calling Config:

```php
Config::get('blog.name')
```

## Publishing Components

Have you created a laravel components? Yes, I've. Then, I want to publish my components. Where do I publish it? That's the question. What's the answer ? The answer is [Packagist](http://packagist.org).

<a name="auto-scan-vendor-directory"></a>
### Auto Scan Vendor Directory

By default the `vendor` directory is not scanned automatically, you need to update the configuration file to allow that. Set `scan.enabled` value to `true`. For example :

```php
// file config/components.php

return [
  //...
  'scan' => [
    'enabled' => true
  ]
  //...
]
```

You can verify the component has been installed using `component:list` command:

```
php artisan component:list
```

<a name="publishing-components"></a>
## Publishing Components

After creating a component and you are sure your component component will be used by other developers. You can push your component to [github](https://github.com) or [bitbucket](https://bitbucket.org) and after that you can submit your component to the packagist website.

You can follow this step to publish your component.

1. Create A Component.
2. Push the component to github.
3. Submit your component to the packagist website.
Submit to packagist is very easy, just give your github repository, click submit and you done.


## Credits

- [Anonymoussc](https://github.com/anonymoussc)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
