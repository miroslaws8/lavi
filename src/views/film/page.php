<?php
bundle\View::render('layouts/default/header.php');
bundle\View::render('layouts/header.php');
?>

<div class="mid">
    <div class="films-list">
        <div class="row">
            <div class="col-6">
                <img class="poster" src="<?php echo $film['poster']; ?>" alt="<?php echo $film['id']; ?>">
            </div>
            <div class="col-6">
                <h3><?php echo $film['caption']; ?></h3>
                <hr>
                <span>
                <?php echo $film['description']; ?>
            </span>
                <div style="margin-top: 20px;">
                    <?php foreach ($sessions as $session) { ?>
                        <button class="btn btn-info"
                                data-toggle="modal"
                                data-target="#modal<?php echo $session['id']; ?>">
                            <?php echo $session['caption']; ?>
                        </button>
                        <?php \bundle\View::render('layouts/default/modal.php', ['hall'=> $hall, 'idFilm' => $film['id'], 'session' => $session]); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
bundle\View::render('layouts/default/footer.php');
?>