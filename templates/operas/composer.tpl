<div class="content-header">
    <div class="content-header-top-menu">
        <?php if(isset($data['main'][0]['title'])) : ?>
        <span class="title title-big"><?= $data['main'][0]['title'] ?></span>
        <?php else : ?>
        <span class="title title-big"><?= $data['composer']['title'] ?></span>
        <?php endif; ?>
        <div class="btn-back" data-backfunc="customBackFunc"><a href="<?= \Config::$host . 'home' ?>"> &lt;&lt;&nbsp;назад</a></div>
        <ul>
            <li class="active"><a href="<?= \Config::$host . 'operas' ?>"> Все оперы</a></li>
            <li> Биография</li>
            <li>Библиография</li>
            <li>Фильмы</li>
            <li>Другие факты</li>
        </ul>
    </div>
</div>
<div class="content-body">
    <div id="target">
        <table class="table table-default">
            <thead>
            <tr>
                <td>Год</td>
                <td>Название</td>
                <td>По произведению</td>
                <td>Автор либретто</td>
                <td>Город первой постановки</td>
                <td>Партитура</td>
                <td>Кол-во видео</td>
                <td>Кол-во аудио</td>
                <td>Время</td>
            </tr>
            </thead>
        </table>
    </div>
    <div class="table-fixer">
        <table class="table table-default">
            <tbody>
            <?php if(!empty($data['main'])) :
            foreach($data['main'] as $opera) : ?>
            <tr>
                <td><?=$opera['premiereYear'];?></td>
                <td><?=$opera['title'];?></td>
                <td><?=$opera['basedOn'];?></td>
                <td><?= $opera['librettist']; ?></td>
                <td><?= $opera['premierePlace']; ?></td>
                <td><?= $opera['partituraExists']; ?></td>
                <td><?= $opera['videos'] ?></td>
                <td><?= $opera['audios'] ?></td>
                <td><?= $opera['duration'] ?></td>
            </tr>
            <?php endforeach;
            endif;?>
            </tbody>
        </table>
    </div>
</div>