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
        </ul>
        <a href="/logout" class="btn btn-primary">Logout</a>
    </div>
</nav>
<div class="main">
    <div class="table">
        <div class="table-header">
            <h2>Tasks</h2>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th width="5%" scope="col">#</th>
                <th width="20%" scope="col">Name</th>
                <th width="40%" scope="col">E-mail</th>
                <th scope="col">Text</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $task) { ?>
                <tr>
                    <th scope="row"><?php echo $task['id']; ?></th>
                    <td><?php echo $task['author']; ?></td>
                    <td><?php echo $task['email']; ?></td>
                    <td width="40%"><?php echo $task['text']; ?></td>
                    <td><?php echo $task['status'] ?></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-<?php echo $task['id']?>">
                            Edit
                        </button>
                    </td>
                </tr>
                <?php \bundle\View::render('admin/edit_modal.php', ['task' => $task]) ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
bundle\View::render('layouts/default/footer.php');
?>