<a href="<?php the_permalink() ?>" class="ad-object-item ad-object-premium">
    <div class="ad-object-content">
        <div class="ad-object-thumb">
            <img src="<?php echo get_field('screenshot')['sizes']['advert-thumb'] ?>" class="ad-object-thumb-img" alt="<?php echo get_field('screenshot')['title'] ?>">
        </div>
        <div class="ad-object-description">
            <span class="ad-object-title"><?php echo get_the_title() ?></span>
            <span class="ad-object-price"><?php the_field('price') ?> руб</span>
            <?php if ($level = get_field('level')) : ?>
                <span class="ad-object-lvl"><?php echo $level ?> уровень</span>
            <?php endif; ?>
            <div class="ad-object-short">
                <p>Способ оплаты: <span><?php echo get_post(get_field('buy_method'))->post_title ?></span></p>
                <p>Способ передачи: <span><?php echo get_post(get_field('connection_method'))->post_title ?></span></p>
            </div>
        </div>
    </div>
</a>