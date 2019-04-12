            </div>
        </div>
		<div class="page-wrap-footer">
            <ul>
<!--                <li><a href="#">Афиша</a></li>-->
<!--                <li><a href="#">Фильмы</a></li>-->
<!--                <li><a href="#">Справочники</a></li>-->
                <li><a class="no_active">Настройки</a></li>
                <li><a href="/poster">Афиша</a></li>
                <li><a class="no_active">Справочники</a></li>
                <li><a class="no_active">Избранное</a></li>
                <li>
                    <?php if(false === Auth_client_api::$user): ?>
                    <a href="<?= Auth_client_api::$client_auth_link ?>" id="auth_login">Авторизация</a>
                    <?php else: ?>
                        <a href="<?php echo Auth_client_api::$client_change_data; ?>" id="auth_login">Личный кабинет</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
	</div>
            <script src="<?= \Config::$host . 'js/jquery.min.js' ?>"></script>
            <script src="http://cdn.006.spb.ru/private/player/battlevideo/player.js?1548158627"></script>
            <script type="text/javascript" src="/js/fancybox/source/jquery.fancybox.pack.min.js?v=2.1.7"></script>
            <script type="text/javascript" src="https://auth.006.spb.ru/js/client.js"></script>
            <script src ="<?= \Config::$host . 'js/pages/main.js?v=' . \Config::$version ?>"></script>
</body>
</html>