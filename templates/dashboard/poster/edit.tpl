<div class="col-sm-12">
    <div class="card poster">
        <div class="card-header d-flex align-items-center">
            <h4>Редактировать запись</h4>
        </div>
        <div class="card-body">
            <?php //var_dump($data); ?>
            <p>Основная информация</p>
            <form class="poster-form">
                <div class="form-group form-row">
                    <div class="col">
                        <label>Название</label>
                        <div>
                            <input type="text" name="title" value="<?= $data['poster']['title'] ?>" placeholder="Название" class="form-control" autocomplete="off">
                            <input type="hidden" name="id" value="<?= $data['poster']['id'] ?>" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                    <div class="col">
                        <label>Композитор</label>
                        <div class="has-input-autocomplete">
                            <input type="text" name="composer" value="<?= $data['poster']['composer'] ?>" placeholder="Композитор" class="form-control" autocomplete="off" data-autocomplete="composer" disabled>
                            <input type="hidden" name="composer_id" placeholder="Композитор" value="<?= $data['poster']['composer_id']; ?>" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                            <div class="dropdown-menu" data-autocompleteList="composer"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col">
                        <label>Дата</label>
                        <div>
                            <input type="text" name="date" placeholder="Дата" value="<?= $data['poster']['date'] ?>" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                    <div class="col">
                        <label>Театр</label>
                        <div>
                            <input type="text" name="theater" placeholder="Театр" value="<?= \Pages\Poster\Model::$THEATER[$data['poster']['theater']]; ?>" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                    <div class="col">
                        <label>Ссылка на билет</label>
                        <div>
                            <input type="text" name="ticket_link" placeholder="Ссылка на билет" value="<?= $data['poster']['ticket_link']; ?>" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button class="btn btn-outline-success pull-right" onclick="updatePoster()">Сохранить изменения</button>
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
<div id="loader" class="modal_loader"></div>