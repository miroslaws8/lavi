<nav class="navbar sticky-top navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="mid row">
        <a class="navbar-brand" href="#">Task Manager</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
        <?php if (!\bundle\Session::getIsLoggedIn()) { ?>
            <a href="/login" class="btn btn-primary my-2 my-sm-0">Sign In</a>
        <?php } else { ?>
            <a href="/admin" class="btn btn-primary my-2 my-sm-0">Admin</a>
        <?php } ?>
    </div>
</nav>