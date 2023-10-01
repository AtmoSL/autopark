<?php include dirname(__FILE__) .'/../layouts/header.php'
    /** @var \app\Models\Car $car */
/** @var array $cars */
?>

    <div class="container">
        <h1>Машины</h1>
        <a href="/cars/new" class="btn btn-success w-100 mb-3">Создать машину</a>
        <table class="table table-striped table-bordered text-center">
            <thead>
            <tr>
                <th scope="col">Номер машины</th>
                <th scope="col">Автопарки</th>
                <th scope="col">Редактирование</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cars as $id => $car) {; ?>

                <tr>
                    <td><?= $car["number"] ?></td>
                    <td>
                        <?= implode(", ", $car["autoparks"]) ?>
                    </td>
                    <td><a href="/car/edit?id=<?= $id ?>"
                           class="btn btn-primary">Редактировать</a></td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
<?php include dirname(__FILE__) .'/../layouts/footer.php' ?>