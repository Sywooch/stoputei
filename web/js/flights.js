$(function(){
    /*####################  FLIGHTS ##################*/
    //dropdown list with resorts for user after country change
    $(document).on('change', '#userflightform-destination', function(){
        var destination = ($(this).val() != '')?$(this).val():'all';
        $('.flight-container .loader-bg').removeClass('hide');
        var resort_url = $('.ajax-resort-for-filter').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            $('.flight-container .loader-bg').addClass('hide');
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#userflightform-resort').html(select_resort);
        });
    });

    $(document).on('change', '#managerflightform-depart_country_to', function(){
        var destination = $(this).val();
        $('.manager-flight-container .loader-bg').removeClass('hide');
        var resort_url = $('.ajax-resort').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-flight-container .loader-bg').addClass('hide');
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#managerflightform-depart_city_to').html(select_resort);
        });
    });

    $(document).on('change', '#managerflightform-voyage_direct_country_to', function(){
        var destination = $(this).val();
        $('.manager-flight-container .loader-bg').removeClass('hide');
        var resort_url = $('.ajax-resort').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-flight-container .loader-bg').addClass('hide');
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            console.log(select_resort);
            $('#managerflightform-voyage_direct_to_id').html(select_resort);
        });
    });

    $(document).on('change', '#managerflightform-voyage_direct_country_from', function(){
        var destination = $(this).val();
        $('.manager-flight-container .loader-bg').removeClass('hide');
        var resort_url = $('.ajax-resort').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-flight-container .loader-bg').addClass('hide');
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#managerflightform-voyage_direct_from_id').html(select_resort);
        });
    });

    //user flights request
    $(document).on('click', '#submit-flight', function(e){
        e.preventDefault();
        var url = $('#user-flight-form').attr('action');
        var data = $('#user-flight-form').serialize();
        $('.hotels-container .loader-bg').removeClass('hide');
        $.post(url,data).done(function(response){
            var data = $.parseJSON(response);
            $('.hotels-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data.popup);
                $('#modal-container .modal-content').html(data.popup);
                $('#modal-container').modal({backdrop: 'static', keyboard: false});
                $('#modal-container').modal('show');
            }else{
                console.log(data.model);
                $('.form-group .help-block').text('');
                for (var i in data.errors) {
                    $('.field-userflightform-'+i+' .help-block').text(data.errors[i]);
                    $('.field-userflightform-'+i).removeClass('has-success').addClass('has-error');
                }
            }
        });
    });

    //open user's tour with full information
    $(document).on('click', '.more-flight-info', function(e){
        e.preventDefault();
        var url = $('.ajax-user-flight-full-info').attr('href');
        var user_flight_id = $(this).attr('data-flight-id');
        $('.manager-flight-container .loader-bg').removeClass('hide');
        $(this).addClass('btn-success').removeClass('btn-primary');
        $('.more-flight-info').not(this).addClass('btn-primary').removeClass('btn-success');
        $.get(url, {'user_flight_id' : user_flight_id}).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-flight-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data);
                $('.right-data .main-data').hide();
                $('#right-data-response-flight').html(data.html);
                $('.more-flight-info[data-flight-id="'+user_flight_id+'"]').text(data.checked);
                $('.more-flight-info:not([data-flight-id="'+user_flight_id+'"])').text(data.unchecked);
                $('.create-flight').removeClass('inactive');
                $('.create-flight').html(data.form);
                $('a[href="#flights"]').text(data.tab_name);
                $('#create-flight-response').removeClass('inactive');
                $('[data-toggle="tooltip"]').tooltip();
            }else{
                $('#right-data-response').text(data.message);
            }
        });
    });

    //show and hide DIRECT VOYAGE TO through
    $(document).on('change', '#managerflightform-voyage_is_direct_to', function(){
        var is_checked = ($(this).attr('checked') == 'checked')?true:false;
        if(is_checked){
            $(this).removeAttr('checked');
            $('.voyage_is_direct_to').removeClass('hide');
        }else{
            $(this).attr('checked', 'checked');
            $('.voyage_is_direct_to').addClass('hide');
        }
    });

    //show and hide DIRECT VOYAGE FROM through
    $(document).on('change', '#managerflightform-voyage_is_direct_from', function(){
        var is_checked = ($(this).attr('checked') == 'checked')?true:false;
        if(is_checked){
            $(this).removeAttr('checked');
            $('.voyage_is_direct_from').removeClass('hide');
        }else{
            $(this).attr('checked', 'checked');
            $('.voyage_is_direct_from').addClass('hide');
        }
    });

    //way ticket switch
    $(document).on('change', '[name="ManagerFlightForm[way_ticket]"]', function(){
        var val = $(this).val();
        if(val == 2){
            $('.way_ticket_two').removeClass('hide');
        }else{
            $('.way_ticket_two').addClass('hide');
        }
    });

    //manager flights response
    $(document).on('click', '#create-flight-response', function(e){
        e.preventDefault();
        var url = $('#manager-flight-response-form').attr('action');
        var data = $('#manager-flight-response-form').serialize();
        $('.manager-flight-container .loader-bg').removeClass('hide');
        $.post(url,data).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-flight-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data.model);
                $('#modal-container .modal-content').html(data.popup);
                $('#modal-container').modal({backdrop: 'static', keyboard: false});
                $('#modal-container').modal('show');
            }else{
                console.log(data.model);
                $('.form-group .help-block').text('');
                for (var i in data.errors) {
                    $('.field-managerflightform-'+i+' .help-block').text(data.errors[i]);
                    $('.field-managerflightform-'+i).removeClass('has-success').addClass('has-error');
                }
            }
        });
    });

    //handling modal window USER FLIGHT (create one more)
    $(document).on('click', '.create-one-more-flight, .to-request-user-flight-list', function(){
        $('#user-flight-form').remove();
        var url = $('.ajax-empty-flight-form').attr('href');
        $('.flight-container .loader-bg').removeClass('hide');
        $.get(url).done(function(response){
            var data = $.parseJSON(response);
            $('.flight-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data.form);
                $('.flight-container').html(data.form);
            }else{

            }
        });
    });

    //load user's flight request and overwrite filter
    function returnToUserFlightList(){
        var url = $('.ajax-close-user-flight-full-info').attr('href');
        $('.manager-flight-container .loader-bg').removeClass('hide');
        $.get(url).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-flight-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                $('.right-data .main-data').show();
                $('.create-flight').addClass('inactive').empty().html(data.form);
                $('.user-flight-full-info').remove();
                $('#create-tour-response').addClass('inactive');
                $('#manager-flight-response').html(data.html);
                $('a[href="#flights"]').text(data.tab_name);
                $('#modal-container').modal('hide');
                $('[data-toggle="tooltip"]').tooltip();
            }else{
                $('#right-data-response').text(data.message);
            }
        });
    }

    $(document).on('click', '.close-flight-full-info, .to-request-flight-list-from-modal', function(){
        returnToUserFlightList();
    });


    //close user's tour with full information
    $(document).on('click', '.create-one-more-flight-response', function(){
        returnToUserRequestFlightList();
    });

    //load user's tours request and overwrite filter
    function returnToUserRequestFlightList(){
        var url = $('.ajax-create-one-more-manager-flight-response').attr('href');
        var data = $('#manager-flight-response-form').serialize();
        $('.manager-flight-container .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-flight-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                $('.create-flight').empty().html(data.form);
                $('a[href="#flights"]').text(data.tab_name);
                $('#create-flight-response').removeClass('inactive');
                $('[data-toggle="tooltip"]').tooltip();
            }else{
                $('#modal-container .modal-content').text(data.message);
            }
        });
    }

    //Voyage ONLY in one way
    $(document).on('change', '[name="UserFlightForm[way_ticket]"]', function(){
        var val = $(this).val();
        if(val == 1){
            $('#userflightform-date_city_from_since').val('').attr('disabled', true);
            $('#userflightform-date_city_from_until').val('').attr('disabled', true);
        }else{
            $('#userflightform-date_city_from_since').attr('disabled', false);
            $('#userflightform-date_city_from_until').attr('disabled', false);
        }
    });

    //dropdown list with countries
    $(document).on('change', '#userflightform-depart_country', function(){
        var destination = $(this).val();
        var resort_url = $('.ajax-resort').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#userflightform-depart_city').html(select_resort);
        });
    });

    //filter USER flight list
    function filterFlightList(){
        var url = $('.ajax-filter-flight-list').attr('href');
        var data = $('#user-flight-form').serialize();
        $('.flights-container .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.flights-container .loader-bg').addClass('hide');
            if(data.status == 'ok'){
                $('#flight-response').html(data.list);
                $('.badge.offers-tab.flights').text(data.count);
                console.log(data.model);
            }else{

                $('#flight-response').html(data.message);
                $('.badge.offers-tab.flights').text(data.count);
            }
        });
    }

    //change filter list after choose filter fields
    $(document).on('change', '#userflightform-destination', function(){
        filterFlightList();
    });
    $(document).on('change', '#userflightform-resort', function(){
        filterFlightList();
    });
    $(document).on('change', '#userflightform-depart_country', function(){
        filterFlightList();
    });
    $(document).on('change', '#userflightform-depart_city', function(){
        filterFlightList();
    });
    $(document).on('change', '#userflightform-date_city_to_since', function(){
        filterFlightList();
    });
    $(document).on('change', '#userflightform-date_city_to_until', function(){
        filterFlightList();
    });





    //show FLIGHT information, hide filter (USER)
    $(document).on('click', '.more-flight-response-info-user', function(e){
        e.preventDefault();
        var tab_class = $(this).closest('.main-tab-container').attr('data-tab-class');
        //var hotel_id = $(this).attr('data-flight-id');
        var url = $(this).attr('href');
        $.get(url).done(function(response){
            var data = $.parseJSON(response);
            $('.back-to-main-from-user-flight[data-tab-class="'+tab_class+'"]').addClass('open');
            $('.back-to-main-from-user-flight[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').removeClass('hide');
            $('.main-tab-container[data-tab-class="'+tab_class+'"]').addClass('implicit');
            if(data.status == 'ok'){
                $('.full-flights-information').removeClass('close-tab hide').addClass('open-tab').html(data.flight);
            }else{
                $('.full-flights-information').removeClass('close-tab').addClass('open-tab').text(data.message);
            }
        });
    });

    //show filter, hide flight information (USER)
    $(document).on('click', '.back-to-main-from-user-flight', function(e){
        e.preventDefault();
        var tab_class = $(this).attr('data-tab-class');
        $('.back-to-main-from-user-flight[data-tab-class="'+tab_class+'"]').removeClass('open');
        $('.back-to-main-from-user-flight[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').addClass('hide');
        $('.full-flights-information').addClass('close-tab hide').removeClass('open-tab');
        //$('.right-data').show();
        $('.main-tab-container[data-tab-class="'+tab_class+'"]').removeClass('implicit');
    });

});