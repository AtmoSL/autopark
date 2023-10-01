<?php include dirname(__FILE__) . '/../layouts/header.php' ?>

    <div class="container">
        <h1>Регистрация</h1>

        <form action="/createuser" class="form" method="post">
            <label for="email" class="form-label">Введите email</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="<?= (!empty($_SESSION["registration-form"]["email"]) ?
                       $_SESSION["registration-form"]["email"] : "") ?>">

            <label for="name" class="form-label">Введите имя</label>
            <input type="name" name="name" id="name" class="form-control"
                   value="<?= (!empty($_SESSION["registration-form"]["name"]) ?
                       $_SESSION["registration-form"]["name"] : "") ?>">

            <label for="password" class="form-label">Введите пароль</label>
            <input type="password" name="password" id="password" class="form-control"
                   value="<?= (!empty($_SESSION["registration-form"]["password"]) ?
                       $_SESSION["registration-form"]["password"] : "") ?>">

            <label for="password-repeat" class="form-label">Повторите пароль</label>
            <input type="password" name="password-repeat" id="password-repeat" class="form-control"
                   value="<?= (!empty($_SESSION["registration-form"]["password-repeat"]) ?
                       $_SESSION["registration-form"]["password-repeat"] : "") ?>">

            <label for="role" class="form-label">Выберите роль</label>
            <select name="role_id" id="role" class="form-control">

                <option value="1" <?= (!empty($_SESSION["registration-form"]["password-repeat"]) &&
                $_SESSION["registration-form"]["role_id"] == 1 ?
                    "selected" : "") ?>>Водитель
                </option>

                <option value="2" <?= (!empty($_SESSION["registration-form"]["password-repeat"]) &&
                $_SESSION["registration-form"]["role_id"] == 2 ?
                    "selected" : "") ?>>Менеджер
                </option>

            </select>

            <?php if (isset($_SESSION["register-messages"])) { ?>
                <div class="form__errors">
                    <ul>
                        <?php foreach ($_SESSION["register-messages"] as $msg) { ?>
                            <li><?= $msg ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php }
            unset($_SESSION["register-messages"]);
            unset($_SESSION["registration-form"]); ?>

            <button type="submit" class="btn btn-primary form__btn">Зарегистрироваться</button>
        </form>
    </div>

<?php include dirname(__FILE__) . '/../layouts/footer.php' ?>