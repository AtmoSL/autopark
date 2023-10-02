<?php /** @var array $cars */
foreach ($cars as $id => $car) { ?>
    <form action="/autopark/edit/changeCar" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
    <div class="car__row d-flex w-100 justify-content-center">
        <div class="car__row__inputs">
            <div class="car__row__form">
                <label for="number" class="form-label row text-center">Номер машины
                    <input type="text"
                           name="number"
                           id="number"
                           class="form-control"
                           value="<?= (!empty($_SESSION["autoParkCarsEdit-form"][$id]["number"]) ?
                               $_SESSION["autoParkCarsEdit-form"][$id]["number"] : $car["number"]) ?>"></label>


                <label for="driver_name" class="form-label row text-center">Имя водителя
                    <input type="text"
                           name="driver_name"
                           id="driver_name"
                           class="form-control"
                           value="<?= (!empty($_SESSION["autoParkCarsEdit-form"][$id]["driver_name"]) ?
                               $_SESSION["autoParkCarsEdit-form"][$id]["driver_name"] : $car["driver_name"]) ?>"> </label>
            </div>
            <div class="car__row__form__btns">
                <button type="submit" class="btn btn-success">Сохранить изменения</button>
                <a href="#" class="btn btn-danger">Удалить</a>
            </div>

            <?php
            if (isset($_SESSION["autoParkCarsEdit-messages"][$id])) { ?>
                <div class="form__errors">
                    <ul>
                        <?php foreach ($_SESSION["autoParkCarsEdit-messages"][$id] as $msg) { ?>
                            <li><?= $msg ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php }
            unset($_SESSION["autoParkCarsEdit-messages"][$id]);
            unset($_SESSION["autoParkCarsEdit-form"]);
            ?>
            <hr>

        </div>

    </div>
    </form>
<?php } ?>