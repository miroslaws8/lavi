<?php
bundle\View::render('layouts/default/header.php');
?>
<div class="settings">
    <div class="list scene-settings" id="scene-settings">
        <form method="post" action="/settings/action">
            <div class="form-group">
                <label for="speed">Скорость:</label>
                <input min="0.1" max="2" step="0.1" name="speed" value="<?= $settings['speed'] ?? '' ?>" type="range" class="form-control" id="speed">
                <small class="speed-value"></small>
                <script>
                    jQuery('#speed').change(function () {
                        let speed = jQuery('#speed').val();
                        let html  = speed + ' - средняя скорость куба.'
                        if (speed > 1) {
                            html = speed + ' - большая скорость куба.';
                        } else if (speed < 1) {
                            html = speed + ' - маленькая скорость куба.';
                        }

                        jQuery('.speed-value').html(html);
                    });
                </script>
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
bundle\View::render('layouts/default/footer.php');
?>