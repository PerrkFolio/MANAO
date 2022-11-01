<?php get_header();?>
    <main id="content" class="content">

    <?php
    if (function_exists('yoast_breadcrumb')) {
//        yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
    }
    ?>
    <?php while (have_posts()) : the_post();

    get_template_part('parts/item/content');

        if (comments_open() || get_comments_number()) {
            do_action('basic_before_post_comments_area');
            comments_template();
            do_action('basic_after_post_comments_area');
        }

    endwhile; ?>



</main> <!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>