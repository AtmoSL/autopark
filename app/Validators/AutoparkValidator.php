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

        if(self::isEmpty($autoparkData["title"])){
            $_SESSION["autopark-messages"][] = "Пожалуйста, укажите название автопарка";
        }
        if(self::isEmpty($autoparkData["address"])){
            $_SESSION["autopark-messages"][] = "Пожалуйста, укажите адрес автопарка";
        }

        return count($_SESSION['autopark-messages']) === 0;
    }
}