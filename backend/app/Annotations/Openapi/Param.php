<?php

namespace App\Annotations\Openapi;

class Param
{
    public function __construct($methods, $path, $data = [])
    {
        \App\Helpers\Openapi::pathParamAdd($methods, $path, $data);
    }
}
