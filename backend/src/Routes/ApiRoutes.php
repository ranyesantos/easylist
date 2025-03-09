<?php

namespace App\Routes;

class ApiRoutes 
{
    
    public static function getRoutes(): array 
    {
        return [
            'GET' => [
                'products' => 'ProductController@index',
                'products/(\d+)' => 'ProductController@show',
            ],
            'POST' => [
                'products' => [
                    'controller' => 'ProductController@store',
                    'middleware' => ['ValidationMiddleware'],
                    'validation' => 'App\\Requests\\ProductRequest',
                ],
            ],
            'PUT' => [
                'products/(\d+)' => 'ProductController@update',
            ],
            'DELETE' => [
                'products/(\d+)' => 'ProductController@delete',
            ]
        ];
    }
}
