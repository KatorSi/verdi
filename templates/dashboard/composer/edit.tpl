<div class="col-sm-12" id="editPage">
    <div class="card composer">
        <div class="card-header d-flex align-items-center">
            <h4>Редактировать композитора</h4>
        </div>
        <div class="card-body">
            <form class="edit-composer-form">
                <div class="form-group form-row">
                    <div class="col">
                        <label>Имя композитора</label>
                        <div>
                            <input type="text" name="firstName" value="<?= $data['firstName'] ?>" placeholder="Имя композитора" class="form-control" autocomplete="off">
                            <input type="hidden" name="id" value="<?= $data['id']; ?>" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                    <div class="col">
                        <label>Фамилия композитора</label>
                        <div>
                            <input type="text" name="lastName" value="<?= $data['lastName'] ?>" placeholder="Фамилия композитора" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col">
                        <label>Дата рождения</label>
                        <div>
                            <input type="text" name="birthDate" value="<?= $data['birthDate'] !== '00.00.0000' ?
                                $data['birthDate'] : '' ?>" class="date form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                    <div class="col">
                        <label>Дата смерти</label>
                        <div>
                            <input type="text" name="deathDate" value="<?= $data['deathDate'] !== '00.00.0000' ?
                                $data['deathDate'] : '' ?>" class="date form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col">
                        <label>Страна</label>
                        <div class="has-input-autocomplete">
                            <input type="text" name="country" value="<?= $data['country'] ?>" placeholder="Страна" class="form-control" autocomplete="off" data-autocomplete="country">
                            <input type="hidden" name="country_id" value="<?= $data['country_id'] ?>" placeholder="Страна" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                            <div class="dropdown-menu" data-autocompleteList="country"></div>
                        </div>
                    </div>
                    <div class="col">
                        <label>Город рождения</label>
                        <input type="text" name="city" value="<?= $data['city'] ?>" placeholder="Город рождения" class="form-control" autocomplete="off" >
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col">
                        <label>Муз. направление</label>
                        <div class="has-input-autocomplete">
                            <input type="text" name="genre" value="<?= $data['genre'] ?>" placeholder="Муз. направление" class="form-control" autocomplete="off" data-autocomplete="genre">
                            <input type="hidden" name="genre_id" value="<?= $data['genre_id'] ?>" placeholder="Муз. направление" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                            <div class="dropdown-menu" data-autocompleteList="genre"></div>
                        </div>
                    </div>
                    <div class="col">
                        <label>Основные направления</label>
                        <input type="text" name="sector" placeholder="Основные направления" value="<?= $data['sector'] ?>" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label>Биография</label>
                    <textarea class="form-control" name="bio" placeholder="Биография" rows="5"><?= $data['bio']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Факты</label>
                    <textarea class="form-control" name="facts" placeholder="Факты" rows="5"><?= $data['facts']; ?></textarea>
                </div>
            </form>
        </div>
        <div class="card-footer">

            <button class="btn btn-outline-success pull-right" onclick="updateComposer()">Сохранить</button>

        </div>

        <div class="card-body block-composer-films pb-0">
            <h6 class="m-0 p-0 mb-1">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target=".composer-films" aria-expanded="true" aria-controls=".composer-films">Список фильмов&nbsp;<i class="fa"></i>
                </button>
                <button type="button" class="badge badge-button badge-primary badge-pill add-composer-film upload">
                    <i class="fa fa-plus"></i></button>
            </h6>
            <form class="composer-films collapse" aria-labelledby="head-composer-files" data-parent=".block-composer-films">
                <input type="file" name="films" class="form-control" multiple="">
                <table class="table table-default table-bordered list-composer-films">
                    <thead>
                    <tr>
                        <th class="col-2">Название</th>
                        <th class="col-1">Год</th>
                        <th class="col-2">Режиссер</th>
                        <th class="col-2">Актеры</th>
                        <th class="col-5">Короткое описание</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($data['films'])): foreach ($data['films'] as $film): ?>
                        <tr id="<?php echo $film['id']; ?>" data-href="<?php echo $film['filePath']; ?>">
                            <td class="col-2">
                                <input class="form-control" autocomplete="off" type="text" name="films[<?php echo $film['id']; ?>][title]" value="<?php echo $film['title']; ?>">
                            </td>
                            <td class="col-1">
                                <input class="form-control date-year" autocomplete="off" type="text" name="films[<?php echo $film['id']; ?>][year]" value="">
                            </td>
                            <td class="col-2">
                                <input class="form-control" autocomplete="off" type="text" name="films[<?php echo $film['id']; ?>][creator]" value="">
                            </td>
                            <td class="col-2">
                                <input class="form-control" autocomplete="off" type="text" name="films[<?php echo $film['id']; ?>][actors]" value="">
                            </td>
                            <td class="col-5 pr-5">
                                <textarea class="form-control non-cke" name="films[<?php echo $film['id']; ?>][description]"></textarea><span class="remove badge badge-danger badge-pill badge-button"><i class="fa fa-remove" aria-hidden="true"></i></span>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-outline-success pull-right">Сохранить</button>
            </form>
        </div>

        <div class="dropdown-divider"></div>

        <div class="card-body block-composer-books pb-0">
            <h6 class="m-0 p-0 mb-1">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target=".composer-books" aria-expanded="true" aria-controls=".composer-books">Список книг&nbsp;<i class="fa"></i>
                </button>
                <button type="button" class="badge badge-button badge-primary badge-pill add-composer-book upload">
                    <i class="fa fa-plus"></i></button>
            </h6>
            <div class="composer-books collapse" aria-labelledby="head-composer-books" data-parent=".block-composer-books">
                <input type="file" name="books" class="form-control" multiple="">
                <table class="table table-bordered table-default list-composer-books">
                    <thead>
                    <tr class="d-flex">
                        <th class="col-1">№</th>
                        <th class="col-1">Название</th>
                        <th class="col-1">Год</th>
                        <th class="col-1">Автор</th>
                        <th class="col-8">Короткое описание</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="editComposerModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editComposerModalTitle">Предупреждение</h5>
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