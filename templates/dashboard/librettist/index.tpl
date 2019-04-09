<div class="col-sm-12" id="librettistPage">
	<div class="form-group d-flex justify-content-between">
		<h4>Либреттисты</h4>
		<button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#newlibrettistModal">Добавить</button>
	</div>
	<div class="dropdown-divider"></div>
	<div>
		<?php if(!empty($data)) : ?>
			<div class="list-group">
				<?php foreach($data as $librettist) : ?>
					<div class="list-group-item d-flex justify-content-between align-items-center" data-librettist="<?= $librettist['id']?>">
						<a href="javascript:void(0);"><?= $librettist['name']?></a>
						<span class="badge badge-danger badge-pill badge-button" onclick="deleteItem(<?= $librettist['id']?>, 'librettist')">
							<i class="fa fa-remove" aria-hidden="true"></i>
						</span>
					</div>
				<?php endforeach;?>
			</div>
		<?php endif;?>
	</div>
</div>
<div class="modal fade" id="newlibrettistModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalTitle">Добавить либреттиста</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body"><?php include_once('new.tpl');?></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-outline-success" onclick="createItem('librettist')">Сохранить</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="alertModal2" tabindex="-1" role="dialog" aria-labelledby="newComposerModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newComposerModalTitle">Предупреждение</h5>
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