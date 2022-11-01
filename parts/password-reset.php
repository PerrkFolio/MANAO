<form class="form" data-ajax="" data-success_redirect="/">

    <h2 class="center"><?php the_title() ?></h2>
    <div class="subtitle mb-1">На указаный email будет высланна ссылка восстановления</div>

    <div class="mb-1">
        <label for="email">Email:</label>
        <input id="email" type="email" name="email" required>
    </div>

    <div class="form__info"></div>
    <input type="hidden" name="action" value="basic_password_reset_send">
    <input type="submit" value="Отправить">
</form>