<?php

    return [
        'GET' => [
            'products' => 'ProductController@index',
            'products/(\d+)' => 'ProductController@show',
        ],
        'POST' => [
            'products' => [
                'controller' => 'ProductController@store',
                'middleware' => ['ValidationMiddleware'],
                'validation' => 'App\\Http\\Requests\\ProductRequest',
            ],
        ],
        'PUT' => [
            'products/(\d+)' => [
                'ProductController@update'
                
            ],
        ],
        'DELETE' => [
            'products/(\d+)' => 'ProductController@delete',
        ]
    ];

