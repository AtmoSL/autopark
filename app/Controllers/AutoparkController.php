<?php

namespace app\Controllers;

use app\Models\Autopark;
use app\Models\AutoparkCars;
use app\Models\Car;
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
}