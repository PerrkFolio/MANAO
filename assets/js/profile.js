jQuery(function ($) {
    function renderProfileItems(page) {
        $('#items').empty(); //empty blocks
        $('#items').append($('.preloader').clone().removeClass('d-none')); //preloader
        $.post(ajax.url, { action: 'basic_filter_items_profile', paged: page }, function (response) {
            var code = response.data.html;
            $('#items').html(code);
        });
    }
    $(document).on('click', '.page-numbers:not(.current)', function () {
    
        var value = $(this).attr('href');
        value = value.split('/');
        value = value[value.length - 1]; //last is num of page

        renderProfileItems(value);

        return false;
    });
    $(document).ready(function () {
        renderProfileItems(1);
    });
});