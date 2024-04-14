<?php

namespace App\Helpers;

class Openapi
{
    static $data = [
        'openapi' => '3.0.3',
        'host' => '',
        'basePath' => '/api',
        'info' => [
            'version' => '1.0.0',
            'title' => 'App Name',
            'contact' => [
                'email' => 'main@grr.la',
            ],
        ],
        'servers' => [],
        'tags' => [],
        'paths' => [],
    ];

    static function getData()
    {
        self::$data['servers'] = [
            ['url' => \URL::to('/api')],
        ];
        // self::$data['host'] = \URL::to('/api');
        return self::$data;
    }

    static function pathAdd($methods, $path, $tags = [])
    {
        if (!isset(self::$data['paths'][$path])) {
            self::$data['paths'][$path] = [];
        }

        foreach ($methods as $method) {
            $method = strtolower($method);
            if (!in_array($method, ['get', 'post', 'put', 'delete'])) continue;

            self::$data['paths'][$path][$method] = [
                'tags' => $tags,
                // 'summary' => $summary,
                'operationId' => "{$method}:{$path}",
                'costumes' => ['multipart/form-data'],
                'produces' => ['application/json'],
                'parameters' => [],
                'responses' => [],
            ];
        }

        foreach ($tags as $tag) {
            self::$data['tags'][$tag] = $tag;
        }
    }

    static function pathMerge($methods, $path, $data = [])
    {
        if (!isset(self::$data['paths'][$path])) {
            self::$data['paths'][$path] = [];
        }

        foreach ($methods as $method) {
            $method = strtolower($method);
            if (!in_array($method, ['get', 'post', 'put', 'delete'])) continue;

            if (!isset(self::$data['paths'][$path][$method])) {
                self::$data['paths'][$path][$method] = [];
            }

            self::$data['paths'][$path][$method] = array_merge(self::$data['paths'][$path][$method], $data);
        }
    }

    static function pathParamAdd($methods, $path, $data = [])
    {
        if (!isset(self::$data['paths'][$path])) {
            self::$data['paths'][$path] = [];
        }

        foreach ($methods as $method) {
            $method = strtolower($method);
            if (!in_array($method, ['get', 'post', 'put', 'delete'])) continue;

            self::$data['paths'][$path][$method]['parameters'][] = array_merge([
                'name' => '',
                'in' => null,
                'description' => '',
                'required' => false,
                'type' => 'null',
            ], $data);
        }
    }
}
