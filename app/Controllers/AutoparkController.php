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
    public function __construct()
    {
        if (Auth::getRoleId() != 2) {
            Router::back();
            exit();
        }
    }

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
                ["number as carNumber", "driver_name", "id as carId"])
            ->find();

        $cars = [];
        foreach ($autoparksWithCars as $element) {
            $cars[$element->carId]["number"] = $element->carNumber;
            $cars[$element->carId]["driver_name"] = $element->driver_name;
        }

        Viewer::view("autoparks/editAutopark", compact('autopark', 'cars'));
    }

    public function addCarToAutopark($carData)
    {
        $number = $carData["number"];
        $driver_name = $carData["driver_name"];
        $autoparkId = $carData["autoparkId"];

        $_SESSION["addCarToAutopark-form"] = $carData;

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

    public function editCar($carData)
    {
        array_map("trim", $carData);


        $validation = CarValidator::validate($carData);

        if (!$validation) {
            $_SESSION["autoParkCarsEdit-messages"][$carData["id"]] = $_SESSION["car-messages"];
            unset($_SESSION["car-messages"]);

            $_SESSION["autoParkCarsEdit-form"][$carData["id"]] = $carData;

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

    public function deleteCar($carData)
    {
        $id = $carData["id"];
        $autoparkId = $carData["autopark"];

        if (!is_numeric($id)) {
            http_response_code(404);
            Viewer::view('404');
            exit();
        }

        AutoparkCars::delete([
            "autopark_id" => $autoparkId,
            "car_id" => $id
        ], ["=", "="]);

        Router::back();
        return true;
    }

    public function new()
    {
        Viewer::view("autoparks/newAutopark");
    }

    public function newForm($autoparkData)
    {
        array_map("trim", $autoparkData["autopark"]);
        $autopark = $autoparkData["autopark"];
        $cars = $autoparkData["cars"];

        $_SESSION["autoparkCreate-form"] = $autoparkData;

        $autoparkValidation = AutoparkValidator::validate($autopark);
        $carsValidation = true;


        foreach ($cars as $key => $car) {

            $carValidation = CarValidator::validate($car);

            if (!$carValidation) $carsValidation = false;
            if (!$carValidation) {
                $_SESSION["autoParkCars-messages"][$key] = $_SESSION["car-messages"];
                unset($_SESSION["car-messages"]);
            }
        }

        if (!$carsValidation) {
            Router::back();
            return false;
        }

        if (!$autoparkValidation) {
            Router::back();
            return false;
        }

        $autoparkId = Autopark::create([
            "title" => $autopark["title"],
            "address" => $autopark["address"],
            "schedule" => $autopark["schedule"],
        ], true);

        foreach ($cars as $newCar) {
            $car = Car::where([
                "number" => $newCar["number"],
                "driver_name" => $newCar["driver_name"],
            ], ["=", "="], ["id"])->find();


            if (count($car) > 0) {
                AutoparkCars::create([
                    "autopark_id" => $autoparkId,
                    "car_id" => $car[0]->id
                ]);
            } else {
                $newCarId = Car::create([
                    "number" => $newCar["number"],
                    "driver_name" => $newCar["driver_name"]
                ], true);

                AutoparkCars::create([
                    "autopark_id" => $autoparkId,
                    "car_id" => $newCarId
                ]);
            }
        }

        Router::redirect("/autopark/edit?id=" . $autoparkId);
        exit();
    }

    public function delete($autoparkData)
    {
        $id = $autoparkData["id"];

        if (!is_numeric($id)) {
            http_response_code(404);
            Viewer::view('404');
            exit();
        }

        Autopark::delete([
            "id" => $id
        ], ["="]);

        Router::redirect("/autoparks");
    }
}