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
            return new \App\Repositories\ProductRepository;
        });

        $container->set('CategoryRepositoryInterface', function () {
            return new \App\Repositories\CategoryRepository();
        });

        //<-----services----->
        $container->set('ProductService', function() use ($container) {
            return new \App\Services\Products\ProductService(
                $container->get('ProductRepositoryInterface')
            );
        });

        $container->set('CategoryService', function() use ($container) {
            return new \App\Services\Products\CategoryService(
                $container->get('CategoryRepositoryInterface')
            );
        });

        //<-----controllers----->
        $container->set('ProductController', function() use ($container) {
            return new \App\Http\Controllers\API\V1\ProductController($container->get('ProductService'));
        });

        $container->set('CategoryController', function() use ($container) {
            return new \App\Http\Controllers\API\V1\CategoryController($container->get('CategoryService'));
        });
        
        //<-----etc----->
        $container->set('Request', function()  {
            return new \App\Http\Helpers\Request;
        });

        return $container;
    }
}
