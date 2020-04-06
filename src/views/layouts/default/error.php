<?php
bundle\View::render('layouts/default/header.php');
?>
<div class="mid">
    <div class="jumbotron">
        <h1 class="display-4">Error</h1>
        <hr class="my-4">
        <p>Message: <?php echo $message; ?></p>
        <?php if ($code) { ?>
        <p>Code: <?php echo $code; ?></p>
        <?php } ?>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="/" role="button">На главную</a>
        </p>
    </div>
</div>
