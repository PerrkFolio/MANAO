jQuery(function ($) {	
    $(document).ready(function($) {
        $('.mlogin-open').click(function() {
            $('.mlogin-fade').fadeIn();
            return false;
        }); 
        
        $('.mlogin-close').click(function() {
            $(this).parents('.mlogin-fade').fadeOut();
            return false;
        });     
     
        $(document).keydown(function(e) {
            if (e.keyCode === 27) {
                e.stopPropagation();
                $('.mlogin-fade').fadeOut();
            }
        });
        
        $('.mlogin-fade').click(function(e) {
            if ($(e.target).closest('.mlogin').length == 0) {
                $(this).fadeOut();                  
            }
        });
    });
});