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
                'controller' => 'ProductController@update',
                'middleware' => ['ValidationMiddleware'],
                'validation' => 'App\\Http\\Requests\\ProductRequest',
            ],
        ],
        'DELETE' => [
            'products/(\d+)' => 'ProductController@delete',
        ]
    ];

