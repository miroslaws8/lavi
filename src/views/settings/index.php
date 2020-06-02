<?php
bundles\View::render('layouts/default/header.php');
?>
<div class="settings">
    <div class="list scene-settings" id="scene-settings">
        <form method="post" action="/settings/action">
            <div class="form-group">
                <label for="groupBy">Группировка ответов:</label>
                <select class="form-control" id="groupBy" name="groupBy">
                    <option value="5">По 5 ответов</option>
                    <option value="10">По 10 ответов</option>
                    <option value="15">По 15 ответов</option>
                    <option value="20">По 20 ответов</option>
                </select>
            </div>
            <div class="form-group">
                <label for="time">Время теста:</label>
                <input name="time" value="<?= $settings['time'] ?? '' ?>" type="time" class="form-control" id="time">
            </div>
            <div class="form-group">
                <label for="width">Ширина кубика (px):</label>
                <input name="width" value="<?= $settings['width'] ?? '' ?>" type="number" class="form-control" id="width" placeholder="10" max="50" min="10">
            </div>
            <div class="form-group">
                <label for="height">Высота кубика (px):</label>
                <input name="height" value="<?= $settings['height'] ?? '' ?>" type="number" class="form-control" id="height" placeholder="10" max="50" min="10">
            </div>
            <div class="form-group">
                <label for="border-width">Ширина обводки (px):</label>
                <input name="border-width" value="<?= $settings['border-width'] ?? '' ?>" type="number" class="form-control" id="border-width" placeholder="10" max="10" min="1">
            </div>
            <div class="form-group">
                <label for="border-color">Цвет обводки:</label>
                <input name="border-color" value="<?= $settings['border-color'] ?? '' ?>" type="color" class="form-control" id="border-color">
            </div>
            <div class="form-group">
                <label for="background-color">Цвет фона:</label>
                <input name="background-color" value="<?= $settings['background-color'] ?? '' ?>" type="color" class="form-control" data-ident="scene" id="background-color">
            </div>
            <div class="form-group">
                <label for="background-color">Цвет фона при ошибке:</label>
                <input name="background-color-error" value="<?= $settings['background-color-error'] ?? '' ?>" type="color" class="form-control" data-ident="scene" id="background-color-error">
            </div>
            <div class="form-group">
                <label for="color">Цвет текста:</label>
                <input name="color" type="color" value="<?= $settings['color'] ?? '' ?>" class="form-control" data-ident="scene" id="color">
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
bundles\View::render('layouts/default/footer.php');
?>