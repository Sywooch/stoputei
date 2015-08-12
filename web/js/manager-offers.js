$(function(){
    //dropdown list with user's tour for manager after country change
    $(document).on('change', '#manageroffersform-destination', function(){
        var destination = $(this).val();
        var resort_url = $('.ajax-resort-for-filter').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#manageroffersform-resort').html(select_resort);
            getManagerOffersList();
        });
    });

    //manager offers list after change resort
    $(document).on('change', '#manageroffersform-resort', function(){
        getManagerOffersList();
    });

    //get manager offers list
    function getManagerOffersList(){
        var url = $('.ajax-get-manager-offers-list').attr('href');
        var data = $('#manager-offers-form').serialize();
        $('.manager-offers .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-offers .loader-bg').addClass('hide');
            console.log(data.model);
            if(data.status == 'ok') {
                $('#manager-offers-response .list-data').html(data.tours);
                $('.offers-tab.tab-badge.manager-offers').text(data.count);
            }else{
                $('#manager-offers-response .list-data').html(data.message);
                $('.offers-tab.tab-badge.manager-offers').text(data.count);
            }
        });
    }
});