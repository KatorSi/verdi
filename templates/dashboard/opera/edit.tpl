<div class="col-sm-12">
    <div class="card opera">
        <div class="card-header d-flex align-items-center">
            <h4>Редактировать оперу</h4>
        </div>
        <div class="card-body">
            <p>Основная информация</p>
            <form class="opera-form">
                <div class="form-group form-row">
                    <div class="col">
                        <label>Название</label>
                        <div>
                            <input type="text" name="title" value="<?= $data['opera']['title'] ?>" placeholder="Название" class="form-control" autocomplete="off">
                            <input type="hidden" name="id" value="<?= $data['opera']['id'] ?>" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                    <div class="col">
                        <label>Композитор</label>
                        <div class="has-input-autocomplete">
                            <input type="text" name="composer" value="<?= $data['opera']['composer'] ?>" placeholder="Композитор" class="form-control" autocomplete="off" data-autocomplete="composer" disabled>
                            <input type="hidden" name="composer_id" placeholder="Композитор" value="<?php echo $data['opera']['composer_id']; ?>" class="form-control" autocomplete="off">

                            <small class="form-text"></small>
                            <div class="dropdown-menu" data-autocompleteList="composer"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col">
                        <label>По произведению</label>
                        <div>
                            <input type="text" name="basedOn" placeholder="По произведению" value="<?= $data['opera']['basedOn'] ?>" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                    <div class="col">
                        <label>Автор либретто</label>
                        <div class="has-input-autocomplete">
                            <input type="text" name="librettist" value="<?= $data['opera']['librettist'] ?>" placeholder="Композитор" class="form-control" autocomplete="off" data-autocomplete="librettist" disabled>
                            <input type="hidden" name="librettist_id" placeholder="Композитор" value="<?php echo $data['opera']['librettist_id']; ?>" class="form-control" autocomplete="off">

                            <small class="form-text"></small>
                            <div class="dropdown-menu" data-autocompleteList="librettist"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col">
                        <label>Город первой постановки</label>
                        <div>
                            <input type="text" name="premierePlace" value="<?= $data['opera']['premierePlace'] ?>" placeholder="Город первой постановки" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                    <div class="col">
                        <label>Дата премьеры</label>
                        <div>
                            <input type="text" name="premiereYear" value="<?= $data['opera']['premiereDate'] ?>" placeholder="Дата премьеры" class="date-year form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col">
                        <div>
                            <label>Партитура</label>
                        </div>
                        <div class="full-width-label">
                            <div class="form-check form-check-inline custom-radio-check">
                                <label class="form-check-label" for="partituraExistsRadio1">
                                    <input type="radio" name="partituraExists" value="yes" id="partituraExistsRadio1" autocomplete="off" checked>
                                    <span>Есть</span> </label>
                            </div>
                            <div class="form-check form-check-inline custom-radio-check">
                                <label class="form-check-label" for="partituraExistsRadio2">
                                    <input type="radio" name="partituraExists" value="no" id="partituraExistsRadio2" autocomplete="off">
                                    <span>Нет</span> </label>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <label>Длительность</label>
                        <div>
                            <input type="time" step="1" name="duration" placeholder="Длительность" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>История создания</label>
                    <textarea class="form-control" name="history"  rows="5"><?= $data['opera']['history']; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Краткое описание</label>
                    <textarea class="form-control" name="description" rows="5"><?= $data['opera']['description']; ?></textarea>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button class="btn btn-outline-success pull-right" onclick="updateOpera()">Сохранить изменения</button>
        </div>

        <div class="card-body block-opera-files pb-0">
            <h6 class="m-0 p-0 mb-1">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target=".opera-files" aria-expanded="true" aria-controls=".opera-files">Список файлов <i class="fa"></i></button>
            </h6>
            <div class="opera-files collapse" aria-labelledby="head-opera-files" data-parent=".block-opera-files">

                <?php foreach ([
                                   'video' => 'Видео',
                                   'audio' => 'Аудио',
                                   'score' => 'Партитура'
                               ] as $typeFile => $titleCard): ?>
                    <div class="card">
                        <input type="file" name="<?php echo $typeFile; ?>" class="form-control" multiple="">
                        <div class="card-header"><?php echo $titleCard; ?>
                            <button type="button" data-type="<?php echo $typeFile; ?>" class="upload badge badge-button badge-primary badge-pill">
                                <i class="fa fa-plus"></i></button>
                        </div>
                        <div class="list-group list-group-flush list-<?php echo $typeFile; ?>">
                            <?php if (sizeof($data[$typeFile]) > 0): foreach ($data[$typeFile] as $file): ?>
                                <a href="#" id="<?php echo $file['id']; ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-href="<?php echo \Config::$host . $file['path'] . $file['name']; ?>">
                                    <span class="file-title w-50"><?php echo $file['title']; ?></span>
                                    <span class="remove badge badge-danger badge-pill badge-button"><i class="fa fa-remove" aria-hidden="true"></i></span>
                                </a>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>
        <div class="dropdown-divider"></div>
        <div class="card-body block-opera-productions pt-0">
            <h6 class="m-0 p-0 mt-1">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target=".opera-productions" aria-expanded="true" aria-controls=".opera-productions">Список постановок <i class="fa"></i></button>
                <button type="button" class="badge badge-button badge-primary badge-pill add-opera-production"><i class="fa fa-plus"></i>
                </button>
            </h6>
            <div class="opera-productions collapse" data-parent=".block-opera-productions">
                <table class="table table-bordered table-default list-opera-productions">
                    <thead>
                    <tr class="d-flex">
                        <th class="col-1">Год</th>
                        <th class="col-1">Театр/площадка</th>
                        <th class="col-1">Дирижер</th>
                        <th class="col-1">Сонет</th>
                        <th class="col-8">Время</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalTitle"
        aria-hidden="true">
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