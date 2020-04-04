<nav class="navigation">
    <ul class="pagination pagination-sm">
        <?php for ($i = 1; $i <= $total; $i++) { ?>
            <?php if ($current == $i) { ?>
                <li class="page-item active" aria-current="page">
                    <span class="page-link">
                        <?php echo $i; ?>
                    </span>
                </li>
            <?php } else { ?>
                <li class="page-item"><a class="page-link" href="<?php echo $instance->getUrl($i); ?>"><?php echo $i; ?></a></li>
            <?php } ?>
        <?php } ?>
    </ul>
</nav>