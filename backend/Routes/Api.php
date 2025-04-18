<?php

    return [
        'GET' => [
            'products' => 'ProductController@index',
            'products/(\d+)' => 'ProductController@show',

            'categories' => 'CategoryController@index',
            'categories/(\d+)' => 'CategoryController@show',

            'customers' => 'CustomerController@index',
            'customers/(\d+)' => 'CustomerController@show',

            'colors' => 'ColorController@index',
            'colors/(\d+)' => 'ColorController@show',
        ],
        'POST' => [
            'products' => [
                'controller' => 'ProductController@store',
                'middleware' => ['ValidationMiddleware'],
                'validation' => 'App\\Http\\Requests\\ProductRequest',
            ],
            'categories' => [
                'controller' => 'CategoryController@store'
            ],
            'customers' => [
                'controller' => 'CustomerController@store'
            ],
            'colors' => [
                'controller' => 'ColorController@store'
            ]
        ],
        'PUT' => [
            'products/(\d+)' => [
                'controller' => 'ProductController@update',
                'middleware' => ['ValidationMiddleware'],
                'validation' => 'App\\Http\\Requests\\ProductRequest',
            ],
            'categories/(\d+)' => [
                'controller' => 'CategoryController@update'
            ],
            'customers/(\d+)' => [
                'controller' => 'CustomerController@update'
            ],
            'colors/(\d+)' => [
                'controller' => 'ColorController@store'
            ]
        ],
        'DELETE' => [
            'products/(\d+)' => 'ProductController@delete',
            'categories/(\d+)' => 'CategoryController@delete',
            'customers/(\d+)' => 'CustomerController@delete',
            'colors/(\d+)' => 'ColorController@delete',
        ]
    ];

