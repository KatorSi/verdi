<div class="content-header">
    <div class="sub-top-menu">
        <ul>
            <li <?= ($data['active'] == 'about') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'biography'; ?>">Биография</a>
            </li>
            <li <?= ($data['active'] == 'bibliography') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'bibliography'; ?>">Библиография</a>
            </li>
            <li <?= ($data['active'] == 'films') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'films'; ?>">Фильмы</a>
            </li>
        </ul>
    </div>
</div>