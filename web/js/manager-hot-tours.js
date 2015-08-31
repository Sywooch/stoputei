$(function(){
    //dropdown list with user's tour for manager after country change
    $(document).on('change', '#managerhottourform-destination', function(){
        var destination = ($(this).val() != '')?$(this).val():'all';
        var resort_url = $('.ajax-resort-for-filter').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#managerhottourform-resort').html(select_resort);
            getManagerHotToursList();
        });
    });

    //manager offers list after change resort
    $(document).on('change', '#managerhottourform-resort', function(){
        getManagerHotToursList();
    });

    //get manager offers list
    function getManagerHotToursList(){
        var url = $('.ajax-get-manager-hot-tours-list').attr('href');
        var data = $('#manager-hot-tours-form').serialize();
        $('.manager-hot-tours .loader-bg').removeClass('hide');
        $('#manager-hot-tours-response .list-data').empty();
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-hot-tours .loader-bg').addClass('hide');
            console.log(data.model);
            if(data.status == 'ok') {
                $('#manager-hot-tours-response .list-data').html(data.tours);
                $('.offers-tab.tab-badge.manager-hot-tours').text(data.count);
            }else{
                $('#manager-hot-tours-response .list-data').html(data.message);
                $('.offers-tab.tab-badge.manager-hot-tours').text(data.count);
            }
        });
    }


    $(document).on('input', '#managerhottourform-id', function(){
        var tour_id = $(this).val();
        var url = $('.ajax-get-manager-hot-tours-list-by-id').attr('href');
        $('.manager-hot-tours .loader-bg').removeClass('hide');
        $.get(url, {'tour_id': tour_id}).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-hot-tours .loader-bg').addClass('hide');
            console.log(data.model);
            if(data.status == 'ok') {
                $('#manager-hot-tours-response .list-data').html(data.tours);
                $('.offers-tab.tab-badge.manager-hot-tours').text(data.count);
            }else{
                $('#manager-hot-tours-response .list-data').html(data.message);
                $('.offers-tab.tab-badge.manager-hot-tours').text(data.count);
            }
        });
    });

    $(document).on('click', '#manager-hot-tours-response .remove-hot-tour', function(e){
        e.preventDefault();
        var tour_id = $(this).attr('data-tour-id');
        var url = $(this).attr('href');
        $('.remove-hot-tour[data-tour-id="'+tour_id+'"]').replaceWith('<img src="/images/loader.gif" class="replace-loader remove-hot-tour">');
        $.post(url).done(function(response){
            var data = $.parseJSON(response);
            if(data.status == 'ok'){
                $('#manager-hot-tours-response .user-tour-wrapper[data-tour-id="'+tour_id+'"]').fadeOut('slow');
                $('.offers-tab.tab-badge.manager-hot-tours').text(data.count);
            }else{
                alert(data.message);
            }
        });
    })
});