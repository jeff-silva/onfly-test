<?php

namespace App\Annotations\Openapi;

class Auth
{
    public function __construct($methods, $path)
    {
        \App\Helpers\Openapi::pathMerge($methods, $path, [
            'security' => [
                ['bearerAuth' => []],
            ],
        ]);
    }
}
