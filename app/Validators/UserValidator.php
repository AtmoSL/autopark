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
        $isValidated = true;
        $userByEmail = User::where(["email" => $userData["email"]],
            ["="],
            ["id"])->find();

        if (self::isEmpty($userData)) {
            $_SESSION["register-messages"][] = "Все поля должны быть заполнены";
            $isValidated = false;
        }
        if ($userData["password"] != $userData["password-repeat"]) {
            $_SESSION["register-messages"][] = "Пароли не совпадают";
            $isValidated = false;
        }
        if (strlen($userData["password"]) < 6) {
            $_SESSION["register-messages"][] = "Пароль должен быть длиннее 5 символов";
            $isValidated = false;
        }
        if (($userData["role_id"] != 1) && ($userData["role_id"] != 2)) {
            $_SESSION["register-messages"][] = "Выбрана несуществующая роль";
            $isValidated = false;
        }
        if (!filter_var($userData["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["register-messages"][] = "Email указан некорректно";
            $isValidated = false;
        }
        if (!self::isOnlyLetters($userData["name"])) {
            $_SESSION["register-messages"][] = "В имени могут быть только буквы";
            $isValidated = false;
        }
        if (!empty($userByEmail)) {
            $_SESSION["register-messages"][] = "Пользователь с таким email уже существует";
            $isValidated = false;
        }

        return $isValidated;
    }

}