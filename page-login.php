<?php

/**
 * Template Name: Страница "Авторизация"
 */

is_user_logged_in() ? wp_redirect('/') : '';
get_header();
?>
<div class="main__auth">
    <form class="form" data-ajax="" data-success_redirect="/">
        <input type="hidden" name="action" value="basic_login">

        <h2 class="center"><?php the_title() ?></h2>

        <div class="mb-1">
            Нет аккаунта?
            <a href="<?php echo basic_get_template_page_link('page-registration.php') ?>">Зарегистрироваться</a>
        </div>


        <div class="mb-1">
            <label class="login_profile" for="login">Логин:</label>
            <input class="input_login" id="login" type="text" name="login" required>
        </div>

        <div class="mb-1">
            <label class="login_profile" for="password">Пароль:</label>
            <input class="input_pass" id="password" type="password" name="password" required>
        </div>

        <div class="form__info"></div>
        <input type="submit" value="Авторизация">
    </form>
</div>
<?php get_footer(); ?>