<?php
bundle\View::render('layouts/default/header.php');
?>
    <div class="endgame-container">
        <h1 style="color: #fff;">Тест окончен</h1>
        <div class="results">
            <table class="table table-bordered m-table">
                <thead>
                <tr>
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
                    <td><?php echo $data['outside']['left']; ?></td>
                    <td><?php echo $data['outside']['right']; ?></td>
                    <td><?php echo $data['outside']['top']; ?></td>
                    <td><?php echo $data['outside']['bottom']; ?></td>
                </tr>
                </tbody>
            </table>
            <div class="">
                <h2 style="color: #fff;">Ваши ответы</h2>
                <div class="results-filters">
                    <small style="color: #fff;">Всего ответов: <?php echo count($data['success']); ?></small>
                    <?php
                    $offset = $data['settings']['groupBy'];
                    $blocks = ceil(count($data['success']) / $offset);
                    for ($i = 1; $i <= $blocks; $i++) :
                        ?>
                        <div class="block-result">
                            <div style="color: #fff;padding-bottom: 10px;border-bottom: 1px solid #fff;">
                                <small>Группа <?php echo ($i * $offset - $offset).'-'.$i * $offset;?></small>
                            </div>
                            <small class="block-result-success">
                                <?php
                                $success = 0;
                                $fail = 0;

                                foreach ($data['success'] as $key => $result) {
                                    if ($key == $i * $offset) {
                                        break;
                                    }

                                    if ($result == 'true') {
                                        $success++;
                                    } else {
                                        $fail++;
                                    }

                                    unset($data['success'][$key]);
                                }

                                echo 'Правильно: '.$success.' | ';
                                ?>
                            </small>
                            <small class="block-result-danger">
                                <?php echo 'Неверно: '.$fail; ?>
                            </small>
                        </div>
                    <?php endfor; ?>
                </div>
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