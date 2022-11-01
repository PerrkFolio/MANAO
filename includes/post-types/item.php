<?php
register_post_type('item', array(
    'labels' => array(
        'name' => __('Объявления'),
        'singular_name' => __('Объявление'),
    ),
    'public' => true, // it's not public, it shouldn't have it's own permalink, and so on
    'publicly_queryable' => true, // you should be able to query it
    'show_ui' => true, // you should be able to edit it in wp-admin
    'exclude_from_search' => false, // you should exclude it from search results
    'show_in_nav_menus' => true, // you shouldn't be able to add it to menus
    'has_archive' => true, // it shouldn't have archive page
    'rewrite' => true, // it shouldn't have rewrite rules
    'menu_icon' => 'dashicons-images-alt2'
));

add_action('init', function () {
    //Register taxonomy
    $taxonomy = 'item_type';
    $register = register_taxonomy($taxonomy, ['item'], array(
        'public' => true,
        'hierarchical' => true,
        'query_var' => true,
        'labels' => array(
            'name' => 'Тип объявлений',
            'singular_name' => 'Тип объявления',
        ),
    ));
    if (is_wp_error($register) === false) {
        
        //Required terms, register if not exist
        $item_types_terms = ['В Архиве' => 'in-archive', 'На Модерации' => 'in-moderation'];

        foreach ($item_types_terms as $term_name => $term_slug) {
            $term_arr = term_exists($term_name, $taxonomy);
            
            if (!$term_arr) {
                wp_insert_term(
                    $term_name,
                    $taxonomy,
                    ['slug' => $term_slug]
                );
            }
        }
    }
});
