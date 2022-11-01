<?php

/**
 * Template Name: Страница "Восстановления пароля"
 */

is_user_logged_in() ? wp_redirect('/') : '';

$reset_key = filter_input(INPUT_GET, 'key');
$user_login = filter_input(INPUT_GET, 'login');

get_header();
?>
<div class="main__auth">
    <?php
    if ($reset_key && $user_login) {
        echo get_template_part('parts/password', 'create');
    } else {
        echo get_template_part('parts/password', 'reset');
    }
    ?>
</div>
<?php get_footer(); ?>