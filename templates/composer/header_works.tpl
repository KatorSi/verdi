<div class="content-header">
    <div class="sub-top-menu">
        <ul>
            <?php if (!empty($data['composer']['opera'])): ?>
            <li <?= ($data['active'] == 'operas') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'operas'; ?>">Оперы(<?= $data['composer']['opera']?>)</a>
            </li>
            <?php endif; ?>
            <?php if (!empty($data['composer']['symphony'])): ?>
            <li <?= ($data['active'] == 'symphonies') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'symphonies'; ?>">Симфонии(<?= $data['composer']['symphony'] ?>)</a>
            </li>
            <?php endif; ?>
            <?php if (!empty($data['composer']['concert'])): ?>
            <li <?= ($data['active'] == 'concerts') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'concerts'; ?>">Концерты(<?= $data['composer']['concert'] ?>)</a>
            </li>
            <?php endif; ?>
            <?php if (!empty($data['composer']['sonata'])): ?>
            <li <?= ($data['active'] == 'sonatas') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'sonatas'; ?>">Сонаты(<?= $data['composer']['sonata'] ?>)</a>
            </li>
            <?php endif; ?>
            <?php if (!empty($data['composer']['brass']) || !empty($data['composer']['instrumental']) || !empty($data['composer']['vocal'])): ?>
            <li <?= ($data['active'] == 'others') ? 'class="active"' : '' ?>>
            <a href="<?= $baseLink.'others'; ?>">Другие произведения(<?= $data['composer']['brass'] + $data['composer']['instrumental'] + $data['composer']['vocal']; ?>)</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>