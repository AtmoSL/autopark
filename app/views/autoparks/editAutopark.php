<?php include dirname(__FILE__) . '/../layouts/header.php'
/** @var array $cars */
/** @var \app\Models\Autopark $autopark */
?>

    <div class="container">
        <h1>Редактирование Автопарка</h1>
        <form action="/autopark/editForm" class="form" method="post">

            <label for="title" class="form-label">Название автопарка</label>
            <input type="text"
                   name="title"
                   id="title"
                   class="form-control"
                   value="<?= $autopark->title ?>">

            <label for="address" class="form-label">Адресс</label>
            <input type="text"
                   name="address"
                   id="address"
                   class="form-control"
                   value="<?= $autopark->address ?>">

            <label for="schedule" class="form-label">Расписание</label>
            <input type="text"
                   name="schedule"
                   id="schedule"
                   class="form-control"
                   value="<?= $autopark->schedule ?>">

            <?php if (isset($_SESSION["editAutopark-messages"])) { ?>
                <div class="form__errors">
                    <ul>
                        <?php foreach ($_SESSION["editAutopark-messages"] as $msg) { ?>
                            <li><?= $msg ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php }
            unset($_SESSION["editAutopark-messages"]); ?>

            <button type="submit" class="btn btn-primary form__btn">Редактировать</button>
        </form>

        <form action="" class="d-flex mt-5 justify-content-center">
            <div class="row align-items-end mb-1">
                <div class="col-md-6">
                    <label for="number" class="form-label">Номер машины</label>
                    <input type="text"
                           name="number"
                           id="number"
                           class="form-control">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-warning w-100">Добавить машину</button>
                </div>
            </div>
        </form>

        <table class="table table-striped table-bordered text-center">
            <thead>
            <tr>
                <th scope="col">Номера привязанных машин</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cars as $number) {; ?>

                <tr>
                    <td><?= $number ?></td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
<?php include dirname(__FILE__) . '/../layouts/footer.php' ?>