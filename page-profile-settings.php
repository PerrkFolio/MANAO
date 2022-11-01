<?php

/**
 * Template Name: Страница "Настройки профиля"
 */

is_user_logged_in() ?  '' : wp_redirect('/');
get_header();
?>
<main id="content" class="content">
    <h1 class="mb-3"><?php the_title() ?></h1>
    <form data-ajax data-success_reload>
        <input type="hidden" name="action" value="basic_user_settings">

        <div class="mb-3">
            <div class="mb-1">
                <label class="edit_profile" for="old_password">Старый пароль</label>
                <input type="password" name="old_password" value="">
            </div>
            <div>
                <label class="edit_profile" for="old_password">Новый пароль</label>
                <input type="password" name="password" value="">
            </div>
        </div>

        <div class="mb-3">
            <label class="edit_profile" for="old_password">Email</label>
            <input type="email" name="email" value="">
        </div>

        <div class="form__info mb-1"></div>
        <input type="submit" value="Сохранить">
    </form>

</main> <!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>