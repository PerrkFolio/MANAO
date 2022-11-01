<?php

/**
 * Template Name: Страница "Регистрация"
 */

is_user_logged_in() ? wp_redirect('/') : '';
get_header();
?>
<div class="main__auth">
    <form class="form" data-ajax="" data-success_redirect="/">
        <input type="hidden" name="action" value="basic_registration">

        <h2 class="mb-1 center"><?php the_title() ?></h2>

        <div class="mb-1">
            <label for="name">Имя:</label>
            <input id="name" type="text" name="name" required>
        </div>

        <div class="mb-1">
            <label for="email">Email:</label>
            <input id="email" type="email" name="email" required>
        </div>

        <div class="mb-1">
            <label for="password">Пароль:</label>
            <input id="password" type="password" name="password" required>
        </div>

        <div class="mb-1">
            <label for="password2">Подтвердите пароль:</label>
            <input id="password2" type="password" name="password2" required>
        </div>

        <div class="mb-1">
            <input id="rights" type="checkbox" name="rights" required checked>
            <label for="rights">
                Я согласен с правилами <a href="<?php the_field('rights_page', 'options') ?>">порядока обработки перс. данные</a>
            </label>
        </div>

        <div class="form__info"></div>
        <input type="submit" value="Регистрация">
    </form>
</div>
<?php get_footer(); ?>