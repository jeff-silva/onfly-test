<?php

namespace App\Annotations\Openapi;

class Response
{
    public function __construct($methods, $path, $code, $data)
    {
        \App\Helpers\Openapi::pathResponseAdd($methods, $path, $code, $data);
    }
}
