<?php

namespace app\Validators;

use app\Models\Car;
use service\Validator;

class CarValidator extends Validator
{
    /**
     * Проверка данных машины при редактировании
     * @param $carData
     * @return bool
     */
    public static function editValidate($carData) : bool
    {
        $isValidated = true;
        $carById = Car::where(["id" => $carData["id"]],
            ["="],
            ["id"])->find();

        if(!self::isNumberUnique($carData["id"], $carData["number"])){
            $_SESSION["editCar-messages"][] = "Машина с таким номером уже существует в базе";
            $isValidated = false;
        }
        if(empty($carData["number"])){
            $_SESSION["editCar-messages"][] = "Пожалуйста, укажите номер машины";
            $isValidated = false;
        }
        if(empty($carData["driver_name"])){
            $_SESSION["editCar-messages"][] = "Пожалуйста, укажите номер водителя";
            $isValidated = false;
        }
        if (!self::isOnlyLetters($carData["driver_name"])) {
            $_SESSION["editCar-messages"][] = "В имени могут быть только буквы";
            $isValidated = false;
        }

        return $isValidated;
    }

    /**
     * Проверка на уникальность номера
     * @param $carId
     * @param $number
     * @return bool
     */
    private static function isNumberUnique($carId,$number) :bool
    {
        $carWithNumber = Car::where(
            ["id" => $carId, "number"=>$number],
            ["!=", "="],
            ["id"]
        )->find();

        if(count($carWithNumber) >0){
            return false;
        }

        return true;
    }
}