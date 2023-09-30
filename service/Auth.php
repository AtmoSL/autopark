<?php

namespace service;

class Auth
{
    /**
     * Проверка авторизации
     * @return bool
     */
    public static function isAuth(): bool
    {
        if(empty($_SESSION['auth'])) return false;
        return true;
    }

    /**
     * Авторизация в сессии
     * @param $id
     * @return void
     */
    public static function auth($id, $role_id)
    {
        $_SESSION['auth'] = ["user_id" => $id];
    }

    /**
     * Выход из аккаунта в сессии
     * @return void
     */
    public static function logout()
    {
        unset($_SESSION['auth']);
    }

    /**
     * Получение id активного пользователя
     * @return int
     */
    public static function getId(): int
    {
        return $_SESSION['auth']['user_id'];
    }
}