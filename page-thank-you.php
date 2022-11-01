<?php

/**
 * Template Name: Страница "Успешная покупка"
 */

is_user_logged_in() ?  '' : wp_redirect('/');
get_header();
?>
<main id="content" class="content">
    <h3 class="mb-3">Спасибо!</h3>

    <form id="thank" data-ajax>
        <div class="form__info">
            <input type="hidden" name="action" value="basic_get_thank_you_page_text">
            <input type="submit" class="d-none">
        </div>
    </form>
    
</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>