<?php

namespace App\Utils;

class StringUtils 
{
    /**
     * limpa a URI, permitindo apenas letras, números e barras (/).
     *
     * @param string $uri
     * @return string
     */
    public static function cleanUri(string $uri): string 
    {
        return preg_replace('/[^a-zA-Z0-9\/]/', '', $uri);
    }
    
}
