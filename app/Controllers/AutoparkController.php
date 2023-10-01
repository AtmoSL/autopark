<?php

namespace app\Controllers;

use app\Models\Autopark;
use app\Models\AutoparkCars;
use app\Models\Car;
use app\Validators\AutoparkValidator;
use app\Validators\CarValidator;
use service\Auth;
use service\Router;
use service\Viewer;

class AutoparkController
{
    public function all()
    {
        $autoparksWithCars = Autopark::all(["id", "title", "address", "schedule"])
            ->withLeft(AutoparkCars::$table,
                [AutoparkCars::$table . ".autopark_id" . "=" . Autopark::$table . ".id"])
            ->withLeft(Car::$table,
                [AutoparkCars::$table . ".car_id" . "=" . Car::$table . ".id"],
                ["number as carNumber"])
            ->find();

        $autoparks = [];

        foreach ($autoparksWithCars as &$element) {
            $id = $element->id;
            $autoparks[$id]["title"] = $element->title;
            $autoparks[$id]["address"] = $element->address;
            $autoparks[$id]["schedule"] = $element->schedule;
            $autoparks[$id]["carsNumbers"][] = $element->carNumber;
        }

        Viewer::view("autoparks/allAutoparks", compact("autoparks"));
    }

    public function edit($autoparkData)
    {
        $id = $autoparkData["id"];

        if (!is_numeric($id)) {
            http_response_code(404);
            Viewer::view('404');
            exit();
        }

        $autopark = Autopark::where(["id" => $id], ["="])->find();

        if (count($autopark) < 1) {
            http_response_code(404);
            Viewer::view('404');
            exit();
        }
        $autopark = $autopark[0];

        $autoparksWithCars = Autopark::where(["id" => $autopark->id], ["="], ["id"])
            ->withLeft(AutoparkCars::$table,
                [AutoparkCars::$table . ".autopark_id" . "=" . Autopark::$table . ".id"])
            ->withLeft(Car::$table,
                [AutoparkCars::$table . ".car_id" . "=" . Car::$table . ".id"],
                ["number as carNumber"])
            ->find();

        $cars = [];
        foreach ($autoparksWithCars as $element) {
            $cars[] = $element->carNumber;
        }

        Viewer::view("autoparks/editAutopark", compact('autopark', 'cars'));
    }

    public function addCarToAutopark($carData)
    {
        $number = $carData["number"];
        $driver_name = $carData["driver_name"];
        $autoparkId = $carData["autoparkId"];

        $car = Car::where([
            "number" => $number,
            "driver_name" => $driver_name
        ], ["=", "="], ["id"])->find();

        if (count($car) > 0) {

            $autoparkCars = AutoparkCars::where([
                "autopark_id" => $autoparkId,
                "car_id" => $car[0]->id
            ], ["=", "="], ["id"])->find();

            if (count($autoparkCars) == 0) {
                AutoparkCars::create([
                    "autopark_id" => $autoparkId,
                    "car_id" => $car[0]->id
                ]);
                Router::back();
                exit();
            }

            $_SESSION["car-messages"][] = "Машина с такими параметрами уже привязана к автопарку";
            Router::back();
            exit();
        }

        $validation = CarValidator::validate($carData);

        if (!$validation) {
            Router::back();
            return false;
        }

        $newCarId = Car::create([
            "number" => $number,
            "driver_name" => $driver_name
        ], true);
        AutoparkCars::create([
            "autopark_id" => $autoparkId,
            "car_id" => $newCarId
        ]);
        Router::back();
        exit;
    }

    public function editForm($autoparkData)
    {
        array_map("trim", $autoparkData);

        $validation = AutoparkValidator::validate($autoparkData);

        if (!$validation) {
            Router::back();
            return false;
        }
        Autopark::where(['id' => $autoparkData["autoparkId"]], ["="])
            ->set([
                "title" => $autoparkData["title"],
                "address" => $autoparkData["address"],
                "schedule" => $autoparkData["schedule"]
            ]);

        Router::back();
        return true;
    }
}