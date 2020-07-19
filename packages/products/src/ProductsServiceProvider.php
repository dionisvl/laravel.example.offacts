<?php

namespace AppSmart\Products;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ProductsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            $this->packageDir() . '/src/config/products.php',
            'products'
        );
    }

    protected function packageDir()
    {
        return realpath(__DIR__ . '/../');
    }

    public function boot()
    {
        $this->loadRoutesFrom($this->packageDir() . '/routes.php');
        $this->loadViewsFrom($this->packageDir() . '/src/resources/views', 'products');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    private function registerSettings()
    {

    }
}
