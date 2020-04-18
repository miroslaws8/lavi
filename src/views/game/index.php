<?php
bundle\View::render('layouts/default/header.php');
bundle\View::render('layouts/header.php');
?>
    <div class="mid">
        <div class="start-game">
            <small>Нажав кнопку, вы наччнете игру, которая вас может убить!</small>
            <button type="button" id="start" onclick="App.start()" class="btn btn-success">Начать игру</button>
        </div>
        <div class="game-scene">
            <div class="question"></div>
            <div class="cube"></div>
        </div>
    </div>
<?php
bundle\View::render('layouts/default/footer.php');
?>