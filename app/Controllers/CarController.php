<?php

namespace app\Controllers;

use app\Models\Autopark;
use app\Models\AutoparkCars;
use app\Models\Car;
use app\Models\User;
use app\Validators\CarValidator;
use Couchbase\View;
use service\Auth;
use service\Router;
use service\Viewer;

class CarController
{
    public function __construct()
    {
        if(Auth::getRoleId()!=1){
            Router::back();
            exit();
        }
    }

    public function driverCars()
    {
        if (!Auth::isAuth()) {
            Router::redirect("/login");
        }

        $driverId = Auth::getId();

        $carsWithAutopark = Car::where(["user_id" => $driverId], ["="], ["id", "number"])
            ->withLeft(AutoparkCars::$table,
                [AutoparkCars::$table . ".car_id" . "=" . Car::$table . ".id"])
            ->withLeft(Autopark::$table,
                [AutoparkCars::$table . ".autopark_id" . "=" . Autopark::$table . ".id"],
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

        if (!is_numeric($id)) {
            http_response_code(404);
            Viewer::view('404');
            exit();
        }

        $userId = Auth::getId();

        $car = Car::where(["id" => $id, "user_id" => $userId],
            ["=", "="],
            ["id", "number", "driver_name"])->find();

        if (count($car) < 1) {
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

        $validation = CarValidator::validate($carData);

        if (!$validation) {
            Router::back();
            return false;
        }

        Car::where(['id' => $carData["id"]], ["="])
            ->set([
                "number" => $carData["number"],
                "driver_name" => $carData["driver_name"],
            ]);

        Router::back();
        return true;

    }

    public function new()
    {
        $_POST["driver_name"] = User::where(["id" => Auth::getId()],
            ["="],
            ["name"])
            ->find()[0]->name;

        Viewer::view("cars/newCar");
    }

    public function newForm($carData)
    {
        array_map("trim", $carData);

        $validation = CarValidator::validate($carData);

        $_SESSION["createCar-form"] = $carData;

        if (!$validation) {
            Router::back();
            return false;
        }

        Car::create([
            "number" => $carData["number"],
            "user_id" => Auth::getId(),
            "driver_name" => $carData["driver_name"]
        ]);

        Router::redirect("/cars");
        return true;
    }
}