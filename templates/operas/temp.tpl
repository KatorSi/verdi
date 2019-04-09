<?php $opera = $data['opera']; ?>
<?php echo $data['header']; ?>
<div class="content-body" style="padding: 0 30px; overflow-y: auto; max-height: calc(100% - 145px); position: relative;">

    <?php if (!empty($opera['history'])): ?>
        <div class="block-opera-history" style="padding-bottom: 10px; overflow-y: auto; text-indent: 20px;">
            <h2 style="text-align: center; margin: 0; font-size: 18px; padding-bottom: 10px; color: #650012; font-weight: bold;">История создания</h2>
            <?php preg_match_all('/(\<p(.*?)\>(.*?)\<\/p\>)/imu', str_replace(["\n","\r","\n\r","\r\n"],'',$opera['history']), $matches); ?>
            <!--<?php echo str_replace(["\n","\r","\n\r","\r\n"],'',$opera['history']); print_r($matches); ?>-->
            <?php echo array_shift($matches[0]); ?>
            <?php echo str_replace('</p>', ' <a class="opera-view-full-history" style="color: #650012; font-style: italic; font-weight: bold;" href="#">(развернуть)</a></p>', array_shift($matches[0])); ?>
            <div class="opera-full-history" style="display: none;">
                <?php foreach ($matches[0] as $match) echo $match; ?>
            </div>

        </div>
    <?php endif; ?>
    <?php if (!empty($opera['description'])): ?>
        <div class="block-opera-description" style="padding-top:40px; padding-bottom: 10px; overflow-y: auto;text-indent: 20px;">
            <h2 style="text-align: center; margin: 0; font-size: 18px; padding-bottom: 10px; color: #650012; font-weight: bold;">Краткое содержание</h2>
            <?php
//            $d = explode('Действующие лица:', $opera['description'], 2);
//
//
//            $action = explode('I действие', $d[1]);
//            $hero = explode('<p', $action[0]);
//            $hero[1] = $hero[0] . '<div class="opera-full-hero" style="display: none;"><p' . $hero[1];
//            array_shift($hero[0]);
//            $hero[sizeof($hero) - 2] .= '</div>';
//
//            $dd = explode('<p', $action[1]);
//            $dd[0] .= '<div class="opera-full-hero" style="display: none;">';
//
//
//
//            $action[1] = implode('<p', $dd);
//            $action[0] = implode('<p', $hero);
//            $d[1] = implode('I действие', $action);
//
//            $d = implode('Действующие лица: <a class="opera-view-full-hero" style="color: #650012; font-style: italic; font-weight: normal; font-size: 14px;" href="#">(смотреть)</a></p>', $d);
//             echo $d .'</div>'; ?>
            <?php  echo $opera['description']; ?>
        </div>
    <?php endif; ?>
    <div class="opera-info" style="margin-top: 10px; color: #650012; font-size: 18px;">
        <div class="libretto">Либретто (<a href="#" style="color: #650012; font-style: italic;">скачать</a>)</div>
        <div class="video"><a href="#" class="open-videos" style="color: #650012;">Постановки, видео</a></div>
        <div class="audio"><a href="#" style="color: #650012;">Аудио</a></div>
        <div class="partiture"><a href="#" style="color: #650012;">Партитура</a></div>
        <div class="partiture"><a href="#" style="color: #650012;">Клавир</a></div>
    </div>
</div>
<!-- actionFullscreen -->
<!-- actionClose -->
<div class="popup-window" style="display: none; position: absolute; top: 0; left: 0; height: 100%; width: 100%; background: white;">
    <div class="btn-back" data-backfunc="customBackFunc"><a> &lt;&lt;&nbsp;назад</a></div>
    <div class="popup-wrapper" style="height: 100%;">
        <div class="popup-header" style="padding-top: 10px;">
            <h1 class="title opera-title" style="font-weight: bold; text-align: center; margin: 0; font-size: 24px; padding-bottom: 20px;"><?php echo $data['opera']['title']; ?></h1>
        </div>
        <div class="popup-content" style="height: calc(100% - 30px); overflow: hidden; padding: 0 30px; position: relative;">
            <div class="opera-video-block" style="display: none; height: 100%; padding-bottom: 10px;">
                <style>
                    .list-films tbody tr {
                        background: #e3e3e3;
                    }

                    .list-films tbody tr[data-href] {
                        background: #ffffff;
                        cursor: pointer;
                    }
                </style>
                <div id="target" style="margin-right: 15px;">
                    <table class="table table-default">
                        <thead>
                        <tr>
                            <td>Постановки</td>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="table-fixer" style="max-height: calc(100% - 37px);">
                    <table class="table table-default list-films">
                        <tbody>
                        <?php if (isset($opera['video']) && !empty($opera['video'])): foreach ($opera['video'] as $video): $ext = mb_strtolower(array_pop(explode('.', $video['name'])), 'utf-8'); ?>
                            <tr <?php if ($ext == 'mp4'): ?>data-href="https://erlyvideo.v6.spb.ru:443/BATTLE/<?php echo str_replace('/uploads/', 'verdi/', $video['path']) . $video['name']; ?>"<?php endif; ?>>
                                <td><?php echo $video['title']; ?></td>
                            </tr>
                        <?php endforeach; endif; ?></tbody>
                    </table>
                </div>
            </div>
            <div class="opera-video-player" style="display: none;"></div>
        </div>
    </div>
</div>