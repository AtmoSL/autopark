<?php

namespace app\Controllers;

use app\Models\User;
use app\Validators\UserValidator;
use service\Auth;
use service\Router;
use service\Viewer;

class UserController
{
    /**
     * Страница входа
     * @return false|void
     */
    public function login()
    {
        if (Auth::isAuth()) {
            Router::redirect("/profile");
            return false;
        }

        Viewer::view('user/login');
    }

    /**
     * Страница регистрации
     * @return false|void
     */
    public function register()
    {
        if (Auth::isAuth()) {
            Router::redirect("/profile");
            return false;
        }

        Viewer::view('user/register');
    }

    /**
     * Страница профиля
     * @return false|void
     */
    public function profile()
    {
        if (!Auth::isAuth()) {
            Router::redirect("/login");
            return false;
        }

        $user = User::where(["id" => Auth::getId()], ["="], ["name", "email"])->find()[0];

        Viewer::view('profile', compact('user'));
    }

    /**
     * Регистрация пользователя
     * @param $userData
     * @return bool
     */
    public function createuser($userData)
    {
        if (Auth::isAuth()) {
            Router::redirect("/profile");
            return false;
        }
        $_SESSION["registration-form"] = $userData;

        array_map("trim", $userData);

        $validation = UserValidator::registerValidate($userData);

        if (!$validation) {
            Router::redirect("/register");
            return false;
        }

        unset($userData["password-repeat"]);
        $userData["password"] = md5($userData["password"]);


        User::create($userData);

        $user = User::where(["email" => $userData["email"]], ["="], ["id", "role_id"])->find()[0];

        Auth::auth($user->id, $user->role_id);

        header("location: /profile");

        return true;
    }

    /**
     * Выход из аккаунта
     * @return false|void
     */
    public function logout()
    {
        if (!Auth::isAuth()) {
            Router::redirect("/login");
            return false;
        }

        Auth::logout();

        Router::redirect("/");
    }

    /**
     * Вход в аккаунт
     * @param $userData
     * @return bool
     */
    public function auth($userData)
    {
        $_SESSION["login-form"] = $userData;

        $user = User::where([
            "email" => $userData["email"],
            "password" => md5($userData["password"])
            ], ["=", "="],
            ["id", "role_id"])->find()[0];;

        if (empty($user)) {
            $_SESSION["login-messages"][] = "Введены неверные данные";
            Router::redirect("/login");
            return false;
        }

        Auth::auth($user->id, $user->role_id);
        if(Auth::getRoleId() == 1){
            Router::redirect("/cars");
        }elseif(Auth::getRoleId() == 2){
            Router::redirect("/autoparks");
        }
        return true;
    }
}