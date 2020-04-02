<?php
bundle\View::render('layouts/default/header.php');
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="#">Films <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <a href="/logout" class="btn btn-primary">Logout</a>
    </div>
</nav>
<div class="main">
    <div class="table">
        <div class="table-header">
            <h2>Films</h2>
            <div class="table-actions-top">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                    Add Film
                </button>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th width="5%" scope="col">#</th>
                <th width="20%" scope="col">Caption</th>
                <th width="40%" scope="col">Description</th>
                <th scope="col">Poster</th>
                <th scope="col">Create At</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($films as $film) { ?>
                <tr>
                    <th scope="row"><?php echo $film['id']; ?></th>
                    <td><?php echo $film['caption']; ?></td>
                    <td><?php echo $film['description']; ?></td>
                    <td><img src="<?php echo $film['poster']; ?>" /></td>
                    <td><?php echo date('d/m/Y', strtotime($film['cdate'])); ?></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Page</a>
                                <a data-toggle="modal" data-target="#edit-<?php echo $film['id']; ?>" class="dropdown-item" href="/films/<?php echo $film['id']; ?>/edit">Edit</a>
                                <a class="dropdown-item" href="/films/<?php echo $film['id']; ?>/remove">Remove</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php \bundle\View::render('admin/edit_modal.php', ['film' => $film]) ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Film</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="films/add" id="addFilm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="caption">Caption</label>
                        <input required name="caption" type="text" class="form-control" id="caption" placeholder="Caption">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea required name="description" class="form-control" id="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="poster">Poster</label>
                        <input required name="poster" type="file" class="form-control-file" id="poster">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button form="addFilm" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

<?php
bundle\View::render('layouts/default/footer.php');
?>