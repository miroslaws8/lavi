<?php
    bundle\View::render('layouts/default/header.php');
?>
<div class="position-center" style="width: fit-content;height: fit-content;">
    <?php if (!\bundle\Session::getIsLoggedIn()): ?>
        <h1 style="color: #fff;">АМОД</h1>
        <div style="width: 300px">
            <span style="color:#fff;">
                Тест для испытания стресоустойчивости ваших сотрудников.
            </span>
        </div>
        <a href="/signup" style="margin-top: 20px"
           class="btn btn-info">Регистрация</a>
        <div style="margin-top: 10px">
            <a href="/signin" class="sublink"><small>Я уже зарегестрирован</small></a>
        </div>
    <?php else: ?>
        <h1 style="color: #fff;">Приветствуем, <?= $user->name ?>!</h1>
        <div style="width: 300px">
            <small style="color:#fff;">
                Теперь вы можете начать тест или его настройку.
            </small>
        </div>
        <?php if (!empty($user->settings)) : ?>
        <a href="/game" style="margin-top: 20px"
           class="btn btn-success">Начать тест</a>
        <?php endif; ?>
        <a href="/settings" style="margin-top: 20px"
           class="btn btn-info">Настроить тест</a>
        <a href="/logout" style="margin-top: 20px"
           class="btn btn-danger">Выйти</a>
    <?php endif; ?>
</div>

<?php
    bundle\View::render('layouts/default/footer.php');
?>