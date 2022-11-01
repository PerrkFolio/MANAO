<?php $login_page_url = basic_get_template_page_link('page-login.php') ?>
<form class="form" data-ajax="" data-success_redirect="<?php echo $login_page_url ?>">

    <h2 class="center"><?php the_title() ?></h2>
    <div class="subtitle mb-1">Установите новый пароль</div>

    <div class="mb-1">
        <label for="password">Пароль:</label>
        <input id="password" type="password" name="password" required>
    </div>

    <div class="mb-1">
        <label for="password2">Подтвердите пароль:</label>
        <input id="password2" type="password" name="password2" required>
    </div>

    <div class="form__info"></div>
    <input type="hidden" name="action" value="basic_password_reset_create">
    <input type="hidden" name="key" value="<?php echo filter_input(INPUT_GET, 'key') ?>">
    <input type="hidden" name="login" value="<?php echo filter_input(INPUT_GET, 'login') ?>">
    <input type="submit" value="Сохранить">
</form>