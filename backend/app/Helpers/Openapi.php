<?php

namespace App\Helpers;

class Openapi
{
    public $openapi = '3.0.3';
    public $info = [
        'version' => '1.0.0',
        'title' => 'App Name',
        'contact' => [
            'email' => 'main@grr.la',
        ],
    ];
    public $servers = [];
    public $tags = [];
    public $paths = [];

    public function __construct()
    {
        $this->servers[] = ['url' => \URL::to('/api')];
    }

    public function pathAdd($methods, $path, $summary, $tags = [])
    {
        if (!isset($this->paths[$path])) {
            $this->paths[$path] = [];
        }

        foreach ($methods as $method) {
            $method = strtolower($method);
            if (!in_array($method, ['get', 'post', 'put', 'delete'])) continue;
            $this->paths[$path][$method] = [
                'tags' => $tags,
                'summary' => $summary,
                'operationId' => "{$method}:{$path}",
                'costumes' => ['multipart/form-data'],
                'produces' => ['application/json'],
                'parameters' => [],
                'responses' => [],
            ];
        }

        foreach ($tags as $tag) {
            $this->tags[$tag] = $tag;
        }
    }

    public function pathParamAdd($methods, $path, $data = [])
    {
        if (!isset($this->paths[$path])) {
            $this->paths[$path] = [];
        }

        foreach ($methods as $method) {
            $method = strtolower($method);

            $this->paths[$path][$method]['parameters'][] = array_merge([
                'name' => '',
                'in' => null,
                'description' => '',
                'required' => false,
                'type' => 'null',
            ], $data);
        }
    }

    public function toArray()
    {
        $this->tags = array_values($this->tags);
        return (array) $this;
    }
}
