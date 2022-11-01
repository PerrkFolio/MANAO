<?php
class filterAdsWidget extends WP_Widget {
    /*
     * создание виджета
     */
    function __construct() {
        parent::__construct(
            'true_top_widget',
            'Фильтры объявлений',
            array( 'description' => 'Выводит фильтр для объявлений' )
        );
    }

    /*
     * фронтэнд виджета
     */
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] ); // к заголовку применяем фильтр (необязательно)
        $posts_per_page = $instance['posts_per_page'];

        echo $args['before_widget'];

        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

        ?>
        <div id="filters" class="filters__block">
            <form data-ajax data-success_event="itemsFiltered">
                <input type="hidden" name="action" value="basic_filter_items">
                <input type="submit" class="d-none">
                <input type="hidden" name="paged" value="1">

                <input class="filter__clone-mirror" type="hidden" name="orderby[item_updated_time]" value="DESC">

                <div class="filter__row">
                    <div class="filter__title wtitle">Способ оплаты </div>
                    <?php foreach (get_posts(['post_type' => 'buy-method']) as $one) : ?>
                        <label class="filter__item mb-1">
                            <input type="checkbox" name="meta[buy_method][]" value="<?php echo $one->ID ?>">
                            <?php echo $one->post_title ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="filter__row">
                    <div class="filter__title wtitle">Способ привязки </div>
                    <?php foreach (get_posts(['post_type' => 'connection-methods']) as $one) : ?>
                        <label class="filter__item mb-1">
                            <input type="checkbox" name="meta[connection_method][]" value="<?php echo $one->ID ?>">
                            <?php echo $one->post_title ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="filter__row">
                    <div class="wtitle">Цена </div>
                    <div class="filter__row-inner">
                        <label>От: <input type="number" name="meta[price][>]" min="0"></label>
                        <label>До: <input type="number" name="meta[price][<]" min="0"></label>
                    </div>
                </div>

                <div class="filter__row">
                    <div class="filter__title wtitle">Уровень </div>
                    <div class="filter__row-inner">
                        <label>От: <input type="number" name="meta[level][>]" min="0"></label>
                        <label>До: <input type="number" name="meta[level][<]" min="0"></label>
                    </div>
                </div>
            </form>
        </div>
        <?php

        echo $args['after_widget'];
    }

    /*
     * бэкэнд виджета
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        if ( isset( $instance[ 'posts_per_page' ] ) ) {
            $posts_per_page = $instance[ 'posts_per_page' ];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Заголовок</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Количество постов:</label>
            <input id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo ($posts_per_page) ? esc_attr( $posts_per_page ) : '5'; ?>" size="3" />
        </p>
        <?php
    }

    /*
     * сохранение настроек виджета
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['posts_per_page'] = ( is_numeric( $new_instance['posts_per_page'] ) ) ? $new_instance['posts_per_page'] : '5'; // по умолчанию выводятся 5 постов
        return $instance;
    }
}

/*
 * регистрация виджета
 */
function filter_ads_widget_load() {
    register_widget( 'filterAdsWidget' );
}
add_action( 'widgets_init', 'filter_ads_widget_load' );
