jQuery(function ($) {
    window.processFilters = function(initPaged = false) {
        console.log('processFilters');

        //empty blocks
        $('#filtered-items').empty();
        $('.items__block-pagination').empty();

        //preloader
        $('#filtered-items').append($('.preloader').clone().removeClass('d-none'));

        //reload pagination
        if (initPaged == false) {
            $('#filters').find('[name="paged"]').val(1);
        }

        //run filtering
        $('#filters').find('form input[type="submit"]').click();
    };

    $(document).on('change', '.filters__block', function () {
        processFilters();
    });

    $(document).on('change', '.filter__clone', function () {
        var filtersForm = $('#filters form');
        var parts = $(this).val().split(' ');
        var name = $(this).attr('name') + "[" + parts[0] + "]";

        filtersForm.find('.filter__clone-mirror').remove();

        var mirrorEl = filtersForm.find('[name="' + name + '"]');
        if (mirrorEl.length == 0) {
            var cloneFilter = $('<input class="filter__clone-mirror" type="hidden"/>');
            cloneFilter.attr('name', name);
            filtersForm.append(cloneFilter);
            mirrorEl = cloneFilter;
        }
        mirrorEl.val(parts[1]);

        processFilters();
    });

    $(document).on('itemsFiltered', function (e) {

        $('#filtered-items').html(e.detail.html);
        $('.items-found-count').text(e.detail.message);
        $('.items__block-pagination').html(e.detail.pagination);
    });

    $(document).on('click', '.page-numbers', function () {
        if ($(this).hasClass('current') == false) {
            var value = $(this).attr('href');
            value = value.split('/');
            value = value[value.length - 1]; //last is num of page

            $('#filters').find('[name="paged"]').val(value);
            processFilters(true);
        }
        return false;
    });

    //update on init
    processFilters();
});