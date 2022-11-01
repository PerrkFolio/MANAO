<?php
register_post_type('buy-method', array(
    'labels' => array(
        'name' => __('Варианты оплаты'),
        'singular_name' => __('Вариант оплаты'),
    ),
    'public' => false, // it's not public, it shouldn't have it's own permalink, and so on
    'publicly_queryable' => true, // you should be able to query it
    'show_ui' => true, // you should be able to edit it in wp-admin
    'exclude_from_search' => true, // you should exclude it from search results
    'show_in_nav_menus' => false, // you shouldn't be able to add it to menus
    'has_archive' => false, // it shouldn't have archive page
    'rewrite' => false, // it shouldn't have rewrite rules
    'menu_icon' => 'dashicons-admin-tools'
));

