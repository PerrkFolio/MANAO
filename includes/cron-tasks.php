<?php
//custom cron interval
add_filter( 'cron_schedules', 'cron_add_five_min' );
function cron_add_five_min( $schedules ) {
	$schedules['five_min'] = array(
		'interval' => 60 * 5,
		'display' => 'Раз в 5 минут'
	);
	return $schedules;
}

//starting cron task if not inited
if( ! wp_next_scheduled( 'basic_five_min_event' ) ) {
    wp_schedule_event( time(), 'five_min', 'basic_five_min_event');
}

add_action('basic_five_min_event', function(){
    $items = get_posts(['post_type' => 'item', 'numberposts' => -1]);
    foreach($items as $item){
        $is_premium = get_field('premium', $item->ID);
        $premium_start = get_post_meta($item->ID, 'premium_start');
        $premium_tarif_time = 72 * HOUR_IN_SECONDS;
        $premium_exired = $premium_start + $premium_tarif_time <= time(); //is premium expired

        //premium exired action
        if($is_premium && $premium_exired){
            update_field('premium', false, $item->ID);
        }

        $item_update_time = get_post_meta($item->ID, 'item_updated_time');
        $item_exired_time = 7 * DAY_IN_SECONDS;
        $item_expired = $item_update_time + $item_exired_time <= time();

        if($item_expired){
            $taxonomy = 'item_type';
            $in_archive_term = get_term_by('slug', 'in-archive', $taxonomy);
            wp_set_object_terms($item->ID, $in_archive_term->term_id, $taxonomy, true);
        }
    }
});