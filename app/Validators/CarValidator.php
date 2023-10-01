<?php

namespace app\Validators;

use app\Models\Car;
use service\Validator;

class CarValidator extends Validator
{
    /**
     * Проверка данных машины
     * @param $carData
     * @return bool
     */
    public static function validate($carData) : bool
    {
        $isValidated = true;

        if(empty($carData["number"])){
            $_SESSION["car-messages"][] = "Пожалуйста, укажите номер машины";
            $isValidated = false;
        }
        if(empty($carData["driver_name"])){
            $_SESSION["car-messages"][] = "Пожалуйста, укажите номер водителя";
            $isValidated = false;
        }
        if (!self::isOnlyLetters($carData["driver_name"])) {
            $_SESSION["car-messages"][] = "В имени могут быть только буквы";
            $isValidated = false;
        }

        return $isValidated;
    }
}