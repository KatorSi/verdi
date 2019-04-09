</div>
</div>
</section>
<footer class="main-footer">
    <div class="container-fluid">
        <div class="row"></div>
    </div>
</footer>
</div>
<!--https://bootstrapious.com/donate-->
<script src="<?= \Config::$host . 'js/jquery.min.js?v=' . \Config::$version ?>"></script>
<script src="<?= \Config::$host . 'js/dashboard/bootstrap/popper.min.js?v=' . \Config::$version ?>"></script>
<script src="<?= \Config::$host . 'js/dashboard/bootstrap/bootstrap.min.js?v=' . \Config::$version ?>"></script>
<script src="<?= \Config::$host . 'js/dashboard/front.js?v=' . \Config::$version ?>"></script>
<script src="<?= \Config::$host . 'js/dashboard/FormService.js?v=' . \Config::$version ?>"></script>
<script type="text/javascript" src="https://auth.006.spb.ru/js/client.js"></script>
<?php if (!empty($data['scripts'])) :
    foreach ($data['scripts'] as $script) : ?>
<script src="<?= \Config::$host . $script . '?v=' . \Config::$version ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>