<?php
bundle\View::render('layouts/default/header.php');
?>
<div class="position-center" style="width: fit-content;height: fit-content;">
    <?php
    $validator = new \bundle\Validator();
    $error     = $validator->getError();
    if (!empty($error)) {
        ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php } ?>
    <h1 style="color: #fff;">Регистрация</h1>
    <hr>
    <form method="post" action="/signup/action">
        <div class="form-group">
            <label for="name">Ваше имя</label>
            <input name="name" type="text" class="form-control" id="name" placeholder="Имя">
            <small class="form-text text-muted">Введите свое имя!</small>
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Пароль">
            <small class="form-text text-muted">Введите свой пароль!</small>
        </div>
        <button type="submit" class="btn btn-info">Регистрация</button>
    </form>
    <div style="margin-top: 10px">
        <a href="/signin" class="sublink"><small>У меня есть аккаунт</small></a>
    </div>
</div>
<?php
bundle\View::render('layouts/default/footer.php');
?>