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
        if(self::isEmpty($carData["number"])){
            $_SESSION["car-messages"][] = "Пожалуйста, укажите номер машины";
        }
        if(self::isEmpty($carData["driver_name"])){
            $_SESSION["car-messages"][] = "Пожалуйста, укажите номер водителя";
        }
        if (!self::isOnlyLetters($carData["driver_name"])) {
            $_SESSION["car-messages"][] = "В имени могут быть только буквы";
        }

        return count($_SESSION['car-messages']) === 0;

    }
}