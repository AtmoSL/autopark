<?php

namespace app\Validators;

use app\Models\User;
use service\Validator;

class UserValidator extends Validator
{
    /**
     * Проверка данных при регистрации
     * @param $userData
     * @return bool
     */
    public static function registerValidate($userData): bool
    {
        $userByEmail = User::where(["email" => $userData["email"]],
            ["="],
            ["id"])->find();

        if (self::isEmpty($userData)) {
            $_SESSION["register-messages"][] = "Все поля должны быть заполнены";
        }
        if ($userData["password"] != $userData["password-repeat"]) {
            $_SESSION["register-messages"][] = "Пароли не совпадают";
        }
        if (strlen($userData["password"]) < 6) {
            $_SESSION["register-messages"][] = "Пароль должен быть длиннее 5 символов";
        }
        if (($userData["role_id"] != 1) && ($userData["role_id"] != 2)) {
            $_SESSION["register-messages"][] = "Выбрана несуществующая роль";
        }
        if (!filter_var($userData["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["register-messages"][] = "Email указан некорректно";
        }
        if (!self::isOnlyLetters($userData["name"])) {
            $_SESSION["register-messages"][] = "В имени могут быть только буквы";
        }
        if (!empty($userByEmail)) {
            $_SESSION["register-messages"][] = "Пользователь с таким email уже существует";
        }

        return count($_SESSION['register-messages']) === 0;
    }

}