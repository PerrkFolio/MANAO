jQuery(function ($) {
    function reloadDynamicMenuItem() {
        //dynamic menu
        $.post(ajax.url, { action: 'basic_dynamic_menu_item' }, function(responce){
            var menuItem = $(responce.data);
            $('.dynamic-menu-item').hide().after(menuItem);
            // $('.dynamic-menu-item').after(menuItem);
        });
    }
    $(document).ready(function () {
        reloadDynamicMenuItem();
    });

    //profile
    $(document).on('item_stored', function(e){
        var payLink = e.detail.pay_link;
        if(payLink){
            window.location.href = payLink;
        }
        // Проверить чтобы работало везде
        // ОБЯЗАТЕЛЬНО! Проверить добавление объявления через страницу профиля с и без према
        //
        else{
            window.location.reload();
        }
    });

	$(document).on('login',() => {
		$('.dynamic-buttons').html('<form data-ajax data-success_event="modalOpenHtml" class="mb-1">' +
            '<input type="hidden" name="action" value="basic_create_item">' +
            '<input type="submit" name="button" class="button" value="Добавить объявление" />' +
        '</form>' +
        '<form action="https://call-of-duty-mobile.su/profile">' +
            '<button type="submit">Мои объявления</button>' +
        '</form>');
    });

	function checkLogin() {
        $.post(ajax.url, {action: 'check_login'}, function(response) {
            let login = response.data;
            // console.log(login);
            // console.log(typeof login);
            if (login) {
                $(document).trigger('login');
            }
        });
    }
	$(document).ready(function () {
        checkLogin();
    });
});