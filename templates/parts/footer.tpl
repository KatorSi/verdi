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
                        <?//= var_dump(Auth_client_api::get_user()); ?>
                        <?php $userData = Auth_client_api::get_user(); ?>
                        <a data-toggle="modal" data-target="#lk_page">Личный кабинет</a>
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
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <div class="modal fade" id="lk_page" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="profile-wrap">
                        <table class="table table-profile">
                            <tbody><tr>
                                <td colspan="2">
                                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                                        <i aria-hidden="true" class="glyphicon glyphicon-remove"></i>
                                    </button>
                                    <h4>Ваш личный кабинет <span class="profile_name">senin</span></h4>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="text-center form-group">
                                        <img id="ava_img" class="ava-img" src="/img/noavatar.png">
                                    </div>
                                    <div class="text-center">
                                        <a style="cursor: pointer;" id="auth_login" href="<?php echo Auth_client_api::$client_change_data; ?>">Изменить</a>
                                    </div>
                                </td>
                                <td>
                                    <table class="table table-profile-info">
                                        <tbody><tr>
                                            <td>О себе:</td>
                                            <td id="about">не указано</td>
                                        </tr>
                                        <tr>
                                            <td>Город:</td>
                                            <td id="city" class="profile_city"><?= $userData['city'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Дата рождения:</td>
                                            <td id="city" class="profile_city"><?= $userData['b_date'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Дата регистрации:</td>
                                            <td id="city" class="profile_city"><?= $userData['date_reg'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Ссылка в соц-сети:</td>
                                            <td id="link">
                                                <?= !empty($userData['social_link']) ? $userData['social_link'] : ''; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Электронная почта:</td>
                                            <td id="e-mail"><?= $userData['email'] ?></td>
                                        </tr>

                                        </tbody></table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="table-profile-controls">
                                        <a class="profileLogoutBtn_class" id="profileLogoutBtn" style="cursor: pointer;">[Выйти из ЛК]</a>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>