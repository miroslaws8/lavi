<?php
bundle\View::render('layouts/default/header.php');
?>
<div class="settings">
    <div style="margin: 10px 0;">
        <button id="start" onclick="App.start(this)" type="button" class="btn btn-primary">Старт</button>
        <button id="stop" onclick="App.stop(this)" disabled type="button" class="btn btn-danger">Стоп</button>
        <a href="/settings" class="btn btn-dark">Выход</a>
        <button class="btn btn-danger" role="alert" disabled>
            За пределами - <span id="cursorError">0</span> раз.
        </button>
        <button class="btn btn-info" data-toggle="modal" data-target="#info">
            Инфо
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
        <div class="cursor"></div>
    </div>
</div>
<div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="info" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Информация</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>Команды:</h4>
                <button class="btn btn-info" role="alert" disabled>
                    Пауза - Space
                </button>
                <button class="btn btn-info" role="alert" disabled>
                    Выйти - Escape
                </button>
                <br><br>
                <h4>Как играть:</h4>
                <span>
                    Вы видите появляющийся каждые несколько секунд пример
                    над кубом, и ответ в левой верхнем углу. Так же вы должны держать курсор мыши внутри куба.
                    <br><br>
                    Если ответ меньше, чем появившийся, то нажмите <strong>Левую кнопку</strong> мыши.
                    <br>
                    Если ответ равен, чем появившийся, то нажмите <strong>Колесико</strong> мыши.
                    <br>
                    Если ответ больше, чем появившийся, то нажмите <strong>Правую кнопку</strong> мыши.
                </span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<?php
bundle\View::render('layouts/default/footer.php');
?>
<script async>
    App.token = '<?php echo $token; ?>';
    App.settings = '<?php echo $settings; ?>'
</script>
