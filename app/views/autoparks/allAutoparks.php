<?php include dirname(__FILE__) .'/../layouts/header.php'
/** @var \app\Models\Car $autopark */
/** @var array $autoparks */
?>

    <div class="container">
        <h1>Автопарки</h1>
        <a href="/autoparks/new" class="btn btn-success w-100 mb-3">Создать автопарк</a>
        <table class="table table-striped table-bordered text-center">
            <thead>
            <tr>
                <th scope="col">Название</th>
                <th scope="col">Адрес</th>
                <th scope="col">График</th>
                <th scope="col">Машины</th>
                <th scope="col">Редактирование</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($autoparks as $id => $autopark) {; ?>

                <tr>
                    <td><?= $autopark["title"] ?></td>
                    <td><?= $autopark["address"] ?></td>
                    <td><?= $autopark["schedule"] ?></td>
                    <td><?php foreach ($autopark["carsNumbers"] as $number){?>
                        <?=$number?>, </br>
                       <?php }?> </td>
                    <td><a href="/autopark/edit?id=<?= $id ?>"
                           class="btn btn-primary">Редактировать</a></td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
<?php include dirname(__FILE__) .'/../layouts/footer.php' ?>
