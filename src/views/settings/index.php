<?php
bundle\View::render('layouts/default/header.php');
?>
<div class="settings">
    <div class="list scene-settings" id="scene-settings">
        <form method="post" action="/settings/action">
            <div class="form-group">
                <label for="width">Время теста:</label>
                <input name="time" type="time" class="form-control" id="time">
            </div>
            <div class="form-group">
                <label for="width">Ширина кубика (px):</label>
                <input name="width" type="number" class="form-control" id="width" placeholder="10" max="50" min="10">
            </div>
            <div class="form-group">
                <label for="height">Высота кубика (px):</label>
                <input name="height" type="number" class="form-control" id="height" placeholder="10" max="50" min="10">
            </div>
            <div class="form-group">
                <label for="border-width">Ширина обводки (px):</label>
                <input name="border-width" type="number" class="form-control" id="border-width" placeholder="10" max="10" min="1">
            </div>
            <div class="form-group">
                <label for="border-color">Цвет обводки:</label>
                <input name="border-color" type="color" class="form-control" id="border-color">
            </div>
            <div class="form-group">
                <label for="background-color">Цвет фона:</label>
                <input name="background-color" type="color" class="form-control" data-ident="scene" id="background-color">
            </div>
            <div class="form-group">
                <label for="color">Цвет текста:</label>
                <input name="color" type="color" class="form-control" data-ident="scene" id="color">
            </div>
            <div class="form-group">
                <button id="submit-settings" class="btn btn-success" type="submit">Принять</button>
                <a href="/" id="submit-settings" class="btn btn-danger">Назад</a>
            </div>
        </form>
    </div>
    <div class="scene">
        <div class="text">
            20 + 20
        </div>
        <div class="cube"></div>
    </div>
</div>
<?php
bundle\View::render('layouts/default/footer.php');
?>