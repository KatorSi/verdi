<div class="col-sm-12" id="posterPage">
    <div>
        <div class="form-group d-flex justify-content-between">
            <h4>Афиша</h4>
            <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#newPosterModal">Добавить</button>
        </div>
        <div class="dropdown-divider"></div>
        <div>
            <?php if(!empty($data)) : ?>
            <? //var_dump($data); ?>
            <div class="list-group">
                <?php foreach($data as $poster) : ?>
                <a href="<?= \Config::$host . 'dashboard/poster/' . $poster['id'] ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pointer" data-poster="<?=$poster['id']?>">
                    <div class="col">
                        <p><?= $poster['author']; ?></p>
                    </div>
                    <div class="col">
                        <label>Дата</label>
                        <p><?= $poster['date']; ?></p>
                    </div>
                    <div class="col">
                        <label>Название произведения</label>
                        <p><?= $poster['title']; ?></p>
                    </div>
                    <div class="col">
                        <label>Театр</label>
                        <p><?= \Pages\Poster\Model::$THEATER[$poster['theater']]; ?></p>
                    </div>
                </a>
                <?php endforeach;?>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
<div class="modal fade" id="newPosterModal" tabindex="-1" role="dialog" aria-labelledby="newPosterModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPosterModalTitle">Новая запись</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"><?php include_once('create.tpl');?></div>
            <div class="modal-footer">
                <button class="btn btn-outline-success" onclick="createPoster()">Сохранить</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalTitle">Предупреждение</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body response-message">Элемент не сохранен</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
