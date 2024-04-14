<?php

namespace App\Http\Controllers;

use App\Models\AppConfig;
use App\Exceptions\ApiError;
use Illuminate\Http\Request;
use App\Models\AppUserNotification;
use Illuminate\Support\Facades\Route;
use App\Helpers;
use ReflectionClass;

class AppController extends Controller
{
    public function load()
    {
        return [];
    }

    public function openapi()
    {
        foreach (Route::getRoutes() as $route) {
            if (!str_starts_with($route->uri, 'api/')) continue;

            if (isset($route->action['controller'])) {
                list($controller_class, $controller_method) = explode('@', $route->action['controller']);
                $controller = preg_replace('/Controller.+/', '', \Arr::last(explode('\\', $controller_class)));
                $path = '/' . str_replace('api/', '', $route->uri);

                Helpers\Openapi::pathAdd(methods: $route->methods, path: $path, tags: [$controller]);

                $annotations = (new ReflectionClass($controller_class))->getMethod($controller_method)->getAttributes();
                foreach ($annotations as $annotation) {
                    $arguments = [$route->methods, $path, ...$annotation->getArguments()];
                    $a = (new ReflectionClass($annotation->getName()))->newInstanceArgs($arguments);
                }

                // dump(compact('controller', 'controller_class', 'controller_method'));
                // dump($route);
            }
        }

        return Helpers\Openapi::getData();

        // $openapi = [
        //     'openapi' => '3.0.3',
        //     'info' => [
        //         'version' => '1.0.0',
        //         'title' => env('APP_NAME'),
        //         'contact' => [
        //             'email' => env('MAIL_FROM_ADDRESS'),
        //         ],
        //     ],
        //     'servers' => [
        //         ['url' => \URL::to('/api')],
        //     ],
        //     'tags' => [],
        //     'paths' => [],
        // ];

        // foreach (Route::getRoutes() as $route) {
        //     if (!str_starts_with($route->uri, 'api/')) continue;

        //     if (isset($route->action['controller'])) {
        //         $controller = preg_replace('/Controller.+/', '', \Arr::last(explode('\\', $route->action['controller'])));
        //         $openapi['tags'][$controller] = [
        //             'name' => $controller,
        //         ];

        //         $uri = '/' . str_replace('api/', '', $route->uri);

        //         if (!isset($openapi['paths'][$uri])) {
        //             $openapi['paths'][$uri] = [];
        //         }

        //         foreach ($route->methods as $method) {
        //             if (in_array($method, ['HEAD', 'PATCH'])) continue;
        //             $method = strtolower($method);
        //             $openapi['paths'][$uri][$method] = [
        //                 'tags' => [$controller],
        //                 'summary' => '--summary',
        //                 'operationId' => $route->getName(),
        //                 'responses' => [
        //                     '200' => ['description' => 'Success'],
        //                 ],
        //             ];
        //         }
        //     }
        // }

        // $openapi['tags'] = array_values($openapi['tags']);
        // return $openapi;
    }
}
