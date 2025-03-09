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

        $container->set(\App\Validators\Products\NameValidator::class, function (){
            return new \App\Validators\Products\NameValidator;
        });

        $container->set(\App\Validators\Products\PriceValidator::class, function (){
            return new \App\Validators\Products\PriceValidator;
        });

        $container->set(\App\Validators\Products\StockValidator::class, function (){
            return new \App\Validators\Products\StockValidator;
        });

        $container->set(\App\Interfaces\ProductValidationInterface::class, function() use ($container){
            return new \App\Validators\ProductValidator([
                $container->get(\App\Validators\Products\NameValidator::class),
                $container->get(\App\Validators\Products\PriceValidator::class),
                $container->get(\App\Validators\Products\StockValidator::class),
            ]);
        });

        $container->set('ProductService', function() use ($container) {
            return new \App\Services\Products\ProductService(
                $container->get('ProductRepositoryInterface'),
                $container->get(\App\Interfaces\ProductValidationInterface::class)
            );
        });

        $container->set('ProductController', function() use ($container) {
            return new \App\Controllers\API\V1\ProductController($container->get('ProductService'));
        });
        
        $container->set('Request', function()  {
            return new \App\Http\Request;
        });
        // $container->set(\App\Middlewares\ValidationMiddleware::class, function() use ($container){
        //     return new \App\Middlewares\ValidationMiddleware($container->get('Request'));
        // }); 
        return $container;
    }
}
