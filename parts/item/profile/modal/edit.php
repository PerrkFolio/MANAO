<form data-ajax data-success_reload id="item-edit-form" class="form-modal" data-success_event="item_stored">
    <input type="hidden" name="action" value="basic_store_item">
    <input type="hidden" name="ID" value="<?php echo $post->ID ?>">
    <input type="hidden" name="post_type" value="item">
    <input type="hidden" name="meta[owner]" value="<?php echo get_current_user_id() ?>">

    <h3 class="center mb-1">Редактировать</h3>

    <div>

<!--        <div class="mb-3">-->
<!--            <p>Платные функции</p>-->
<!--            <div>-->
<!--                <label>-->
<!--                    <input type="checkbox" name="meta[to_top]">-->
<!--                    Поднять объявление выше (10 рублей)-->
<!--                </label>-->
<!--            </div>-->
<!--        </div>-->

        <div class="mb-1">
            <label>Название</label>
            <input type="text" name="post_title" value="<?php echo $post->post_title ?>">
        </div>

        <div class="mb-1">
            <label>Цена *</label>
            <input type="number" name="meta[price]" value="<?php the_field('price', $post->ID) ?>" required>
        </div>

        <div class="mb-1">
            <label>Варианты оплаты *</label>
            <select name="meta[buy_method]" required>
                <?php
                $items = get_posts(['post_type' => 'buy-method']);
                foreach ($items as $one) :
                    ?>
                    <option value="<?php echo $one->ID ?>" <?php echo get_field('buy_method', $post->ID) == $one->ID ? 'selected' : '' ?>><?php echo $one->post_title ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-1">
            <label>Уровень игрока</label>
            <input type="number" name="meta[level]" value="<?php the_field('level', $post->ID) ?>">
        </div>

        <div class="mb-1">
            <label>Привязка *</label>
            <select name="meta[connection_method]" required>
                <?php
                $items = get_posts(['post_type' => 'connection-methods']);
                foreach ($items as $one) :
                    ?>
                    <option value="<?php echo $one->ID ?>" <?php echo get_field('connection_method', $post->ID) == $one->ID ? 'selected' : '' ?>><?php echo $one->post_title ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-1">
            <label>Описание</label>
            <textarea type="text" name="post_content" rows="4"></textarea>
        </div>

        <div class="mb-1">
            <label>Контакты *</label>
            <input type="text" name="meta[contacts]" value="<?php the_field('contacts', $post->ID) ?>" required>
        </div>

        <?php if ($screenshot = get_field('screenshot', $post->ID)) : ?>
            <div>
                <?php echo wp_get_attachment_image($screenshot['ID']) ?>
            </div>
        <?php endif; ?>
        <div class="mb-1">
            <label>Прикрепи скриншот в формате .jpg, .png или .jpeg весом не более 10 Мб *</label>
            <input type="file" name="screenshot" accept=".jpg, .jpeg, .png" <?php echo empty($screenshot) ? 'required' : '' ?>>
        </div>
    </div>
    <div class="form__info"></div>
</form>
<form data-ajax data-success_reload id="item-delete-form">
    <input type="hidden" name="action" value="basic_delete_item">
    <input type="hidden" name="post_id" value="<?php echo $post->ID ?>">
</form>
<input type="submit" form="item-edit-form" name="button" class="mr-3" value="Сохранить">
<input type="submit" form="item-delete-form" name="button" value="Удалить">