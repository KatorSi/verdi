<?php /** @var array $data */?>
<div class="content-header">
    <div class="content-header-top-menu poster-title">
        <span class="title title-big">Афиша</span>
        <div class="btn-back" data-backfunc="customBackFunc"><a href="<?php echo \Config::$host . (isset($data['back']) ? $data['back'] : '') ?>"> &lt;&lt;&nbsp;назад</a></div>
    </div>
    <div class="row sub-top-menu">
        <div class="col-lg-6 sub-top-menu-item">
            <span>Композитор</span>
            <select name="composer" id="composer" class="poster_select">
                <option value=""></option>
                <?php foreach ($data['mozartverdi'] as $composer) : ?>
                <option value="<?= $composer['id'] ?>"><?= $composer['firstName'].' '.$composer['lastName'] ?></option>
                <?php endforeach; ?>
            </select>
            </div>
        <div class="col-lg-6 sub-top-menu-item">
            <span>Произведения</span>
            <select name="composer" id="composer" class="poster_select">
                <?php// foreach ($data['composers'] as $composer) : ?>
                <option value=""></option>
                <?php// endforeach; ?>
            </select>
        </div>
    </div>
</div>
<div class="content-body poster">
    <div id="target">
        <table class="table table-default main-table">
            <thead>
            <tr>
                <td style="width:80px;" class="date">Дата</td>
                <?php foreach(\Pages\Poster\Model::$THEATER as $key => $theater) : ?>
                <td class="align-middle"><?= $theater; ?></td>
                <?php endforeach; ?>
            </tr>
            </thead>
        </table>
    </div>
    <div class="table-fixer">
        <table class="table table-default table-border-none">
            <tbody>
            <tr>
                <td colspan="7"><b>Сегодня - <?= \Helpers\Transformers\DateTransformer::getToday(); ?></b></td>
            </tr>
            </tbody>
        </table>
        <table class="table table-default table-data">
            <tbody>
                <?php foreach($data['events'] as $key => $date): ?>
                <?php foreach($date as $eventKey => $event): ?>
                <tr>
                    <td style="width:80px;"><?= $event['date']; ?></td>
                    <?php foreach(\Pages\Poster\Model::$THEATER as $theater => $translate): ?>
                    <td><a class="clear_link" href="//<?= $event['ticket_link']; ?>"><?= $event[$theater]; ?></a></td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>