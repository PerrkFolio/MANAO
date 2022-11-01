<?php
add_action('wp_enqueue_scripts', 'basic_child_theme_styles' );
function basic_child_theme_styles() {
	//load
	wp_enqueue_style('basic-theme-css', get_template_directory_uri() .'/style.css' );
	wp_enqueue_style('basic-child-theme-css', get_stylesheet_directory_uri() .'/style.css', array('basic-theme-css') );

	//global assets
	wp_enqueue_script('basic-child', get_stylesheet_directory_uri() . '/assets/js/main.js');
	wp_localize_script('basic-child', 'ajax', array(
		'url' => admin_url('admin-ajax.php'),
	));
	wp_enqueue_script('ajax-forms', get_stylesheet_directory_uri() . '/assets/js/ajax-forms.js');

	//page assets
	if (is_singular('item') || is_post_type_archive('item') || is_page_template('page-profile.php' || is_page_template('page-sell.php'))) {
		wp_enqueue_style('basic-archive-item', get_stylesheet_directory_uri() .'/assets/css/archive-item.css', array('basic-child-theme-css') );
	}

	if (is_post_type_archive('item') || is_page_template('page-sell.php')) {
		wp_enqueue_script('basic-filter-page', get_stylesheet_directory_uri() . '/assets/js/filter-page.js');

        wp_enqueue_script('basic-modal', get_stylesheet_directory_uri() . '/assets/js/modal.js');
        wp_enqueue_script('basic-modal-login', get_stylesheet_directory_uri() . '/assets/js/modal-login.js');
        wp_enqueue_script('basic-premium-func', get_stylesheet_directory_uri() . '/assets/js/premium-func.js');
        wp_enqueue_style('basic-modal', get_stylesheet_directory_uri() .'/assets/css/modal.css', array('basic-child-theme-css') );
        wp_enqueue_style('basic-modal-login', get_stylesheet_directory_uri() .'/assets/css/modal-login.css', array('basic-child-theme-css') );
        wp_enqueue_style('basic-premium-func', get_stylesheet_directory_uri() .'/assets/css/premium-func.css', array('basic-child-theme-css') );
    }

	if(is_page_template('page-profile.php')){
		wp_enqueue_style('basic-modal', get_stylesheet_directory_uri() .'/assets/css/modal.css', array('basic-child-theme-css') );
		wp_enqueue_script('basic-modal', get_stylesheet_directory_uri() . '/assets/js/modal.js');
		wp_enqueue_script('profile-main', get_stylesheet_directory_uri() . '/assets/js/profile.js');
		wp_enqueue_script('basic-premium-func', get_stylesheet_directory_uri() . '/assets/js/premium-func.js');

		wp_enqueue_style('basic-premium-func', get_stylesheet_directory_uri() .'/assets/css/premium-func.css', array('basic-child-theme-css') );
	}

	if(is_page_template('page-thank-you.php')){
		wp_enqueue_script('thank-you-page', get_stylesheet_directory_uri() . '/assets/js/thank-you-page.js');
	}

}

add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {
    add_image_size('advert-thumb', 340, 9999, false);
}

function default_comments_on( $data ) {
    if( $data['post_type'] == 'item' ) {
        $data['comment_status'] = 'open';
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'default_comments_on' );

function wp_shortcode_add_an_ad() {
	echo "<div class='dynamic-buttons'><button>Авторизация</button></div>";
}
add_shortcode('addanadSC', 'wp_shortcode_add_an_ad');

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_602a6e61da312',
	'title' => 'Настройка цен',
	'fields' => array(
		array(
			'key' => 'field_602a6e7c33ac1',
			'label' => 'Цена за премиум',
			'name' => 'premium_price',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 29,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'page-sell.php',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;

//includes
require_once('includes/utils.php'); //custom functions
require_once('includes/auth-user.php'); //reg, login functions
require_once('includes/payment-hooks.php'); //hooks handlers
require_once('includes/child-hooks.php'); //hooks handlers
require_once('includes/acf/init.php'); //acf configurations
require_once('includes/cron-tasks.php'); //cron
require_once('includes/widget.php'); //cron

//post types
basic_autoload_scripts(array(
	__DIR__ . '/includes/post-types/'
));
