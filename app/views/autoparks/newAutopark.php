<?php include dirname(__FILE__) . '/../layouts/header.php'
/** @var array $cars */
/** @var \app\Models\Autopark $autopark */
?>

    <div class="container">
        <h1>Создание Автопарка</h1>
        <form action="/autopark/newForm" class="form" method="post">

            <?php include "elements/newAutopark-autoparkForm.php"?>

            <?php include "elements/newAutopark-carForm.php" ?>

            <button type="submit" class="btn btn-primary form__btn mb-5">Создать автопарк</button>
        </form>
    </div>
<?php include dirname(__FILE__) . '/../layouts/footer.php' ?>