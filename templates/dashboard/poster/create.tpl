<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h4>Новая запись афиши</h4>
        </div>
        <div class="card-body">
            <p>Основная информация</p>
            <form class="poster-form">
                <div class="form-group form-row">
                    <div class="col">
                        <label>Название</label>
                        <div>
                            <input type="text" name="title" placeholder="Название" class="form-control" autocomplete="off">
                            <input type="hidden" name="id" placeholder="Poster" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                    <div class="col">
                        <label>Композитор</label>
                        <div class="has-input-autocomplete">
                            <input type="text" name="composer" placeholder="Композитор" class="form-control" autocomplete="off" data-autocomplete="composer">
                            <input type="hidden" name="composer_id" placeholder="Композитор" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                            <div class="dropdown-menu" data-autocompleteList="composer"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col">
                        <label>Театр</label>
                        <div>
                            <select class="form-control" name="theater">
                                <?php foreach(\Pages\Poster\Model::$THEATER as $code => $theater) : ?>
                                <option value="<?= $code; ?>"><?= $theater; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text"></small>
                        </div>
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col">
                        <label>Дата</label>
                        <div>
                            <input type="date" name="date" placeholder="Дата" value="" class="form-control" autocomplete="off">
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
    </div>
</div>