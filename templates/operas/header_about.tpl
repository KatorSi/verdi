<div class="content-header">
    <div class="sub-top-menu-opera">
        <ul>
            <li <?= ($data['active'] == 'opera_about') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'about'; ?>">История создания</a>
            </li>
            <li <?= ($data['active'] == 'opera_desc') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'description'; ?>">Краткое содержание и либретто</a>
            </li>
            <li <?= ($data['active'] == 'opera_score') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'score'; ?>">Партитура</a>
            </li>
            <li <?= ($data['active'] == 'opera_clavier') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'clavier'; ?>">Клавир</a>
            </li>
            <li <?= ($data['active'] == 'opera_review') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'review'; ?>">Рецензии и отзывы</a>
            </li>
        </ul>
    </div>
</div>