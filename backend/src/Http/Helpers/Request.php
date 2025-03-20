<?php 

namespace App\Http\Helpers;

class Request 
{
    
    public function getBody()
    {
        $json = file_get_contents('php://input');

        $data = json_decode($json, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid JSON"]);
            exit;
        }
        
        return $data;
    }

    public static function sendJsonResponse($response, $statusCode)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($response, JSON_PRETTY_PRINT);

        exit;
    }
}