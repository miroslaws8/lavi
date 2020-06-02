<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$arr = [
    [3, 5, 3, 13],
    [15, 6, 7,  8],
    [15, 6, 7,  8],
    [9, 10, 11, 12]
];

function transponse($input)
{
    foreach($input as $key => $value) {
        foreach($value as $key1 => $value_of_array) {
            $arr[$key1][$key] = $value_of_array;
        }
    }
    return $arr;
}

foreach(transponse($arr) as $row) {
    print_r($row);
}
exit;

bundles\View::render('layouts/default/header.php');
?>
<div class="position-center" style="width: fit-content;height: fit-content;">
    <?php if (!\bundles\Session::getIsLoggedIn()): ?>
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
    bundles\View::render('layouts/default/footer.php');
?>