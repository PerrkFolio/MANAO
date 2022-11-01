<form class="form-modal" data-ajax="" data-success_redirect="/">
    <input type="hidden" name="action" value="basic_login">

    <h2 class="center"><?php the_title() ?></h2>

    <div class="mb-1">
        Нет аккаунта?
        <a href="<?php echo basic_get_template_page_link('page-registration.php') ?>">Зарегистрироваться</a>
    </div>


    <div class="mb-1">
        <label for="login">Логин:</label>
        <input id="login" type="text" name="login" required>
    </div>

    <div class="mb-1">
        <label for="password">Пароль:</label>
        <input id="password" type="password" name="password" required>
    </div>

    <div class="form__info"></div>
    <input type="submit" value="Авторизация">
</form>