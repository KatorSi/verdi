<?php echo $data['header']; ?>
<?php echo $data['header_works']; ?>
<style>
    .cnt-part,
    .cnt-audio,
    .cnt-video{
        width: 80px;
        text-align: right;
    }
</style>
<div class="content-body" style="height: calc(100% - 85px);">
    <div id="target">
        <table class="table table-default">
            <thead>
            <tr>
                <td class="year">Год</td>
                <td>Название</td>
                <td>По произведению</td>
                <td>Автор либретто</td>
                <td>Город первой постановки</td>
                <td class="cnt-part">Партитура</td>
                <td class="cnt-video">Кол-во видео</td>
                <td class="cnt-audio">Кол-во аудио</td>
<!--                <td>Время</td>-->
            </tr>
            </thead>
        </table>
    </div>
    <div class="table-fixer">
        <table class="table table-default">
            <tbody>
            <?php if(!empty($data['operas'])) :
                foreach($data['operas'] as $opera) : ?>
                    <tr id="<?php echo $opera['id']; ?>" style="cursor: pointer;" onclick="location.href = '/composer/<?php echo $opera['composer_id']; ?>/operas/<?php echo $opera['id']; ?>/films'">
                        <td class="year"><?=$opera['premiereYear'] !== '0000' ? $opera['premiereYear'] :'';?></td>
                        <td><?=$opera['title'];?></td>
                        <td><?=$opera['basedOn'];?></td>
                        <td><?= $opera['librettist']; ?></td>
                        <td><?= $opera['premierePlace']; ?></td>
                        <td class="cnt-part"><?php //$opera['partituraExists']; ?></td>
                        <td class="cnt-video"><?php echo $opera['numVideo'] > 0 ? $opera['numVideo'] : '' ?></td>
                        <td class="cnt-audio"><?php echo $opera['numAudio'] > 0 ? $opera['numAudio'] : '' ?></td>
<!--                        <td>--><?//= $opera['duration'] ?><!--</td>-->
                    </tr>
                <?php endforeach;
            endif;?>
            </tbody>
        </table>
    </div>
</div>
