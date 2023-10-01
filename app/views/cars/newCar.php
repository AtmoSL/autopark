<?php include dirname(__FILE__) . '/../layouts/header.php'
/** @var \app\Models\Car $car */
?>

    <div class="container">
        <h1>Создание машины</h1>
        <form action="/cars/newForm" class="form" method="post">

            <label for="number" class="form-label">Номер машины</label>
            <input type="text"
                   name="number"
                   id="number"
                   class="form-control"
                   value="<?= (isset($_POST["number"])) ? $_POST["number"] : "" ?>">

            <label for="driver_name" class="form-label">Имя водителя</label>
            <input type="text"
                   name="driver_name"
                   id="driver_name"
                   class="form-control"
                   value="<?= (isset($_POST["driver_name"])) ? $_POST["driver_name"] : "" ?>">

            <?php if (isset($_SESSION["newCar-messages"])) { ?>
                <div class="form__errors">
                    <ul>
                        <?php foreach ($_SESSION["newCar-messages"] as $msg) { ?>
                            <li><?= $msg ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php }
            unset($_SESSION["newCar-messages"]); ?>

            <button type="submit" class="btn btn-primary form__btn">Создать</button>
        </form>
    </div>
<?php include dirname(__FILE__) . '/../layouts/footer.php' ?>