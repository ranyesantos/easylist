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
        
        //<-----etc----->
        $container->set('Request', function()  {
            return new \App\Http\Helpers\Request;
        });

        return $container;
    }
}
