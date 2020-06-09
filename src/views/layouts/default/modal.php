<?php
    if (!isset($title)) {
        $title = 'Title';
    }
?>

<div class="modal fade" id="<?php echo $ident; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $title; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body-error">
                    <div class="alert fade" role="alert">
                        <span class="modal-error"></span>
                    </div>
                </div>
                <form method="post" id="form-<?php echo $ident; ?>" action="<?php echo $actionUrl; ?>">
                    <div class="form-group">
                        <label for="name-<?php echo $ident; ?>">Name</label>
                        <input name="author" type="text" class="form-control" id="name-<?php echo $ident; ?>" placeholder="Miroslaw">
                    </div>
                    <div class="form-group">
                        <label for="email-<?php echo $ident; ?>">Email Address</label>
                        <input name="email" type="email" class="form-control" id="email-<?php echo $ident; ?>" placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label for="text-<?php echo $ident; ?>">Text</label>
                        <textarea name="text" class="form-control" id="text-<?php echo $ident; ?>" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="App.addTask()" form="form-<?php echo $ident; ?>" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>