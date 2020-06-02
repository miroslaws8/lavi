<nav class="navbar sticky-top navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="mid row">
        <a class="navbar-brand" href="#">Game</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            </ul>
        </div>
        <?php if (!\bundles\Session::getIsLoggedIn()) { ?>
            <a href="/signup" class="btn btn-primary my-2 my-sm-0">Регистрация</a>
        <?php } ?>
    </div>
</nav>