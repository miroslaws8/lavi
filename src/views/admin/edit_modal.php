<div class="modal fade" id="edit-<?php echo $film['id']; ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Film <?php echo $film['caption']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="films/<?php echo $film['id']; ?>/edit" id="addFilm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="caption">Caption</label>
                        <input name="caption" value="<?php echo $film['caption']; ?>" type="text" class="form-control" id="caption" placeholder="Caption">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3"><?php echo $film['description']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="poster">Poster</label>
                        <input name="poster" type="file" class="form-control-file" id="poster">
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