<?php
bundle\View::render('layouts/default/header.php');
?>
    <div class="position-center" style="width: fit-content;height: fit-content;">
            <h1 style="color: #fff;">Тест окончен</h1>
        <a href="/game" style="margin-top: 20px"
           class="btn btn-info">Пройти еще раз</a>
        <a href="/settings" style="margin-top: 20px"
           class="btn btn-danger">Выход</a>
    </div>

<?php
bundle\View::render('layouts/default/footer.php');
?>