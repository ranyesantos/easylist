<?php

namespace App\Core;
use App\Routes\ApiRoutes;
use App\Utils\ContainerSetters;
use App\Utils\ValidationHandler;
use ReflectionMethod;

class Router 
{
    
    public static function route($uri, $method): void 
    {
        $container = ContainerSetters::init();
        // $routes = ApiRoutes::getRoutes();
        $routes = require __DIR__ . '/../../Routes/Api.php';
        // var_dump($routes);
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
                        // o método espera parâmetros = passa Request
                        $controllerInstance->$action($container->get('Request'));
                    } else {
                        // o método NÃO espera parâmetros = chama sem argumentos
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

                    list($controller, $action) = explode('@', $controllerAction);
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
                        $controllerInstance->$action(...$args);

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
