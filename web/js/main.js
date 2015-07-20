$(function(){

    //Google map
    /*function initialize_google_map(latitude, longitude) {
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: 2,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(mapCanvas, mapOptions);
    }
    google.maps.event.addDomListener(window, 'load', initialize_google_map);*/

    //initialize tooltip
    $('[data-toggle="tooltip"]').tooltip();

    //set workplace height
    var windowH = $(window).height();
    $('.overflow-list').css('max-height', windowH+'px');

    //country dropdown REGISTRATION
    $('#registrationform-country').on('change', function(){
        var country_id = $(this).val();
        var region_url = $('.get-city-dropdown').attr('href');
        $.get(region_url,{'country_id':country_id}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#registrationform-region_id').html(select_resort);
        });
    });
    //switch between user roles in registration
    $('#registrationform-role').on('change', function(){
        var role = $('[name="RegistrationForm[role]"]:checked').val();
        if(role == 1){
            $('[name="RegistrationForm[consent]"]').removeAttr('checked').val(0);
            $('.user-radio').removeClass('hidden');
            $('.radio-wrapper.left').find('.icon').addClass('glyphicon-check').removeClass('glyphicon-unchecked');
            $('.radio-wrapper.right').find('.icon').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
            $('.manager-radio').addClass('hidden');
        }else if(role == 2){
            $('[name="RegistrationForm[consent]"]').attr('checked','checked').val(1);
            $('.user-radio').addClass('hidden');
            $('.radio-wrapper.left').find('.icon').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
            $('.radio-wrapper.right').find('.icon').addClass('glyphicon-check').removeClass('glyphicon-unchecked');
            $('.manager-radio').removeClass('hidden');
        }
    });

    //consent in registration
    $('#registrationform-consent').on('click', function(){
        var is_checked = ($('[name="RegistrationForm[consent]').attr('checked') == 'checked')?true:false;
        if(is_checked){
            $('[name="RegistrationForm[consent]').removeAttr('checked');
            $('[name="RegistrationForm[consent]"]').val(0);
        }else{
            $('[name="RegistrationForm[consent]"]').val(1);
            $('[name="RegistrationForm[consent]').attr('checked', 'checked');
        }
    });

    //get a tour on ajax(destination)
    $(document).on('change', '#gettourform-destination', function(){
        var destination = $(this).val();
        var resort_url = $('.ajax-resort').attr('href');
        $('#gettourform-hotel_id').html('');
        $('#gettourform-hotel').val('');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#gettourform-resort').html(select_resort);
            getHotelList();
        });
    });

    //get a tour on ajax(resort)
    $(document).on('change', '#gettourform-resort', function(){
        getHotelList();
    });

    //get a tour on ajax(stars)
    $(document).on('change', '#gettourform-stars .checkbox', function(){
        getHotelList();
    });

    //search list of hotels
    var getHotelList = function(){
        var url = $('.ajax-tour-list').attr('href');
        var data = $('#get-tour-form').serialize();
        $('.hotels-container .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.hotels-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                $('#hotel-response').html(data.html);
                $('.offers-tab.tab-badge.get-tour').text(data.count);
            }else{
                $('#hotel-response').text(data.message);
                $('.offers-tab.tab-badge.get-tour').text(data.count);
            }
        });
    }

    //create route to autocomplete
    var autocomplete_url = $('.ajax-hotel-autocomplete').attr('href');
    $(document).on('input', '#gettourform-hotel', function(){
        var country_id = $('#gettourform-destination').val();
        var city_id = $('#gettourform-resort').val();
        var query = $('#gettourform-hotel').val();
        var url = autocomplete_url+'?country_id='+country_id+'&query='+query;
        $.get(url).done(function(response){
            var data = $.parseJSON(response);
            $('.hotels-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                var list_hotels = '';
                for (var i in data.hotels) {
                    list_hotels += '<option value="'+data.hotels[i].hotel_id+'">'+data.hotels[i].hotel_name+'</option>';
                }
                $('#gettourform-hotel_id').html(list_hotels).show();
            }else{
            }
        });
    });

    var autocomplete_url_manager = $('.ajax-hotel-autocomplete-manager').attr('href');
    $(document).on('input', '#createtourform-hotel', function(){
        var country_id = $('#createtourform-destination').val();
        var resort_id = $('#createtourform-resort').val();
        var query = $('#createtourform-hotel').val();
        var url = autocomplete_url_manager+'?country_id='+country_id+'&resort_id='+resort_id+'&query='+query;
        $.get(url).done(function(response){
            var data = $.parseJSON(response);
            $('.hotels-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                var list_hotels = '';
                for (var i in data.hotels) {
                    list_hotels += '<option value="'+data.hotels[i].hotel_id+'">'+data.hotels[i].hotel_name+'</option>';
                }
                $('#createtourform-hotel_id').html(list_hotels).show();
            }else{
            }
        });
    });

    //choose filed from autocomplete
    $(document).on('click', '#gettourform-hotel_id', function(){
       var hotel_id = $(this).val();
       var hotel_name = $('#gettourform-hotel_id option:selected').text();
        $('#gettourform-hotel').val(hotel_name);
        $(this).hide();
        getHotelList();
    });
    //choose filed from autocomplete
    $(document).on('click', '#createtourform-hotel_id', function(){
        var hotel_id = $(this).val();
        var hotel_name = $('#createtourform-hotel_id option:selected').text();
        $('#createtourform-hotel').val(hotel_name);
        $(this).hide();
    });

    //remove hotel name from hotel-name field
    $('.field-gettourform-hotel .remove-hotel-name').on('click', function(){
        $('#gettourform-hotel_id').val('');
        $('#gettourform-hotel').val('');
        getHotelList();
    });
    //remove hotel name from hotel-name field
    $(document).on('click', '.remove-hotel-name-manager', function(){
        $('#createtourform-hotel_id').val('');
        $('#createtourform-hotel').val('');
    });

    $('.filter').on('click', function(){
        $('#gettourform-hotel_id').hide();
    });
    $(document).on('click', '.wrap', function(){
        $('#createtourform-hotel_id').hide();
    });

    //show hotel information, hide filter
    $(document).on('click', '.more-hotel-info', function(e){
        e.preventDefault();
        var hotel_id = $(this).attr('data-hotel-id');
        $('.back-to-main').addClass('open');
        $('.back-to-main .glyphicon-menu-right').removeClass('hide');
        $('.filter-tour .left-data').addClass('implicit');
        $('.filter-tour .right-data').addClass('col-xs-12').removeClass('col-md-3');
        $('.right-data').hide();
        $('.full-hotel-information').removeClass('hide').text('HOTEL FULL INFORMATION');
    });

    //show filter, hide hotel information
    $(document).on('click', '.back-to-main', function(e){
        e.preventDefault();
        $('.back-to-main').removeClass('open');
        $('.back-to-main .glyphicon-menu-right').addClass('hide');
        $('.filter-tour .left-data').removeClass('implicit');
        $('.filter-tour .right-data').removeClass('col-xs-12').addClass('col-md-3');
        $('.full-hotel-information').addClass('hide');
        $('.right-data').show();
    });

    //Add hotel to filter by USER or MANAGER
    $(document).on('click', '.add-to-filter', function(e){
        e.preventDefault();
        var hotel_id = $(this).attr('data-hotel-id');
        var hotel_name = $(this).attr('data-hotel-name');
        var option = '<option value="'+hotel_id+'">'+hotel_name+'</option>';
        if($(this).hasClass('manager')){
            $('#createtourform-hotel_id').html(option);
            $("#createtourform-hotel_id option").filter(function () {
                return $(this).val() == hotel_id;
            }).attr('selected', true);
            $('#createtourform-hotel').val(hotel_name);
        }else {
            $('#gettourform-hotel_id').html(option);
            $("#gettourform-hotel_id option").filter(function () {
                return $(this).val() == hotel_id;
            }).attr('selected', true);
            $('#gettourform-hotel').val(hotel_name);
        }
    });

    $(document).on('click', '#submit-tour', function(e){
        e.preventDefault();
        var url = $('#get-tour-form').attr('action');
        var data = $('#get-tour-form').serialize();
        $('.hotels-container .loader-bg').removeClass('hide');
        $.post(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.hotels-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data.message);
                $('#modal-container .modal-content').html(data.popup);
                $('#modal-container').modal({backdrop: 'static', keyboard: false});
                $('#modal-container').modal('show');
            }else{
                $('.form-group .help-block').text('');
                for (var i in data.errors) {
                    $('.field-gettourform-'+i+' .help-block').text(data.errors[i]);
                    $('.field-gettourform-'+i).removeClass('has-success').addClass('has-error');
                }
            }
        });
    });

    //handling modal window USER TOUR
    $(document).on('click', '.create-one-more-tour', function(){
        $('#get-tour-form').remove();
        var url = $('.ajax-empty-tour-form').attr('href');
        $('.hotels-container .loader-bg').removeClass('hide');
        $.get(url).done(function(response){
            var data = $.parseJSON(response);
            $('.hotels-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data.form);
                $('.tour-container').html(data.form);
                $('#hotel-response').empty();
                $('.tab-badge.get-tour').text('0');
            }else{

            }
        });
    });

    //dropdown list with user's tour for manager after country change
    $(document).on('change', '#createtourform-destination', function(){
        var destination = $(this).val();
        var resort_url = $('.ajax-resort').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#createtourform-resort').html(select_resort);
            getUserTourList();
        });
    });

    //dropdown list with user's tour for manager after resort change
    $(document).on('change', '#createtourform-resort', function(){
        getUserTourList();
    });

    //search list of users's tour
    var getUserTourList = function(){
        var url = $('.ajax-user-tour-list').attr('href');
        var data = $('#create-tour-form').serialize();
        $('.hotels-container .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.hotels-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                $('#user-tour-response').html(data.html);
                $('.offers-tab.tab-badge').text(data.count);
            }else{
                $('#user-tour-response').text(data.message);
                $('.offers-tab.tab-badge').text(data.count);
            }
        });
    }

    //open user's tour with full information
    $(document).on('click', '.tour-more-info', function(){
        var url = $('.ajax-user-tour-full-info').attr('href');
        var user_tour_id = $(this).attr('data-tour-id');
        $('.user-tour-container .loader-bg').removeClass('hide');
        $.get(url, {'user_tour_id' : user_tour_id}).done(function(response){
            var data = $.parseJSON(response);
            $('.user-tour-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data);
                $('.right-data .main-data').hide();
                $('#right-data-response').html(data.html);
                $('.create-tour').removeClass('inactive');
                $('.create-tour').html(data.form);
                $('a[href="#tour-from-user"]').text(data.tab_name);
                $('#user-tour-response').html(data.hotels);
                $('#create-tour-response').removeClass('inactive');
                $('[data-toggle="tooltip"]').tooltip();
            }else{
                $('#right-data-response').text(data.message);
            }
        });
    });

    //close user's tour with full information
    $(document).on('click', '.close-tour-full-info', function(){
        returnToUserTourList();
    });

    //load user's tour request and overwrite filter
    function returnToUserTourList(){
        var url = $('.ajax-user-tour-request').attr('href');
        $('.user-tour-container .loader-bg').removeClass('hide');
        $.get(url).done(function(response){
            var data = $.parseJSON(response);
            $('.user-tour-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                $('.right-data .main-data').show();
                $('.create-tour').addClass('inactive').empty().html(data.form);
                $('.user-tour-full-info').remove();
                $('#create-tour-response').addClass('inactive');
                $('#user-tour-response').html(data.html);
                $('a[href="#tour-from-user"]').text(data.tab_name);
                $('#modal-container').modal('hide');
                $('[data-toggle="tooltip"]').tooltip();
            }else{
                $('#right-data-response').text(data.message);
            }
        });
    }

    //load user's tours request and overwrite filter
    function returnToUserRequestTourList(){
        var url = $('.ajax-create-one-more-manager-response').attr('href');
        var data = $('#manager-tour-response-form').serialize();
        $('.user-tour-container .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.user-tour-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                $('.create-tour').empty().html(data.form);
                $('a[href="#tour-from-user"]').text(data.tab_name);
                $('#create-tour-response').removeClass('inactive');
                $('[data-toggle="tooltip"]').tooltip();
            }else{
                $('#modal-container .modal-content').text(data.message);
            }
        });
    }

    $(document).on('click', '.create-one-more-manager-response', function(){
        returnToUserRequestTourList();
    });



    //show and hide FLIGHT INCLUDED
    $(document).on('change', '#createtourform-flight_included', function(){
        var is_checked = ($(this).attr('checked') == 'checked')?true:false;
        if(is_checked){
            $(this).removeAttr('checked');
            $('.flight-included').addClass('hide');
        }else{
            $(this).attr('checked', 'checked');
            $('.flight-included').removeClass('hide');
        }
    });

    //show and hide VOYAGE through
    $(document).on('change', '#createtourform-voyage_there', function(){
        var is_checked = ($(this).attr('checked') == 'checked')?true:false;
        if(is_checked){
            $(this).removeAttr('checked');
            $('.voyage_through_there').removeClass('hide');
        }else{
            $(this).attr('checked', 'checked');
            $('.voyage_through_there').addClass('hide');
        }
    });

    //show and hide VOYAGE FROM through
    $(document).on('change', '#createtourform-voyage_from_there', function(){
        var is_checked = ($(this).attr('checked') == 'checked')?true:false;
        if(is_checked){
            $(this).removeAttr('checked');
            $('.voyage_through_from_there').removeClass('hide');
        }else{
            $(this).attr('checked', 'checked');
            $('.voyage_through_from_there').addClass('hide');
        }
    });

    //Show hide ADD PAYMENT
    $(document).on('change', '#createtourform-add_payment', function(){
        var is_checked = ($(this).attr('checked') == 'checked')?true:false;
        if(is_checked){
            $(this).removeAttr('checked');
            $('.add-payment').addClass('hide');
        }else{
            $(this).attr('checked', 'checked');
            $('.add-payment').removeClass('hide');
        }
    });

    //Manager tour response submit
    $(document).on('click', '#create-tour-response', function(e){
        e.preventDefault();
        var url = $('#manager-tour-response-form').attr('action');
        var data = $('#manager-tour-response-form').serialize();
        $('.hotels-container .loader-bg').removeClass('hide');
        $.post(url, data).done(function(response){
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
                    $('.field-createtourform-'+i+' .help-block').text(data.errors[i]);
                    $('.field-createtourform-'+i).removeClass('has-success').addClass('has-error');
                }
            }
        });
    });


    $(document).on('click', '.to-request-list', function(){
        returnToUserTourList();
    });


    /*####################  FLIGHTS ##################*/
    //dropdown list with resorts for user after country change
    $(document).on('change', '#userflightform-destination', function(){
        var destination = $(this).val();
        $('.flight-container .loader-bg').removeClass('hide');
        var resort_url = $('.ajax-resort').attr('href');
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
    $(document).on('click', '.more-flight-info', function(){
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




    //##################### USER OFFERS ######################
    //filter user's offers
    $(document).on('change', '#touroffersform-destination', function(){
        var destination = $(this).val();
        var resort_url = $('.ajax-resort').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#touroffersform-resort').html(select_resort);
            getUserOffersList();
        });
    });

    //search list of hotels in offers
    var getUserOffersList = function(){
        var url = $('.ajax-get-offers-list').attr('href');
        var data = $('#user-offers-tour-form').serialize();
        $('.user-offer-list .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.user-offer-list .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data.tours);
                console.log(data.model);
                $('#user-tour-response-list').html(data.tours);
                $('.offers-tab.tab-badge.user-offers').text(data.count);
            }else{
                $('#user-tour-response-list').html(data.message);
                //$('.offers-tab.tab-badge.user-offers').text(data.count);
            }
        });
    }

    $(document).on('click', '#touroffersform-resort', function(){
        getUserOffersList();
    });
    $(document).on('change', '#touroffersform-night_count', function(){
        getUserOffersList();
    });
    $(document).on('click', '#touroffersform-from_date', function(){
        getUserOffersList();
    });
    $(document).on('click', '#touroffersform-to_date', function(){
        getUserOffersList();
    });
    $(document).on('change', '#touroffersform-depart_city', function(){
        getUserOffersList();
    });

    var autocomplete_url_manager = $('.ajax-hotel-autocomplete-offer').attr('href');
    $(document).on('input', '#touroffersform-hotel', function(){
        var country_id = $('#touroffersform-destination').val();
        var resort_id = $('#touroffersform-resort').val();
        var query = $('#touroffersform-hotel').val();
        var url = autocomplete_url_manager+'?country_id='+country_id+'&resort_id='+resort_id+'&query='+query;
        $.get(url).done(function(response){
            var data = $.parseJSON(response);
            $('.user-offer-list .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                var list_hotels = '';
                for (var i in data.hotels) {
                    list_hotels += '<option value="'+data.hotels[i].hotel_id+'">'+data.hotels[i].hotel_name+'</option>';
                }
                $('#touroffersform-hotel_id').html(list_hotels).show();
            }else{
            }
        });
    });

    //choose filed from autocomplete for offers
    $(document).on('click', '#touroffersform-hotel_id', function(){
        var hotel_id = $(this).val();
        var hotel_name = $('#touroffersform-hotel_id option:selected').text();
        $('#touroffersform-hotel').val(hotel_name);
        $(this).hide();
        getUserOffersList();
    });

    //clear hotel name user offers
    $(document).on('click' ,'.field-touroffersform-hotel .remove-hotel-name', function(){
        $('#touroffersform-hotel').val('');
        $('#touroffersform-hotel_id').val('');
        getUserOffersList();
    });
});
