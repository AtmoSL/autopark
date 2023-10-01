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
                   value="<?= (!empty($_SESSION["createCar-form"]["number"]) ?
                       $_SESSION["createCar-form"]["number"] : "") ?>">

            <label for="driver_name" class="form-label">Имя водителя</label>
            <input type="text"
                   name="driver_name"
                   id="driver_name"
                   class="form-control"
                   value="<?= (!empty($_SESSION["createCar-form"]["driver_name"]) ?
                       $_SESSION["createCar-form"]["driver_name"] : "") ?>">

            <?php if (isset($_SESSION["car-messages"])) { ?>
                <div class="form__errors">
                    <ul>
                        <?php foreach ($_SESSION["car-messages"] as $msg) { ?>
                            <li><?= $msg ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php }
            unset($_SESSION["car-messages"]);
            unset($_SESSION["createCar-form"])?>

            <button type="submit" class="btn btn-primary form__btn">Создать</button>
        </form>
    </div>
<?php include dirname(__FILE__) . '/../layouts/footer.php' ?>