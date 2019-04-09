<?php /** @var array $data */?>
<?php setlocale( LC_TIME, 'ru_RU', 'russian' ); ?>
<div class="content-header">
    <div class="content-header-top-menu poster-title">
        <span class="title title-big">Афиша</span>
        <div class="btn-back" data-backfunc="customBackFunc"><a href="<?php echo \Config::$host . (isset($data['back']) ? $data['back'] : '') ?>"> &lt;&lt;&nbsp;назад</a></div>
    </div>
    <div class="row sub-top-menu">
            <div class="col-lg-6 sub-top-menu-item">
            <span>Композитор</span>
            <select name="composer" id="composer" class="poster_select">
                <?php foreach ($data['composers'] as $composer) : ?>
                <option value="<?= $composer['id'] ?>"><?= $composer['firstName'].' '.$composer['lastName'] ?></option>
                <?php endforeach; ?>
            </select>
            </div>
        <div class="col-lg-6 sub-top-menu-item">
            <span>Произведения</span>
            <select name="composer" id="composer" class="poster_select">
                <?php// foreach ($data['composers'] as $composer) : ?>
                <option value="<?//= $composer['id'] ?>"><?= 'Тестовое произведение';//= $composer['firstName'].' '.$composer['lastName'] ?></option>
                <?php// endforeach; ?>
            </select>
        </div>
    </div>
</div>
<div class="content-body">
    <div id="target">
        <table class="table table-default main-table">
            <thead>
            <tr>
                <td class="date" data-sort="asc">Дата</td>
                <td class="author">Автор</td>
                <td>Название произведения</td>
                <td class="theater">Театр</td>
            </tr>
            </thead>
        </table>
    </div>
    <div class="table-fixer">
        <table class="table table-default table-data">
            <tbody>
                <?php foreach($data['events'] as $month => $events) : ?>
                    <?php foreach($events as $key => $event) : ?>
                    <tr <?= ($key == 0) ? 'class="border-top-bold"' : '' ?>>
                        <td style="width: 150px;"><?= ($key == 0) ? $month : ''?></td>
                    <?php $date = new DateTime($event['date']); ?>
                        <td class="text-right" style="width: 70px;"><?= $date->format('j'); ?></td>
                        <td class="text-center" style="width: 63px;"><?= Helpers\Transformers\DateTransformer::getCyrillicDay($date->format('D')); ?></td>
                        <td><?= $event['author']; ?></td>
                        <td><?= $event['title']; ?></td>
                        <td><?= $event['theater']; ?></td>
                    <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<?php //var_dump($data); ?>