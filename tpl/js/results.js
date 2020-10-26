$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $('body').on('click', '.tltp', function () {
        $('#modal_text').text($(this).attr('data-original-title'));
        $('#myModal').modal('toggle');
    });
    
    $('body').on('click', '.top_table td', function () {
        var text  = $(this).find('div').html();
        $('#modal_text').html(text);
        $('#myModal').modal('toggle');
    });


    $("#show_table_month").click(function () {
        if ($('#table_results:visible').length > 0) {
            $('#table_results').hide();
        } else {
            $('#table_results').show();
        }
        if ($('#table_month:visible').length > 0) {
            $('#table_month').hide();
        } else {
            $('#table_month').show();
        }
        $('.pag_holder').toggle();

    });


    $("#unselect_groups").click(function () {
        $('#gselect option').prop('selected', false);
        $('#gselect').trigger("chosen:updated");
    });
    var DT = $('#start_date').datetimepicker({
        locale: 'ru',
        format: 'YYYY-MM-DD',
    });

    var DT2 = $('#end_date').datetimepicker({
        locale: 'ru',
        format: 'YYYY-MM-DD',
    });


    //get_top
    $("#get_top").click(function () {
        $('.top_table').toggle();
    });


});
