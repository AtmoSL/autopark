<div class="cars" id="all-cars">
    <?php if (!empty($_SESSION["autoparkCreate-form"]["cars"])) {
        foreach ($_SESSION["autoparkCreate-form"]["cars"] as $key => $value) { ?>
            <div class="car__row " id="car-row-<?= $key ?>">

                <div class="car__row__form d-flex justify-content-between">
                    <label for="number" class="form-label text-center">Номер машины
                        <input type="text"
                               name="cars[<?= $key ?>][number]"
                               id="number"
                               class="form-control"
                               value="<?= $value["number"] ?>"></label>


                    <label for="driver_name" class="form-label text-center">Имя водителя
                        <input type="text"
                               name="cars[<?= $key ?>][driver_name]"
                               id="driver_name"
                               class="form-control"
                               value="<?= $value["driver_name"] ?>"> </label>
                    <div class="delete_car" id="delete-<?= $key ?>" data-row-id="<?= $key ?>">Х</div>
                </div>


                <?php if (isset($_SESSION["autoParkCars-messages"][$key])) { ?>
                    <div class="form__errors">
                        <ul>
                            <?php foreach ($_SESSION["autoParkCars-messages"][$key] as $msg) { ?>
                                <li><?= $msg ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php }
                unset($_SESSION["autoParkCars-messages"][$key]);
                ?>

            </div>


        <?php } ?>
    <?php }
    unset($_SESSION["autoparkCreate-form"]["cars"]) ?>

</div>
<div class="btn btn-warning w-100" id="add-car">Добавить машину</div>