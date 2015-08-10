$(function(){
    //dropdown list with user's tour for manager after country change
    $(document).on('change', '#managerhottourform-destination', function(){
        var destination = $(this).val();
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
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-hot-tours .loader-bg').addClass('hide');
            console.log(data.model);
            if(data.status == 'ok') {
                $('#manager-hot-tours-response').html(data.tours);
                $('.offers-tab.tab-badge.manager-hot-tours').text(data.count);
            }else{
                $('#manager-hot-tours-response').html(data.message);
                $('.offers-tab.tab-badge.manager-hot-tours').text(data.count);
            }
        });
    }
});