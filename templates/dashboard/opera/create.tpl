<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h4>Создать оперу</h4>
        </div>
        <div class="card-body">
            <p>Основная информация</p>
            <form class="opera-form">
                <div class="form-group form-row">
                    <div class="col">
                        <label>Название</label>
                        <div>
                            <input type="text" name="title" placeholder="Название" class="form-control"
                                   autocomplete="off">
                            <input type="hidden" name="id" placeholder="Опера" class="form-control" autocomplete="off">
                            <small class="form-text"></small>
                        </div>
                    </div>
                    <div class="col">
                        <label>Композитор</label>
                        <div class="has-input-autocomplete">
                            <input type="text" name="composer" placeholder="Композитор" class="form-control"
                                   autocomplete="off" data-autocomplete="composer">
                            <input type="hidden" name="composer_id" placeholder="Композитор" class="form-control"
                                   autocomplete="off">
                            <small class="form-text"></small>
                            <div class="dropdown-menu" data-autocompleteList="composer"></div>
                        </div>
                    </div>
                </div>
<!--                <div class="form-group form-row">-->
<!--                    <div class="col">-->
<!--                        <label>По произведению</label>-->
<!--                        <div>-->
<!--                            <input type="text" name="basedOn" placeholder="По произведению" class="form-control"-->
<!--                                   autocomplete="off">-->
<!--                            <small class="form-text"></small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col">-->
<!--                        <label>Автор либретто</label>-->
<!--                        <div>-->
<!--                            <input type="text" name="librettist" placeholder="Автор либретто" class="form-control"-->
<!--                                   autocomplete="off">-->
<!--                            <small class="form-text"></small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="form-group form-row">-->
<!--                    <div class="col">-->
<!--                        <label>Город первой постановки</label>-->
<!--                        <div>-->
<!--                            <input type="text" name="premierePlace" placeholder="Город первой постановки"-->
<!--                                   class="form-control" autocomplete="off">-->
<!--                            <small class="form-text"></small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col">-->
<!--                        <label>Дата премьеры</label>-->
<!--                        <div>-->
<!--                            <input type="text" name="premiereYear" placeholder="дата премьеры" class="date-year form-control" autocomplete="off">-->
<!--                            <small class="form-text"></small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="form-group form-row">-->
<!--                    <div class="col">-->
<!--                        <div>-->
<!--                            <label>Партитура</label>-->
<!--                        </div>-->
<!--                        <div class="full-width-label">-->
<!--                            <div class="form-check form-check-inline custom-radio-check">-->
<!--                                <label class="form-check-label" for="partituraExistsRadio1">-->
<!--                                    <input type="radio" name="partituraExists" value="yes" id="partituraExistsRadio1"-->
<!--                                           autocomplete="off" checked>-->
<!--                                    <span>Есть</span>-->
<!--                                </label>-->
<!--                            </div>-->
<!--                            <div class="form-check form-check-inline custom-radio-check">-->
<!--                                <label class="form-check-label" for="partituraExistsRadio2">-->
<!--                                    <input type="radio" name="partituraExists" value="no" id="partituraExistsRadio2"-->
<!--                                           autocomplete="off">-->
<!--                                    <span>Нет</span>-->
<!--                                </label>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col">-->
<!--                        <label>Длительность</label>-->
<!--                        <div>-->
<!--                            <input type="time" step="1" name="duration" placeholder="Длительность" class="form-control"-->
<!--                                   autocomplete="off">-->
<!--                            <small class="form-text"></small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </form>
        </div>
    </div>
</div>