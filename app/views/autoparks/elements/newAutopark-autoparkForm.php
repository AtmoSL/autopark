<?php if (empty($_SESSION["autoparkCreate-form"]["autopark"])) { ?>
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
<?php } else { ?>

    <label for="title" class="form-label">Название автопарка</label>
    <input type="text"
           name="autopark[title]"
           id="title"
           class="form-control"
           value="<?= $_SESSION["autoparkCreate-form"]["autopark"]["title"] ?>">

    <label for="address" class="form-label">Адресс</label>
    <input type="text"
           name="autopark[address]"
           id="address"
           class="form-control"
           value="<?= $_SESSION["autoparkCreate-form"]["autopark"]["address"] ?>">

    <label for="schedule" class="form-label">Расписание</label>
    <input type="text"
           name="autopark[schedule]"
           id="schedule"
           class="form-control"
           value="<?= $_SESSION["autoparkCreate-form"]["autopark"]["schedule"] ?>">

<?php } ?>

<?php if (isset($_SESSION["autopark-messages"])) { ?>
    <div class="form__errors">
        <ul>
            <?php foreach ($_SESSION["autopark-messages"] as $msg) { ?>
                <li><?= $msg ?></li>
            <?php } ?>
        </ul>
    </div>
<?php }
unset($_SESSION["autopark-messages"]);
unset($_SESSION["autoparkCreate-form"]["autopark"]); ?>