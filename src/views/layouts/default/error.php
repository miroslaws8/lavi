<?php
bundle\View::render('layouts/default/header.php');
?>
<div class="position-center" style="width: fit-content;height: fit-content;">
    <h1 style="color: #fff;">Error</h1>
    <div>
        <span style="color:#fff;">
            Message: <?php echo $message; ?>
        </span>
        <span style="color:#fff;">
            <?php if ($code) { ?>
                <p>Code: <?php echo $code; ?></p>
            <?php } ?>
        </span>
    </div>
    <a href="/" style="margin-top: 20px"
       class="btn btn-info">Home</a>
</div>

