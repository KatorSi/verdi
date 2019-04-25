<?php $opera = $data['opera']; ?>
<?php echo $data['main_header']; ?>
<div class="content-header">
    <div class="sub-top-menu-opera">
        <ul>
            <li>
                <span><b><?= $data['operaTitle']; ?></b></span>
            </li>
        </ul>
    </div>
</div>
<?php echo $data['header_opera_about']; ?>
<div class="content-body opera">
    <div class="opera-info">
        <div class="libretto">Либретто (рус.) <a href="#" style="color: #650012; font-style: italic;">скачать</a></div>
        <div class="libretto">Либретто (итал.) <a href="#" style="color: #650012; font-style: italic;">скачать</a></div>
    </div>

    <?php if (!empty($opera['description'])): ?>
        <div class="opera-content" style="padding-top: 40px;">
            <?php  echo $opera['description']; ?>
        </div>
    <?php endif; ?>
</div>
