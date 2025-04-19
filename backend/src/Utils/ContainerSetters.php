<?php 

namespace App\Utils;
use App\Config\Container;

class ContainerSetters 
{

    public static function Init(): Container
    {
        $container = new Container();
        
        //<-----interfaces/repositories----->
        $container->set('ProductRepositoryInterface', function () {
            return new \App\Repositories\Product\ProductRepository;
        });

        $container->set('CategoryRepositoryInterface', function () {
            return new \App\Repositories\Category\CategoryRepository();
        });

        $container->set('CustomerRepositoryInterface', function () {
            return new \App\Repositories\Customer\CustomerRepository();
        });

        $container->set('ColorRepositoryInterface', function () {
            return new \App\Repositories\Color\ColorRepository();
        });

        $container->set('SizeRepositoryInterface', function () {
            return new \App\Repositories\Size\SizeRepository();
        });

        //<-----services----->
        $container->set('ProductService', function() use ($container) {
            return new \App\Services\ProductService(
                $container->get('ProductRepositoryInterface')
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
            return new \App\Http\Controllers\API\V1\CustomerController($container->get('ColorService'));
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

        return $container;
    }
}
