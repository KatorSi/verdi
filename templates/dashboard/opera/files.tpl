<?php if(!empty($data)) : ?>
            <ul class="list-group">
                <li data-id="<?= $data['inserted_id'] ?>" class="list-group-item">
                    <div class="fl_right"> <span class="badge badge-danger badge-pill badge-button" onclick="removeFile(<?= $data['inserted_id'] ?>,'<?= $data['name'] ?>','<?= $data['category']?>' )">
                                        <i class="fa fa-remove" aria-hidden="true"></i>
                                    </span></div>
                    <?= $data['name'] ?><br>
                    <span class="badge_custom"> Cтатус загрузки - <?= $data['status'] ?></span>
                </li>
<?php endif;?>