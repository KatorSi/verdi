<?php /** @var array $data */?>
<div class="content-header">
    <div class="content-header-top-menu poster-title">
        <span class="title title-big">Афиша</span>
        <div class="btn-back" data-backfunc="customBackFunc"><a href="<?php echo \Config::$host . (isset($data['back']) ? $data['back'] : '') ?>"> &lt;&lt;&nbsp;назад</a></div>
    </div>
    <div class="row sub-top-menu">
        <!--<div class="col-lg-6 sub-top-menu-item">
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
                <option value=""></option>
                <?php// endforeach; ?>
            </select>
        </div>-->
    </div>
</div>
<div class="content-body poster">
    <div id="target">
        <table class="table table-default main-table">
            <thead>
            <tr>
                <td style="width:180px;" class="date">Дата</td>
                <td style="width: 200px;" class="author">Автор</td>
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
                    <?php $firstKey = array_keys($events)[0]; ?>
                    <?php foreach($events as $event) : ?>
                        <tr style="width:180px;" <?= ($firstKey == $event['date']) ? 'class="border-top-bold"' : '' ?>>
                            <td style="width: 78px;"><?= ($firstKey == $event['date']) ? $month : ''?></td>
                            <?php $date = new DateTime($event['date']); ?>
                            <td class="text-right vert-align-middle" style="width: 51px;"><?= $date->format('j'); ?></td>
                            <td class="text-center vert-align-middle" style="width: 51px;"><?= Helpers\Transformers\DateTransformer::getCyrillicDay($date->format('D')); ?></td>
                            <td style="width: 200px;" class="vert-align-middle"><?= is_array($event['author']) ? array_reduce($event['author'], function($carry, $item) {
                                if ($carry == '<span class="td-poster-margin">'.$item.'</span><br>') return $carry;
                                return $carry .= '<span class="td-poster-margin">'.$item.'</span><br>';
                            }) : $event['author']; ?></td>
                            <td class="vert-align-middle"><?= is_array($event['title']) ? array_reduce($event['title'], function($carry, $item) {
                                if ($carry == '<span class="td-poster-margin">'.$item.'</span><br>') return $carry;
                                return $carry .= '<span class="td-poster-margin">'.$item.'</span><br>';
                            }) : $event['title']; ?></td>
                            <td class="vert-align-middle"><?= is_array($event['theater']) ? array_reduce($event['theater'], function($carry, $item) {
                                if ($carry == '<span class="td-poster-margin">'.$item.'</span><br>') return $carry;
                                return $carry .= '<span class="td-poster-margin">'.$item.'</span><br>';
                            }) : $event['theater']; ?></td>
                            <?php $firstKey = null; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>