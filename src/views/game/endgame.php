<?php
bundle\View::render('layouts/default/header.php');
?>
    <div class="position-center" style="width: fit-content;height: fit-content;">
        <h1 style="color: #fff;">Тест окончен</h1>
        <div class="results">
            <table class="table table-bordered m-table">
                <thead>
                <tr>
                    <th scope="col" rowspan="2">Правильных ответов</th>
                    <th scope="col" colspan="4">Вышел за пределы</th>
                </tr>
                <tr>
                    <th>Лево</th>
                    <th>Право</th>
                    <th>Верх</th>
                    <th>Низ</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $data['success']; ?></td>
                    <td><?php echo $data['outside']['left']; ?></td>
                    <td><?php echo $data['outside']['right']; ?></td>
                    <td><?php echo $data['outside']['top']; ?></td>
                    <td><?php echo $data['outside']['bottom']; ?></td>
                </tr>
                </tbody>
            </table>
            <div>
            </div>
        </div>
        <a href="/game" style="margin-top: 20px"
           class="btn btn-info">Пройти еще раз</a>
        <a href="/settings" style="margin-top: 20px"
           class="btn btn-danger">Выход</a>
    </div>

<?php
bundle\View::render('layouts/default/footer.php');
?>