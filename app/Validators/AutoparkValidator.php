<?php

namespace app\Validators;

use service\Validator;

class AutoparkValidator extends Validator
{
    /**
     * Валидация полей автопарка
     * @param $autoparkData
     * @return bool
     */
    public static function validate($autoparkData): bool
    {
        $isValidated = true;

        if(self::isEmpty($autoparkData["title"])){
            $_SESSION["autopark-messages"][] = "Пожалуйста, укажите название автопарка";
            $isValidated = false;
        }
        if(self::isEmpty($autoparkData["address"])){
            $_SESSION["autopark-messages"][] = "Пожалуйста, укажите адрес автопарка";
            $isValidated = false;
        }

        return $isValidated;
    }
}