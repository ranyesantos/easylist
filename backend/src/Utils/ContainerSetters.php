<?php 

namespace App\Utils;
use App\Config\Container;
use App\Db\Connection;
use PDO;

class ContainerSetters 
{

    public static function Init(): Container
    {
        $container = new Container();
        
        //<-----interfaces/repositories----->
        $container->set('ProductRepositoryInterface', function ()use ($container) {
            return new \App\Repositories\Product\ProductRepository($container->get(PDO::class));
        });

        $container->set('CategoryRepositoryInterface', function () use ($container) {
            return new \App\Repositories\Category\CategoryRepository($container->get(PDO::class));
        });

        $container->set('CustomerRepositoryInterface', function () use ($container) {
            return new \App\Repositories\Customer\CustomerRepository($container->get(PDO::class));
        });

        $container->set('ColorRepositoryInterface', function () use ($container) {
            return new \App\Repositories\Color\ColorRepository($container->get(PDO::class));
        });

        $container->set('SizeRepositoryInterface', function () use ($container) {
            return new \App\Repositories\Size\SizeRepository($container->get(PDO::class));
        });

        $container->set('ProductColorRepositoryInterface', function()use ($container) {
            return new \App\Repositories\ProductColor\ProductColorRepository($container->get(PDO::class));
        });

        $container->set('ProductSizeRepositoryInterface', function() use ($container) {
            return new \App\Repositories\ProductSize\ProductSizeRepository($container->get(PDO::class));
        });

        //<-----services----->
        $container->set('ProductSizeService', function() use ($container){
            return new \App\Services\ProductSizeService(
                $container->get('ProductSizeRepositoryInterface')
            );
        });

        $container->set('ProductColorService', function() use ($container){
            return new \App\Services\ProductColorService(
                $container->get('ProductColorRepositoryInterface')
            );
        });

        $container->set('ProductService', function() use ($container) {
            return new \App\Services\ProductService(
                $container->get('ProductRepositoryInterface'),
                $container->get('ProductColorService'),
                $container->get('ProductSizeService'),
                $container->get('ServiceUtils'),
                $container->get(PDO::class)
            );
        });

        $container->set('CategoryService', function() use ($container) {
            return new \App\Services\CategoryService(
                $container->get('CategoryRepositoryInterface')
            );
        });

        $container->set('CustomerService', function() use ($container) {
            return new \App\Services\CustomerService(
                $container->get('CustomerRepositoryInterface')
            );
        });

        $container->set('ColorService', function() use ($container) {
            return new \App\Services\ColorService(
                $container->get('ColorRepositoryInterface')
            );
        });

        $container->set('SizeService', function() use ($container) {
            return new \App\Services\SizeService(
                $container->get('SizeRepositoryInterface')
            );
        });

        //<-----controllers----->
        $container->set('ProductController', function() use ($container) {
            return new \App\Http\Controllers\API\V1\ProductController($container->get('ProductService'));
        });

        $container->set('CategoryController', function() use ($container) {
            return new \App\Http\Controllers\API\V1\CategoryController($container->get('CategoryService'));
        });

        $container->set('CustomerController', function() use ($container) {
            return new \App\Http\Controllers\API\V1\CustomerController($container->get('CustomerService'));
        });

        $container->set('ColorController', function() use ($container) {
            return new \App\Http\Controllers\API\V1\ColorController($container->get('ColorService'));
        });

        $container->set('SizeController', function() use ($container) {
            return new \App\Http\Controllers\API\V1\SizeController($container->get('SizeService'));
        });
        
        //<-----etc----->
        $container->set('Request', function()  {
            return new \App\Http\Helpers\Request;
        });

        $container->set('ServiceUtils', function()  {
            return new \App\Utils\ServiceUtils;
        });

        $container->set(PDO::class, function () {
            return Connection::getPDO();
        });

        return $container;
    }
}
