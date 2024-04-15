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
        return [
            'user' => auth()->user(),
        ];
    }

    public function openapi()
    {
        foreach (Route::getRoutes() as $route) {
            if (!str_starts_with($route->uri, 'api/')) continue;

            if (isset($route->action['controller'])) {
                list($controller_class, $controller_method) = explode('@', $route->action['controller']);
                $controller = preg_replace('/Controller.+/', '', \Arr::last(explode('\\', $controller_class)));
                $controller_name = join(' ', \Str::of(preg_replace('/Controller$/', '', $controller))->ucsplit()->toArray());
                $path = '/' . str_replace('api/', '', $route->uri);

                Helpers\Openapi::pathAdd(methods: $route->methods, path: $path, tags: [$controller_name]);

                $annotations = (new ReflectionClass($controller_class))->getMethod($controller_method)->getAttributes();
                foreach ($annotations as $annotation) {
                    $arguments = [$route->methods, $path, ...$annotation->getArguments()];
                    (new ReflectionClass($annotation->getName()))->newInstanceArgs($arguments);
                }
            }
        }

        return Helpers\Openapi::getData();
    }
}
