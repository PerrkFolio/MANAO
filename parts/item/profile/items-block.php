<div class="filter__block">
    <div class="ad-object-list">
        <?php
        global $wp_query, $paged;

        $args = [
            'post_type' => 'item',
            'posts_per_page' => 10,
            'paged' => $paged,
            'meta_query' => [
                [
                    'key' => 'owner',
                    'value' => get_current_user_id(),
                ],
            ]
        ];
        $query = new WP_Query($args);
        $wp_query = $query;

        while ($query->have_posts()) {
            $query->the_post();
            $template_part = get_field('premium') ? '-premium' : '';
            get_template_part('parts/item/profile/item', 'loop' . $template_part);
        }
        the_posts_pagination();
        wp_reset_query();
        ?>
    </div>
</div>