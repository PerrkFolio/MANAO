<?php $current_user = wp_get_current_user(); ?>
<form data-ajax id="item-create-form" name="item_create_form" class="form-modal"  data-success_event="item_stored">
    <input type="hidden" name="action" value="basic_store_item">
    <input type="hidden" name="post_type" value="item">
    <input type="hidden" name="meta[owner]" value="<?php echo get_current_user_id() ?>">

    <h3 class="center mb-1">Новое объявление</h3>

    <div>

        <div class="mb-1">
            <label>Название</label>
            <input type="text" name="post_title" value="">
        </div>

        <div class="mb-1">
            <label>Цена <span>*</span></label>
            <input type="number" id="price" name="meta[price]" value="" required>
        </div>

        <div class="mb-1">
            <label>Варианты оплаты <span>*</span></label>
            <select id="buy_method" name="meta[buy_method]" required>
                <?php
                $items = get_posts(['post_type' => 'buy-method']);
                foreach ($items as $one) :
                    ?>
                    <option value="<?php echo $one->ID ?>"><?php echo $one->post_title ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-1">
            <label>Уровень игрока</label>
            <input type="number" name="meta[level]" value="">
        </div>

        <div class="mb-1">
            <label>Привязка <span>*</span></label>
            <select id="connection_method" name="meta[connection_method]" required>
                <?php
                $items = get_posts(['post_type' => 'connection-methods']);
                foreach ($items as $one) :
                    ?>
                    <option value="<?php echo $one->ID ?>"><?php echo $one->post_title ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-1">
            <label>Описание</label>
            <textarea type="text" name="post_content" rows="4"></textarea>
        </div>

        <div class="mb-1">
            <label>Контакты <span>*</span></label>
            <input type="text" id="contacts" name="meta[contacts]" value="" required>
        </div>

        <div class="mb-1">
            <label>Прикрепи скриншот в формате .jpg, .png или .jpeg весом не более 10 Мб *</label>
            <input type="file" name="screenshot" accept=".jpg, .jpeg, .png" required>
        </div>

        <div class="mb-1">
            <label>Платные функции</label>
            <input id="premiumCheck" type="checkbox" name="meta[premium]">
            <input type="hidden" name="premium_price" value=<?php the_field('premium_price', 'options') ?>>
            <span class="CheckBoxName">Премиум размещение - <?php the_field('premium_price', 'options') ?> рублей</span>
            <small class="hint">Ваше объявление будет подсвечено и будет находиться сверху</small>
        </div>
        <div id="EmailToBuy" class="mb-1">
            <label>E-Mail <span>*</span></label>
            <input type="email" name="meta[email_to_buy]" required value=<?php echo $current_user->user_email; ?>>
            <small class="hint">На эту почту придет чек об оплате</small>
            <small class="hint">Нажимая Продолжить вы принимаете <a href="https://call-of-duty-mobile.su/soglashenie">соглашение</a></small>
        </div>
    </div>
    <div class="form__info"></div>
