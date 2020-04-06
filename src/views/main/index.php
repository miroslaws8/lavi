<?php
    bundle\View::render('layouts/default/header.php');
    bundle\View::render('layouts/header.php');
?>
<div class="mid">
    <div class="my-row">
        <h3>All Tasks</h3>
        <div class="actions">
            <div class="btn-group">
                <?php
                    $filters = ['author' => 'Имя пользователя', 'email' => 'E-mail', 'status' => 'Статус'];
                    foreach ($filters as $name => $caption) {
                ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $caption; ?>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="?sorting=asc&field=<?php echo $name; ?>">По возврастанию</a>
                                <a class="dropdown-item" href="?sorting=desc&field=<?php echo $name; ?>">По убыванию</a>
                            </div>
                        </div>
                <?php } ?>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTask">Add Task</button>
            </div>
        </div>
    </div>
    <hr>
    <div class="list">
        <?php if (empty($tasks)) { ?>
            <div class="empty">
                <span>No one added tasks.</span>
            </div>
        <?php } else { ?>
            <?php foreach ($tasks as $key => $task) { ?>
                <div class="list-item">
                    <div class="list-item-head">
                        <span class="badge badge-success"><?php echo ucfirst($task['status']); ?></span>
                        <?php if ($task['edited']) { ?>
                            <span class="badge badge-info">Отредактировано администратором</span>
                        <?php } ?>
                    </div>
                    <small>Имя пользователя: <b><?php echo $task['author']; ?></b></small>
                    <small>E-mail: <b><?php echo $task['email']; ?></b></small>
                    <small>Текст задачи: <?php echo $task['text']; ?></small>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <?php
        $paginator = new \utils\Paginator();
        $paginator->render($currentPage, $cntPage);
    ?>
</div>

<?php
    bundle\View::render('layouts/default/modal.php', [
        'title'     => 'Add Task',
        'ident'     => 'addTask',
        'actionUrl' => 'tasks/add'
    ]);

    bundle\View::render('layouts/default/footer.php');
?>