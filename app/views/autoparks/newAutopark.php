<?php include dirname(__FILE__) . '/../layouts/header.php'
/** @var array $cars */
/** @var \app\Models\Autopark $autopark */
?>

    <div class="container">
        <h1>Редактирование Автопарка</h1>
        <form action="/autopark/newForm" class="form" method="post">
            <label for="title" class="form-label">Название автопарка</label>
            <input type="text"
                   name="autopark[title]"
                   id="title"
                   class="form-control">

            <label for="address" class="form-label">Адресс</label>
            <input type="text"
                   name="autopark[address]"
                   id="address"
                   class="form-control">

            <label for="schedule" class="form-label">Расписание</label>
            <input type="text"
                   name="autopark[schedule]"
                   id="schedule"
                   class="form-control">

            <?php if (isset($_SESSION["autopark-messages"])) { ?>
                <div class="form__errors">
                    <ul>
                        <?php foreach ($_SESSION["autopark-messages"] as $msg) { ?>
                            <li><?= $msg ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php }
            unset($_SESSION["autopark-messages"]); ?>

            <div class="cars" id="all-cars">
                <div class="car__row d-flex justify-content-between">
                    <label for="number" class="form-label text-center">Номер машины
                        <input type="text"
                               name="cars[car0][number]"
                               id="number"
                               class="form-control"></label>

                    <label for="driver_name" class="form-label text-center">Имя водителя
                        <input type="text"
                               name="cars[car0][driver_name]"
                               id="driver_name"
                               class="form-control"> </label>
                </div>
            </div>
            <div class="btn btn-warning w-100" id="add-car">Добавить ещё одну машину</div>
            <button type="submit" class="btn btn-primary form__btn mb-5">Создать автопарк</button>
        </form>
    </div>
<?php include dirname(__FILE__) . '/../layouts/footer.php' ?>