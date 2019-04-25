<?php
    $baseLink = \Config::$host . 'composer/' . $data['composer']['id'] . '/operas';
?>
<div class="content-header">
    <div class="content-header-top-menu composer-menu">
        <div class="title-wrapper">
            <div class="menu-title">
                <span class="title title-big"><?php echo $data['composer']['title'] ?></span>
            </div>
        </div>
        <div class="col-lg-1 btn-back-wrapper">
            <div class="btn-back" data-backfunc="customBackFunc"><a href="<?php echo \Config::$host . (isset($data['back']) ? $data['back'] : '') ?>"> &lt;&lt;&nbsp;назад</a></div>
        </div>
    </div>
</div>