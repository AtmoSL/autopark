<?php include dirname(__FILE__) .'/../layouts/header.php' ?>

    <div class="container">
        <h1>Вход</h1>

        <form action="/auth" class="form" method="post">
            <label for="email" class="form-label">Введите email</label>
            <input type="email" name="email" id="email" class="form-control">

            <label for="password" class="form-label">Введите пароль</label>
            <input type="password" name="password" id="password" class="form-control">

            <?php if (isset($_SESSION["login-messages"])){?>
                <div class="form__errors">
                    <ul>
                        <?php foreach ($_SESSION["login-messages"] as $msg){ ?>
                            <li><?= $msg ?></li>
                        <?php }?>
                    </ul>
                </div>
            <?php } unset($_SESSION["login-messages"]); ?>

            <button type="submit" class="btn btn-primary form__btn">Войти</button>
        </form>
    </div>

<?php include dirname(__FILE__) .'/../layouts/footer.php' ?>