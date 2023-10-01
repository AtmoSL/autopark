<?php

namespace app\Controllers;

use app\Models\Autopark;
use app\Models\AutoparkCars;
use app\Models\Car;
use app\Validators\CarValidator;
use Couchbase\View;
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

        $carsWithAutopark = Car::where(["user_id" => $driverId],["="], ["id", "number"])
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

        Viewer::view("cars/allUserCars", compact("cars"));
    }

    public function edit($carData)
    {
        $id = $carData["id"];

        if(!is_numeric($id)){
            http_response_code(404);
            Viewer::view('404');
            exit();
        }

        $userId = Auth::getId();

        $car = Car::where(["id"=>$id, "user_id"=>$userId],
            ["=","="],
            ["id", "number", "driver_name"])->find();

        if(count($car) < 1){
            http_response_code(404);
            Viewer::view('404');
            exit();
        }

        $_POST["id"] = $car[0]->id;
        $_POST["number"] = $car[0]->number;
        $_POST["driver_name"] = $car[0]->driver_name;

        Viewer::view("cars/editCar");
    }

    public function editForm($carData)
    {
        array_map("trim", $carData);

        $validation = CarValidator::editValidate($carData);

        if (!$validation) {
            Router::back();
            return false;
        }

        Car::where(['id'=>$carData["id"]], ["="])
        ->set([
            "number" => $carData["number"],
            "driver_name" => $carData["driver_name"],
        ]);

        Router::back();
        return true;

    }
}