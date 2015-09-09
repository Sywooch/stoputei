$(function(){
    //dropdown list with user's tour for manager after country change
    $(document).on('change', '#userhottourform-destination', function(){
        var destination = ($(this).val() != '')?$(this).val():'all';
        var resort_url = $('.ajax-resort-for-filter').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#userhottourform-resort').html(select_resort);
            getUserHotToursList();
        });
    });

    //manager offers list after change resort
    $(document).on('change', '#userhottourform-resort', function(){
        getUserHotToursList();
    });

    //get manager offers list
    function getUserHotToursList(){
        var url = $('.ajax-get-user-hot-tours-list').attr('href');
        var data = $('#user-hot-tours-form').serialize();
        $('.user-hot-tours .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.user-hot-tours .loader-bg').addClass('hide');
            console.log(data.model);
            if(data.status == 'ok') {
                $('#user-hot-tours-response .list-data').html(data.tours);
                $('.offers-tab.tab-badge.user-hot-tours').text(data.count);
            }else{
                $('#user-hot-tours-response .list-data').html(data.message);
                $('.offers-tab.tab-badge.user-hot-tours').text(data.count);
            }
        });
    }
});