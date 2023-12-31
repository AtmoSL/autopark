<?php include dirname(__FILE__) . '/../layouts/header.php'
/** @var array $cars */
/** @var \app\Models\Autopark $autopark */
?>

    <div class="container">
        <h1>Редактирование Автопарка</h1>
        <form action="/autopark/editForm" class="form" method="post">

            <input type="hidden" name="autoparkId" value="<?= $autopark->id ?>">

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

            <button type="submit" class="btn btn-primary form__btn">Редактировать</button>
        </form>

        <button type="button"
                class="btn btn-danger mt-3 w-100"
                id="deleteAutopark"
                data-autopark-id="<?= $autopark->id ?>">Удалить автопарк
        </button>

        <form action="/autopark/edit/addcar" method="post" class="mt-3">
            <input type="hidden" name="autoparkId" value="<?= $autopark->id ?>">
            <label for="number" class="form-label">Номер машины</label>
            <input type="text"
                   name="number"
                   id="number"
                   class="form-control"
                   value="<?= (!empty($_SESSION["addCarToAutopark-form"]["number"]) ?
                       $_SESSION["addCarToAutopark-form"]["number"] : "") ?>">

            <label for="driver_name" class="form-label">Имя водителя</label>
            <input type="text"
                   name="driver_name"
                   id="driver_name"
                   class="form-control"
                   value="<?= (!empty($_SESSION["addCarToAutopark-form"]["driver_name"]) ?
                $_SESSION["addCarToAutopark-form"]["driver_name"] : "") ?>">
            <button type="submit" class="btn btn-warning w-100 mt-2 mb-2">Добавить машину</button>
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
            unset($_SESSION["addCarToAutopark-form"])?>
        </form>


        <div class="cars">
            <div class="title text-center"><strong>Привязанные машины</strong></div>
            <?php include "elements/editAutopark-carForm.php"?>

        </div>

<!--        <table class="table table-striped table-bordered text-center">-->
<!--            <thead>-->
<!--            <tr>-->
<!--                <th scope="col">Номера привязанных машин</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            --><?php //foreach ($cars as $number) {
//                ; ?>
<!---->
<!--                <tr>-->
<!--                    <td>--><?php //= $number ?><!--</td>-->
<!--                </tr>-->
<!---->
<!--            --><?php //} ?>
<!--            </tbody>-->
<!--        </table>-->
    </div>
<?php include dirname(__FILE__) . '/../layouts/footer.php' ?>