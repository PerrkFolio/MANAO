jQuery(function ($) {	
    window.openModalContent = function (html) {
        var modal = $('#modal');
        if (modal.length > 0) {
            modal.find('.modal-content-fill').html(html);
            modal.show();
        }
    };

    $(document).on('modalOpenHtml', function(e){
        openModalContent(e.detail.html);
    });


    //modal actions
    $(document).ready(function () {
        $(document).on('click', '.close', function () {
            var modal = $('#modal');
            modal.hide();
        });
    });
});