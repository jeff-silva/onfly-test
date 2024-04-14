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

    static function pathInit($methods, $path)
    {
        if (!isset(self::$data['paths'][$path])) {
            self::$data['paths'][$path] = [];
        }

        $methods = self::pathMethods($methods);

        foreach ($methods as $method) {
            if (isset(self::$data['paths'][$path][$method])) continue;
            self::$data['paths'][$path][$method] = [
                'tags' => [],
                'operationId' => "{$method}:{$path}",
                'costumes' => ['multipart/form-data'],
                'produces' => ['application/json'],
                'parameters' => [],
                'responses' => [],
            ];
        }
    }

    static function pathMethods($methods)
    {
        foreach ($methods as $index => $method) {
            $method = strtolower($method);
            if (!in_array($method, ['get', 'post', 'put', 'delete'])) {
                unset($methods[$index]);
                continue;
            }
            $methods[$index] = $method;
        }
        return array_values($methods);
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
                'responses' => [
                    '500' => [
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'properties' => [
                                        'code' => [
                                            'type' => 'string',
                                        ],
                                        'message' => [
                                            'type' => 'string',
                                        ],
                                        'fields' => [
                                            'type' => 'object',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
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

        $data = array_merge([
            'name' => '',
            'in' => null,
            'description' => '',
            'required' => false,
            'type' => 'string',
            'format' => '',
        ], $data);

        foreach ($methods as $method) {
            $method = strtolower($method);
            if (!in_array($method, ['get', 'post', 'put', 'delete'])) continue;

            if (isset($data['in']) and $data['in'] == 'body') {
                if (!isset(self::$data['paths'][$path][$method]['requestBody'])) {
                    self::$data['paths'][$path][$method]['requestBody'] = [
                        'required' => true,
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [],
                                ],
                            ],
                        ],
                    ];
                }

                self::$data['paths'][$path][$method]['requestBody']['content']['application/json']['schema']['properties'][$data['name']] = [
                    'type' => $data['type'],
                    'format' => $data['format'],
                ];

                continue;
            }

            self::$data['paths'][$path][$method]['parameters'][] = $data;
        }
    }

    static function pathResponseAdd($methods, $path, $code, $data)
    {
        self::pathInit($methods, $path);
        $methods = self::pathMethods($methods);

        foreach ($methods as $method) {
            $properties = [];
            foreach ($data as $key => $type) {
                $properties[$key] = ['type' => $type];
            }
            self::$data['paths'][$path][$method]['responses'][$code] = [
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'properties' => $properties,
                        ],
                    ],
                ],
            ];
        }
    }
}
