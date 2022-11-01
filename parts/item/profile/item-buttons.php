<?php
if (get_field('premium') == false) {
//    $premium_item_product = get_field('to_top_item_product', 'options');
//    $buy_link = create_premium_checkout_link($premium_item_product, get_the_ID());
//    $product_price = get_product($premium_item_product)->price;
}
?>
<div class="ad-item-buttons">
    <form data-ajax data-success_event="modalOpenHtml">
        <input type="hidden" name="action" value="basic_edit_item">
        <input type="hidden" name="post_id" value="<?php the_ID() ?>">
        <input type="submit" class="button" name="button" value="Редактировать" />
    </form>
<!--    --><?php //if (get_field('premium') == false && $premium_item_product = get_field('to_top_item_product', 'options')) : ?>
<!--        <form data-ajax data-success_redirect="--><?php //echo $buy_link ?><!--">-->
<!--            <input type="hidden" name="action" value="basic_success">-->
<!--            <input type="submit" class="button" value="Поднять вверх --><?php //echo $product_price ?><!-- руб.">-->
<!--        </form>-->
<!--    --><?php //endif; ?>
</div>