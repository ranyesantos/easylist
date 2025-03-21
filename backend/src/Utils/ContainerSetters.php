<?php 

namespace App\Utils;
use App\Config\Container;

class ContainerSetters 
{

    public static function Init(): Container
    {
        $container = new Container();
        
        $container->set('ProductRepositoryInterface', function () {
            return new \App\Repositories\ProductRepository;
        });

        $container->set('ProductService', function() use ($container) {
            return new \App\Services\Products\ProductService(
                $container->get('ProductRepositoryInterface')
            );
        });

        $container->set('ProductController', function() use ($container) {
            return new \App\Http\Controllers\API\V1\ProductController($container->get('ProductService'));
        });
        
        $container->set('Request', function()  {
            return new \App\Http\Helpers\Request;
        });
        // $container->set(\App\Middlewares\ValidationMiddleware::class, function() use ($container){
        //     return new \App\Middlewares\ValidationMiddleware($container->get('Request'));
        // }); 
        return $container;
    }
}
