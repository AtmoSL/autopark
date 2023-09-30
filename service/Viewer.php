<?php

namespace service;

class Viewer
{
    /**
     * Генерация view
     * @param $view
     * @param $params
     * @return void
     */
    static function view($view, $params = [])
    {
        extract($params);
        require_once "./app/views/" . $view . ".php";
    }
}