<?php

namespace app\Controllers;

use app\Models\Autopark;
use app\Models\AutoparkCars;
use app\Models\Car;
use service\Auth;
use service\Viewer;

class AutoparkController
{
    public function all()
    {
        $autoparksWithCars = Autopark::all(["id", "title", "address","schedule"])
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

}