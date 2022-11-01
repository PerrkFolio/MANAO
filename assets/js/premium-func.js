jQuery(function ($) {
    $(document).ready(function () {
        $(document).on('click', '#premiumCheck', function (e) {
            var email_form = $('#EmailToBuy');
            var premium = $('#premium');
            var not_premium = $('#not_premium');
			
            if ($(this).is(':checked')){
                email_form.show();
                not_premium.hide();
                premium.show();
            } else {
                email_form.hide();
                premium.hide();
                not_premium.show();
            }
			
			if(document.item_create_form.meta[price].value != "" && document.item_create_form.meta[contacts].value != "") {
				$('#premium').removeAttr('disabled');
			} else {
				$('#premium').attr('disabled', 'disabled');
			}
        });
        $(document).on('click', '#premium', function (e) {
            var payMethodBlock = $('#pay_method');
            var itemForm = $('#item-create-form');
            var premium = $('#premium');
            var finish = $('#not_premium');
            itemForm.hide();
            premium.hide();
            payMethodBlock.show();
            finish.show();
        });
        $(document).on('click', '#back', function (e) {
            var payMethodBlock = $('#pay_method');
            var itemForm = $('#item-create-form');
            var premium = $('#premium');
            var finish = $('#not_premium');
            itemForm.show();
            premium.show();
            payMethodBlock.hide();
            finish.hide();
        });
    });
});