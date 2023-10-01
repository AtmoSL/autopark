<?php

namespace service;

class Router
{
    private static $links = [];

    /**
     * Добавление URL в список
     * @param $uri
     * @param $controller
     * @param $action
     * @return void
     */
    public static function addRoute($uri, $controller, $action)
    {
        self::$links[$uri] = [
            "controller" => $controller,
            "action" => $action,
            "method" => null
        ];
    }

    /**
     * Добавление URL с методом POST в список
     * @param $uri
     * @param $controller
     * @param $action
     * @return void
     */
    public static function post($uri, $controller, $action)
    {
        self::$links[$uri] = [
            "controller" => $controller,
            "action" => $action,
            "method" => "post"
        ];
    }

    /**
     * Добавление URL с методом POST в список
     * @param $uri
     * @param $controller
     * @param $action
     * @return void
     */
    public static function get($uri, $controller, $action)
    {
        self::$links[$uri] = [
            "controller" => $controller,
            "action" => $action,
            "method" => "get"
        ];
    }

    /**
     * Ревлизация маршрутов
     * @return void
     */
    public static function start()
    {
        $route = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        if (isset(self::$links[$route])) {
            $controllerName = "app\\Controllers\\" . self::$links[$route]["controller"];
            $action = self::$links[$route]['action'];

            $controllerObject = new $controllerName();
            if (self::$links[$route]["method"] === "post") {
                $controllerObject->$action($_POST);
            } elseif(self::$links[$route]["method"] === "get") {
                $controllerObject->$action($_GET);
            } else {
                $controllerObject->$action();
            }

        } else {
            http_response_code(404);
            Viewer::view('404');
        }
    }

    /**
     * Перенаправление на другой URL
     * @param $uri
     * @return void
     */
    public static function redirect($uri)
    {
        header("location: " . $uri);
    }
}