$(function(){
    $(document).on('change', '.widget-tour-stat-manager select', function(){
        var value = $(this).val();
        var type = $(this).closest('.select-field').attr('data-type');
        var url = $('.ajax-manager-tour-stat-destination').attr('href');
        var data = $(this).closest('.widget-tour-stat-manager').serialize();
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            if(data.status == 'ok'){
                $('.select-field[data-type="'+type+'"] select').val(value);
                $('.field-managerstatisticstourform-country_id .value-field').text(data.count_all);
                $('.field-managerstatisticstourform-request_tour_count .value-field').text(data.count_requests);
                $('.field-managerstatisticstourform-response_tour_count .value-field').text(data.count_responses);
                $('.field-managerstatisticstourform-hot_tour_count .value-field').text(data.count_hot_tours);
            }else{
                console.log(data);
            }
        });
    });

    $(document).on('change', '.widget-flight-stat-manager select', function(){
        var value = $(this).val();
        var type = $(this).closest('.select-field').attr('data-type');
        var url = $('.ajax-manager-flight-stat-destination').attr('href');
        var data = $(this).closest('.widget-flight-stat-manager').serialize();
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            if(data.status == 'ok'){
                $('.select-field[data-type="'+type+'"] select').val(value);
                $('.field-managerstatisticsflightform-country_id .value-field').text(data.count_all);
                $('.field-managerstatisticsflightform-request_flight_count .value-field').text(data.count_requests);
                $('.field-managerstatisticsflightform-response_flight_count .value-field').text(data.count_responses);
            }else{
                console.log(data);
            }
        });
    });
});