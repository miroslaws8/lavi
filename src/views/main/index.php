<?php
    bundle\View::render('layouts/default/header.php');
    bundle\View::render('layouts/header.php');
?>
<div class="mid">
    <h3>Popular Films</h3>
    <hr>
    <div class="sim-slider">
        <ul class="sim-slider-list">
            <li>
                <div class="screen"></div>
            </li>
            <?php foreach ($popularFilms as $key => $film) { ?>
                <li class="sim-slider-element">
                    <img class="poster" src="<?php echo $film['poster']; ?>" alt="<?php echo $key; ?>">
                    <div class="sim-slider-film-info">
                        <h3><?php echo $film['caption']; ?></h3>
                        <small class="sim-slider-film-info_description"><?php echo mb_strimwidth($film['description'], 0, 100, '...'); ?></small>
                        <a href="/films/<?php echo $film['id_film']; ?>" class="btn btn-danger m-top">More</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
        <div class="sim-slider-arrow-left"></div>
        <div class="sim-slider-arrow-right"></div>
        <div class="sim-slider-dots"></div>
    </div>
    <h3>All Films</h3>
    <hr>
    <div class="films-list">
        <?php foreach ($films as $key => $film) { ?>
            <div class="film-item">
                <img class="poster" src="<?php echo $film['poster']; ?>" alt="<?php echo $key; ?>">
                <div class="sim-slider-film-info">
                    <h3><a href="/films/<?php echo $film['id'];?>"><?php echo $film['caption']; ?></a></h3>
                    <small class="sim-slider-film-info_description"><?php echo mb_strimwidth($film['description'], 0, 100, '...'); ?></small>
                    <?php foreach ($sessions as $session) { ?>
                        <span class="badge badge-info m-top"><?php echo $session['caption']; ?></span>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>new Sim()</script>

<?php
    bundle\View::render('layouts/default/footer.php');
?>