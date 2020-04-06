<div class="modal fade" id="edit-<?php echo $task['id']; ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="tasks/<?php echo $task['id']; ?>/edit" id="editTask-<?php echo $task['id']; ?>">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input name="author" value="<?php echo $task['author']; ?>" type="text" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="name">E-mail</label>
                        <input name="email" value="<?php echo $task['email']; ?>" type="text" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" id="status">
                            <option value="new">New</option>
                            <option value="pending">Pending</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Text</label>
                        <textarea name="text" class="form-control" id="text" rows="3"><?php echo $task['text']; ?></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button form="editTask-<?php echo $task['id']; ?>" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>