</form>
<div id="pay_method">
    <form>
        <span id="back"><</span><h3 class="center mb-1">Способ оплаты</h3>
        <div class="mb-1 grid">
            <div class="form_radio_btn text-center col4 qiwi">
                <input id="radio-2" type="radio" name="meta[payment_method]" value="2">
                <label for="radio-2"><svg viewBox="0 0 28.35 29.46" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><g><path d="M23.3,19.9c.1.6-.1.8-.2.8s-.5-.2-.7-.7-.4-1-.2-1.2.3-.2.6-.2C23.1,18.8,23.2,19.5,23.3,19.9Z" style="fill: #f18b24"></path><path d="M20.6,21.1a1.23,1.23,0,0,1,.5,1.5,1.14,1.14,0,0,1-.8.3,3.18,3.18,0,0,1-.9-.3c-.6-.5-.7-1.2-.3-1.6.2-.2.3-.2.6-.2S20.3,20.9,20.6,21.1Z" style="fill: #f18b24"></path></g><path d="M19.6,25.9c2.5,0,5.2.9,8.2,3.5.3.2.7-.1.5-.4a12.14,12.14,0,0,0-8.4-5,8.66,8.66,0,0,1-6.2-4.7c-.2-.4-.3-.3-.4.2a9.75,9.75,0,0,0,.2,2.3h-.4a8.6,8.6,0,1,1,8.6-8.6,3.75,3.75,0,0,1-.1,1,11.5,11.5,0,0,0-2.7-.1c-.3,0-.3.2,0,.2a6.07,6.07,0,0,1,5.3,5.5c0,.1.1.1.2,0a12.69,12.69,0,0,0,1.8-6.7A13.1,13.1,0,1,0,13.1,26.2C14.9,26.2,16.8,25.9,19.6,25.9Z" style="fill: #ff8c00"></path> </g></svg><span class="mt-2 d-block">QIWI</span></label>
            </div>
            <div class="form_radio_btn text-center col4">
                <input id="radio-3" type="radio" name="meta[payment_method]" value="3">
                <label for="radio-3"><svg viewBox="0 0 28.35 29.46" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M19.8,21.1l2.8,3.1-1.8,1.2a14.45,14.45,0,0,1-6.9,1.8A13.74,13.74,0,0,1,0,13.6,13.74,13.74,0,0,1,13.9,0,14,14,0,0,1,20,1.4c.3.2.6.3.9.5L19.6,3,17.7,1.1,14.4,3.9,12.5,1.8,6.4,7.2l3.9,4.2L8.8,12.7l3.8,4.2-1.5,1.3,5.4,5.9Zm6.7-8.5L28,14.2l-1.7,1.4L24.8,14Zm-2.4,5.7,2.2,2.4-2.5,2.2-2.2-2.4ZM17.6,3.4l2.2,2.4L17.3,8,15.1,5.6Zm-5.3.8,3,3.2L12,10.3,9,7.1Zm7.3,8.7-2.2-2.4,2.5-2.2,2.2,2.4Zm3.1-3.7,1.7-1.4,1.5,1.6-1.7,1.4Zm-1,8.8-2.2-2.4L22,13.4l2.2,2.4ZM20.5,4.4,22.2,3l1.5,1.6L22,6ZM14.4,15.9l-3-3.3,3.3-2.9,3,3.2Zm2.3,5.6-3-3.2L17,15.4l3,3.2Z" style="fill: #006ab4"></path></svg><br><span class="mt-2 d-block">WebMoney</span></label>
            </div>
            <div class="form_radio_btn text-center col4">
                <input id="radio-4" type="radio" name="meta[payment_method]" value="4">
                <label for="radio-4"><svg viewBox="0 0 28.4 27.6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M.2,14.5c0-1.7.2-2.7,3.5-5.2C6.5,7.2,15.5,0,15.5,0V12h6.9V29.3H2.2A2.22,2.22,0,0,1,0,27.1Z" style="fill: #f4cd29"></path> <g> <polygon points="15.6 12 15.6 19 3 27.5 19 22.3 19 12 15.6 12" style="fill: #cba922"></polygon><path d="M9.9,11.6c.7-.9,1.8-1.2,2.4-.7s.5,1.6-.2,2.5-1.8,1.2-2.4.7-.6-1.6.2-2.5" style="fill: #1f181b"></path></g></g></svg><br><span class="mt-2 d-block">Yandex.Деньги</span></label>
            </div>
            <div class="form_radio_btn text-center col4 alfa">
                <input id="radio-5" type="radio" name="meta[payment_method]" value="5">
                <label for="radio-5"><svg viewBox="0 0 18 28.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g> <path d="M.7,17.7c.2.1,2.7,1,2.9,1.1s.3,0,.3-.2S5,15.5,5.2,15.2h7.4c.2.3,1.2,3.3,1.3,3.4s.2.2.3.2,2.7-1,2.9-1.1.2-.2.2-.4c-.2-.4-5.1-14.1-5.4-14.6C11.4,1.3,10.8,0,8.9,0s-2.6,1.4-3,2.7C5.7,3.4.8,16.9.5,17.3A.52.52,0,0,0,.7,17.7ZM8.9,4.3h0l2.6,7.5h-5Z" style="fill: #ee3424"></path> <path d="M17.7,24.3H.2c-.2,0-.2.2-.2.3v3.2a.37.37,0,0,0,.2.3H17.7a.32.32,0,0,0,.3-.3V24.6Q17.85,24.3,17.7,24.3Z" style="fill: #ee3424"></path> </g></svg><br><span class="mt-2 d-block">Альфа Банк</span></label>
            </div>
            <div class="form_radio_btn text-center col6 credit-card">
                <input id="radio-1" type="radio" name="meta[payment_method]" value="1">
                <label for="radio-1"><svg viewBox="0 0 140 80" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><svg id="Слой_1" data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 140 80"><defs><style>.cls-1{fill:#24a84d;}.cls-2{fill:url(#linear-gradient);}.cls-3{fill:#f59d1a;}.cls-4{fill:#e7001b;}.cls-5{fill:#fc5f01;}.cls-6{fill:#e30520;}.cls-7{fill:#0081c4;}.cls-8{fill:#0f5787;}.cls-9{fill:url(#Blue_Gradient_01);}</style><linearGradient id="linear-gradient" x1="60.81" y1="50.84" x2="78.59" y2="50.84" gradientTransform="translate(0.4 -0.51) rotate(0.41)" gradientUnits="userSpaceOnUse"><stop offset="0.01" stop-color="#0fa5e1"></stop><stop offset="0.35" stop-color="#0c9cda"></stop><stop offset="0.91" stop-color="#0483c6"></stop><stop offset="1" stop-color="#037ec2"></stop></linearGradient><linearGradient id="Blue_Gradient_01" x1="59.1" y1="23.36" x2="121.03" y2="23.36" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#241e5c"></stop><stop offset="1" stop-color="#004d9f"></stop></linearGradient></defs><title>BankCard</title><path class="cls-1" d="M51.92,49,48,57.24h-.39l.07-10-5.41,0-.12,17,4.59,0a3.09,3.09,0,0,0,2.82-1.78l3.87-8.22h.39l-.07,10,5.41,0,.12-17-4.59,0A3.09,3.09,0,0,0,51.92,49"></path><path class="cls-1" d="M31.62,49.31,29.31,57.1h-.39l-2.2-7.83a3.09,3.09,0,0,0-3-2.26l-5.4,0-.12,17,5.41,0,.07-10h.39l3,10.07,3.86,0,3.16-10h.39l-.07,10,5.41,0,.12-17-5.4,0a3.09,3.09,0,0,0-3,2.21"></path><path class="cls-1" d="M61.59,55l-.07,9.27,5.4,0,0-5.41,5.81,0a5.79,5.79,0,0,0,5.49-3.82Z"></path><path class="cls-2" d="M72.85,47.37l-12-.09a8.5,8.5,0,0,0,8.31,7l9.3.07a5.89,5.89,0,0,0,.12-1.16,5.8,5.8,0,0,0-5.75-5.84"></path><g id="g3110"><path id="path2997" class="cls-3" d="M50.87,23.36a10.09,10.09,0,1,1-10.09-10,10,10,0,0,1,10.09,10Z"></path><path id="path2995" class="cls-4" d="M38.43,23.36a10.09,10.09,0,1,1-10.09-10,10,10,0,0,1,10.09,10Z"></path><path id="path2999" class="cls-5" d="M34.56,15.49a10,10,0,0,0,0,15.74,10,10,0,0,0,0-15.74Z"></path></g><path id="path2997-2" data-name="path2997" class="cls-6" d="M121,55.33a10.09,10.09,0,1,1-10-10.07,10,10,0,0,1,10,10.07Z"></path><path id="path2995-2" data-name="path2995" class="cls-7" d="M108.58,55.24a10.09,10.09,0,1,1-10-10.07,10,10,0,0,1,10,10.07Z"></path><path id="path2999-2" data-name="path2999" class="cls-8" d="M104.77,47.34a10,10,0,0,0-.11,15.74,10,10,0,0,0,.11-15.74Z"></path><path class="cls-9" d="M82.61,13.71,74.5,33.06H69.21l-4-15.44A2.12,2.12,0,0,0,64,15.92a20.93,20.93,0,0,0-4.94-1.65l.12-.56h8.52a2.33,2.33,0,0,1,2.31,2l2.11,11.19,5.21-13.17Zm20.73,13c0-5.1-7.06-5.39-7-7.67,0-.69.68-1.43,2.12-1.62a9.45,9.45,0,0,1,4.93.87l.88-4.1a13.44,13.44,0,0,0-4.68-.86c-4.95,0-8.43,2.63-8.46,6.39,0,2.79,2.48,4.34,4.38,5.26s2.6,1.56,2.6,2.4c0,1.3-1.56,1.87-3,1.89A10.47,10.47,0,0,1,90,28.09l-.91,4.24a15.15,15.15,0,0,0,5.56,1c5.26,0,8.7-2.6,8.71-6.62m13.06,6.32H121l-4-19.34h-4.27a2.28,2.28,0,0,0-2.13,1.42l-7.51,17.93h5.25l1-2.89h6.42Zm-5.58-6.85,2.63-7.26L115,26.2ZM89.76,13.71,85.62,33.06h-5l4.14-19.34Z"></path></svg></svg></label>
            </div>
        </div>
        <div class="mb-1">
            <p>К оплате: <?php the_field('premium_price', 'options') ?> рублей.</p>
        </div>
    </form>
</div>
<input id="not_premium" type="submit" form="item-create-form" name="button" class="item-create-form" value="Создать">
<input id="premium" type="button" class="item-create-form" value="Продолжить">