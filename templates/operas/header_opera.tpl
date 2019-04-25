<div class="content-header">
    <div class="sub-top-menu-opera">
        <ul>
            <li <?= ($data['active'] == 'opera_about') ? 'class="active"' : '' ?>>
                <a href="<?= $baseLink.'about'; ?>">Об опере</a>
            </li>
            <li>
                <span><b><?= $data['operaTitle']; ?></b></span>
            </li>
            <li <?= ($data['active'] == 'operas') ? 'class="active"' : '' ?>>
                <a href="<?= $baseLink.'films'; ?>">Видео(<?= count($data['opera']['video']); ?>)</a>
            </li>
        </ul>
    </div>
</div>