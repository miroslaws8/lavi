<?php
bundle\View::render('layouts/default/header.php');
?>

<?php if ($error) { ?>
    <div class="form-signin">
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    </div>
<?php } ?>

<form class="form-signin" method="post" action="login/signin">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="login" class="sr-only">Login</label>
    <input name="login" type="text" id="login" class="form-control" placeholder="Login" required autofocus>
    <label for="password" class="sr-only">Password</label>
    <input name="password" type="password" id="password" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>