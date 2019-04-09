<?php $baseLink = \Config::$host . 'composer/' . $data['composer']['id'] . '/';

?>
<div class="content-header">
    <div class="content-header-top-menu">
        <span class="title title-big"><?php echo $data['composer']['title'] ?></span>
        <div class="btn-back" data-backfunc="customBackFunc"><a href="<?php echo \Config::$host . (isset($data['back']) ? $data['back'] : '') ?>"> &lt;&lt;&nbsp;назад</a></div>
        <?php if(!isset($data['opera'])): ?>
        <ul>
            <li <?php echo ($data['active'] === 'biography') ? 'class="active"' : ''; ?>>
                <a href="<?php echo $baseLink ?>">Биография</a>
            </li>
            <li <?php echo ($data['active'] === 'operas') ? 'class="active"' : ''; ?>>
                <a href="<?php echo $baseLink . 'operas' ?>">Оперы (<?php echo $data['composer']['numOperas']; ?>)</a>
            </li>
            <li <?php echo ($data['active'] === 'bibliography') ? 'class="active"' : ''; ?>>
                <a href="<?php echo $baseLink . 'bibliography' ?>">Библиография (<?php echo sizeof($data['composer']['books']); ?>)</a>
            </li>
            <li <?php echo ($data['active'] === 'movies') ? 'class="active"' : ''; ?>>
                <a href="<?php echo $baseLink . 'movies' ?>">Фильмы (<?php echo sizeof($data['composer']['films']); ?>)</a>
            </li>
            <li <?php echo ($data['active'] === 'facts') ? 'class="active"' : ''; ?>>
                <a href="<?php echo $baseLink . 'facts' ?>">Другие факты</a>
            </li>
        </ul>
        <?php endif; ?>
    </div>
    <?php if(isset($data['operaTitle']) && !empty($data['operaTitle'])): ?><h1 class="title opera-title"><?php echo $data['operaTitle']; ?></h1><?php endif; ?>
    <?php if(isset($data['opera']) && !empty($data['opera'])): ?>

        <ul>
            <li <?php echo (empty($data['page']) || $data['page'] === 'history') ? 'class="active"' : ''; ?>>
                <a href="<?php echo $baseLink . 'operas/' . $data['opera']['id'] ?>">История создания</a>
            </li>
            <li <?php echo ($data['page'] === 'description') ? 'class="active"' : ''; ?>>
                <a href="<?php echo $baseLink . 'operas/' . $data['opera']['id'] . '/description'  ?>">Краткое содержание и либретто</a>
            </li>
            <li <?php echo ($data['page'] === 'score') ? 'class="active"' : ''; ?>>
                <a href="<?php echo $baseLink . 'operas/' . $data['opera']['id'] . '/score' ?>">Партитура</a>
            </li>
            <li <?php echo ($data['page'] === 'clavier') ? 'class="active"' : ''; ?>>
                <a href="<?php echo $baseLink . 'operas/' . $data['opera']['id'] . '/clavier' ?>">Клавир</a>
            </li>
            <li <?php echo ($data['page'] === 'reviews') ? 'class="active"' : ''; ?>>
                <a href="<?php echo $baseLink . 'operas/' . $data['opera']['id'] . '/reviews' ?>">Рецензии и отзывы</a>
            </li>
        </ul>
        <h2 style="text-align: center; margin: 0; font-size: 18px; padding: 10px 0; color: #650012; font-weight: bold;"><?php echo $data['pageTitle']; ?></h2>
    <?php endif; ?>
</div>