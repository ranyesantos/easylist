<?php

$prefix = 'api/v1/';

return [
    'GET' => [
        $prefix . 'products' => 'ProductController@index',
        $prefix . 'products/(\d+)' => 'ProductController@show',

        $prefix . 'categories' => 'CategoryController@index',
        $prefix . 'categories/(\d+)' => 'CategoryController@show',

        $prefix . 'customers' => 'CustomerController@index',
        $prefix . 'customers/(\d+)' => 'CustomerController@show',

        $prefix . 'colors' => 'ColorController@index',
        $prefix . 'colors/(\d+)' => 'ColorController@show',

        $prefix . 'sizes' => 'SizeController@index',
        $prefix . 'sizes/(\d+)' => 'SizeController@show',
    ],
    'POST' => [
        $prefix . 'products' => [
            'controller' => 'ProductController@store'
        ],
        $prefix . 'categories' => [
            'controller' => 'CategoryController@store'
        ],
        $prefix . 'customers' => [
            'controller' => 'CustomerController@store'
        ],
        $prefix . 'colors' => [
            'controller' => 'ColorController@store'
        ],
        $prefix . 'sizes' => [
            'controller' => 'SizeController@store'
        ],
    ],
    'PUT' => [
        $prefix . 'products/(\d+)' => [
            'controller' => 'ProductController@update'
        ],
        $prefix . 'categories/(\d+)' => [
            'controller' => 'CategoryController@update'
        ],
        $prefix . 'customers/(\d+)' => [
            'controller' => 'CustomerController@update'
        ],
        $prefix . 'colors/(\d+)' => [
            'controller' => 'ColorController@store'
        ],
        $prefix . 'sizes/(\d+)' => [
            'controller' => 'SizeController@update'
        ],
    ],
    'DELETE' => [
        $prefix . 'products/(\d+)' => 'ProductController@delete',
        $prefix . 'categories/(\d+)' => 'CategoryController@delete',
        $prefix . 'customers/(\d+)' => 'CustomerController@delete',
        $prefix . 'colors/(\d+)' => 'ColorController@delete',
        $prefix . 'sizes/(\d+)' => 'SizeController@delete',
    ],
];
