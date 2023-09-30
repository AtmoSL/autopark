<?php

namespace app\Controllers;

use app\Models\Autopark;
use app\Models\AutoparkCars;
use app\Models\Car;
use service\Auth;
use service\Router;
use service\Viewer;

class CarController
{
    public function driverCars()
    {
        if(!Auth::isAuth()){
            Router::redirect("/login");
        }

        $driverId = Auth::getId();

        $carsWithAutopark = Car::where(["user_id" => $driverId], ["id", "number"])
        ->with(AutoparkCars::$table,
            [AutoparkCars::$table .".car_id". "=" . Car::$table.".id"])
        ->with(Autopark::$table,
            [AutoparkCars::$table .".autopark_id". "=" . Autopark::$table .".id"],
            ["title as autoparkTitle"])
        ->find();

        $cars = [];

        foreach ($carsWithAutopark as &$carWithAutopark) {
            $id = $carWithAutopark->id;
            $cars[$id]["number"] = $carWithAutopark->number;
            $cars[$id]["autoparks"][] = $carWithAutopark->autoparkTitle;
        }

        Viewer::view("cars", compact("cars"));
    }
}