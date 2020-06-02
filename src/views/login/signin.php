<?php
bundles\View::render('layouts/default/header.php');
?>
    <div class="position-center" style="width: fit-content;height: fit-content;">
        <?php
            $validator = new \bundles\Validator();
            $error     = $validator->getError();
            if (!empty($error)) {
        ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php } ?>

        <h1 style="color: #fff;">Вход</h1>
        <hr>
        <form method="post" action="/signin/action">
            <div class="form-group">
                <label for="name">Ваш логин</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Логин">
                <small class="form-text text-muted">Введите свой логин</small>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input name="password" type="password" class="form-control" id="password" placeholder="Пароль">
                <small class="form-text text-muted">Введите свой пароль</small>
            </div>
            <button type="submit" class="btn btn-info">Войти</button>
        </form>
        <div style="margin-top: 10px">
            <a href="/signup" class="sublink"><small>Зарегистрироваться</small></a>
        </div>
    </div>
<?php
bundles\View::render('layouts/default/footer.php');
?>