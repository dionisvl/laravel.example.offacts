<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

# OpenFoodFacts API use example

## Features of project
- It is demo version application for use OpenFoodFacts API
- adding/updating products from API to local DB
- searching products with AJAX dropdown by API
- functional/unit tests
- acceptance(application) tests
- flexible modular architecture for easy project extension support

### Installation
- git clone THIS_REPO
- `cp .env.example .env`
- `composer install`
- `php artisan key:generate`
- change DB_* in .env to actual
- change APP_URL in .env to actual
- `php artisan config:cache`
- `php artisan migrate`
- for use Acceptance tests: 
    - install laravel dusk by instruction https://laravel.com/docs/7.x/dusk 
    - answer for dusk trouble there https://github.com/laravel/dusk/issues/770#issuecomment-625495556 
    - remove all example dusk tests in `\tests\Browser` directory 

### Technologies and tools:
- PHP 7.4
- Laravel 7
- MySQL 8.0
- JavaScript Fetch API
- OpenFoodFacts API
- Git
- ChromeDriver 84
- PHPUnit 8.5.8

### How to use
- use site, open in browser `THIS_SITE/products/`

### Tests
- command for run tests:
```
vendor\bin\phpunit packages\products\src\tests
```
- command for run Acceptance tests:
```
php artisan dusk packages\products\src\tests
```

# Installing this package to another project
- Copy directory packages\products from this repo to your project
- Edit config\app.php as example:
```
'providers' => [
    ...
    AppSmart\Products\ProductsServiceProvider::class,
]
```
- edit composer.json as example:
```
"autoload": {
    "psr-4": {
        ...
        "AppSmart\\Products\\": "packages/products/src/"
        ...
    },
```
- `composer dump-autoload`
- `php artisan migrate`
