<?php
bundle\View::render('layouts/default/header.php');
?>
<div class="settings">
    <div style="margin: 10px 0;">
        <button id="start" onclick="App.start(this)" type="button" class="btn btn-primary">Старт</button>
        <button id="stop" onclick="App.stop(this)" disabled type="button" class="btn btn-danger">Стоп</button>
        <button type="button" class="btn btn-dark">Выход</button>
        <button class="btn btn-info" role="alert" disabled>
            Пауза - Space
        </button>
        <button class="btn btn-info" role="alert" disabled>
            Выйти - Escape
        </button>
        <div class="game-time alert alert-info">
            <span id="game-time"><?php echo $configs['time']; ?></span>
        </div>
    </div>
    <div id="game-scene" class="game-scene">
        <div class="answer"></div>
        <div id="cube" class="cube">
            <div class="question"></div>
        </div>
    </div>
</div>

<?php
bundle\View::render('layouts/default/footer.php');
?>