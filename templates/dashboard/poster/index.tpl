<div class="col-sm-12" id="posterPage">
    <div>
        <div class="form-group d-flex justify-content-between">
            <h4>Афиша</h4>
            <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#newPosterModal">Добавить</button>
        </div>
        <div class="dropdown-divider"></div>
        <div>
            <?php if(!empty($data)) : ?>
            <div class="list-group">
                <?php foreach($data as $poster) : ?>
                <?php
                    $lastId = $_SESSION['lastId'];
                    $class = !empty($poster['ticket_link']) ? '' : 'bg-gray';
                    $class = ($poster['id'] == $lastId) ? 'bg-lightyellow' : $class;
                ?>
                <div class="list-group-item list-group-item-action d-flex align-items-center <?= $class ?>" data-poster="<?=$poster['id']?>">
                    <a href="<?= \Config::$host . 'dashboard/poster/' . $poster['id'] ?>" class="d-flex justify-content-between align-items-center pointer text-center">
                        <div class="col">
                            <p><?= (new \DateTime($poster['date']))->format('d.m.Y'); ?></p>
                        </div>
                        <div class="col">
                            <p><?= $poster['title']; ?></p>
                        </div>
                        <div class="col">
                            <p><?= \Pages\Poster\Model::$THEATER[$poster['theater']]; ?></p>
                        </div>
                        <div class="col">
                            <p><?= $poster['author']; ?></p>
                        </div>
                    </a>
                    <div class="min-col text-center">
                        <span class="badge badge-danger badge-pill badge-button" onclick="deletePoster(<?= $poster['id']; ?>)">
							<i class="fa fa-remove" aria-hidden="true"></i>
						</span>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
            <?php endif;?>
        </div>
        <div class="pt-3">
            <button type="button" class="btn btn-outline-info float-right" data-toggle="modal" data-target="#newPosterModal">Добавить</button>
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
