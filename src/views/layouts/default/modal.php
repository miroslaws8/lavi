<div class="modal fade" id="modal<?php echo $session['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order <?php echo $session['caption']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/order/add" method="post" id="order-<?php echo $session['id']; ?>">
                    <input type="hidden" name="id_film" value="<?php echo $idFilm; ?>">
                    <input id="idSession-<?php echo $session['id']; ?>" type="hidden" name="id_session" value="<?php echo $session['id']; ?>">

                    <div class="form-group">
                        <label for="hall-row-<?php echo $session['id'];?>">Row</label>
                        <select required name="row" class="form-control" id="hall-row-<?php echo $session['id'];?>">
                            <?php for ($i = 1; $i <= 5; $i++) {
                                echo '<option>'.$i.'</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="place-<?php echo $session['id'];?>">A place</label>
                        <select required name="place" class="form-control" id="place-<?php echo $session['id'];?>">
                            <?php
                                for ($i = 1; $i <= 10; $i++) {
                                    echo '<option>'.$i.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input required name="email" type="email" class="form-control" id="email" placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label for="tel">Telephone</label>
                        <input required name="tel" type="tel" class="form-control" id="tel" placeholder="+380502474344">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="order-<?php echo $session['id']; ?>" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function getPlaces(idSession, idRow) {
        let body = {
            row: idRow,
            idFilm: '<?php echo $idFilm; ?>',
            idSession: idSession,
        };

        let response = await fetch('/sessions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(body)
        });

        let result = await response.json();

        let placeBlock = jQuery('#place-' + idSession);
        placeBlock.html('');

        for (let place in result) {
            placeBlock.append('<option>' + place + '</option>');
        }
    }

    jQuery('#hall-row-<?php echo $session['id']; ?>').change(function (ev) {
        let row = jQuery('#hall-row-<?php echo $session['id']; ?>').val();
        let idSession = '<?php echo $session['id']; ?>';
        getPlaces(idSession, row);
    });
</script>