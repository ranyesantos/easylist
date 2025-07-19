<?php

namespace App\Core;

use App\Utils\ContainerSetters;
use App\Utils\ValidationHandler;
use App\Validators\ExceptionHandler;
use ReflectionMethod;

class Router 
{
    
    public static function route($uri, $method): void 
    {
        $container = ContainerSetters::init();
        
        $routes = require __DIR__ . '/../../Routes/api.php';

        $controllerPath = 'App\\Http\\Controllers\\API\\V1\\';
        $matched = false;
        foreach ($routes[$method] as $route => $controllerAction) {
            if ($uri === $route) {

                if (is_array($controllerAction)){
                    list($controller, $action) = explode('@', $controllerAction['controller']);
                } else {
                    list($controller, $action) = explode('@', $controllerAction);
                }
                
                if (!class_exists($controllerPath . $controller)){
                    return;
                }

                $controllerInstance = $container->get($controller);
                
                if (isset($controllerAction['validation'])) {
                    $validatorClass = $controllerAction['validation'];
                    ValidationHandler::handler($validatorClass, $container->get('Request'));
                    
                }

                if (method_exists($controllerInstance, $action)) {
                    
                    $reflection = new ReflectionMethod($controllerInstance, $action);
                    
                    if ($reflection->getNumberOfParameters() > 0) {
                        ExceptionHandler::handle($controllerInstance, $action, $container->get('Request'));

                    } else {
                        ExceptionHandler::handle($controllerInstance, $action);
                        $controllerInstance->$action();

                    }
                
                    $matched = true;
                }
            }
        }

        if (!$matched) {
            foreach ($routes[$method] as $route => $controllerAction) {
                
                if (preg_match("~^$route$~", $uri, $matches)) {

                    if (isset($matches[1])) {
                        $id = $matches[1];
                    }

                    if (is_array($controllerAction)){
                        list($controller, $action) = explode('@', $controllerAction['controller']);
                    } else {
                        list($controller, $action) = explode('@', $controllerAction);
                    }

                    if (!class_exists($controllerPath . $controller)){
                        return;
                    }
                    $controllerInstance = $container->get($controller);
                    if (method_exists($controllerInstance, $action)) {
                        $reflectionMethod = new ReflectionMethod($controllerInstance, $action);
                        //$params recebe os parametros esperados pelo método do controller
                        $params = $reflectionMethod->getParameters();
                        
                        $args = [];

                        foreach ($params as $param) {
                            //verifica se o parametro no método do controller é do tipo Request
                            if ($param->getType() && $param->getType()->getName() === 'App\\Http\\Helpers\\Request') {
                                //$args guarda a instância da classe Request que será injetada no controller
                                $args[] = $container->get('Request');
                            } elseif ($param->getName() === 'id') {
                                $args[] = $id;
                            }
                        }
                        ExceptionHandler::handle($controllerInstance, $action, ...$args);

                        $matched = true;
                    }
                    
                }
            }
        }

        if (!$matched) {
            echo "Rota não encontrada";
        }    
    }
}
