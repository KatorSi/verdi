<div class="col-sm-12" id="operasPage">
    <div>
        <div class="form-group d-flex justify-content-between">
            <h4>Оперы</h4>
            <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#newOperaModal">Добавить</button>
        </div>
        <div class="dropdown-divider"></div>
        <div>
            <?php if(!empty($data)) : ?>
            <div class="list-group">
                <?php foreach($data as $opera) : ?>
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-opera="<?=$opera['id']?>">
                    <a href="<?= \Config::$host . 'dashboard/opera/' . $opera['id'] ?>"><?= $opera['title']?></a>
                    <span class="badge badge-danger badge-pill badge-button" onclick="deleteOpera(<?=$opera['id']?>)">
							<i class="fa fa-remove" aria-hidden="true"></i>
						</span>
                </div>
                <?php endforeach;?>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
<div class="modal fade" id="newOperaModal" tabindex="-1" role="dialog" aria-labelledby="newOperaModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newOperaModalTitle">Новая опера</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"><?php include_once('create.tpl');?></div>
            <div class="modal-footer">
                <button class="btn btn-outline-success" onclick="createOpera()">Сохранить</button>
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
