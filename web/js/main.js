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

    //Allow only numbers in number input
    $(document).on('keydown', '[type="number"]', function(e){
        var val = $(this).val();
        if(($(this).attr('id') == 'gettourform-budget') ||
            ($(this).attr('id') == 'touroffersform-budget') ||
            ($(this).attr('id') == 'createtourform-tour_cost')){
            if(val.length > 7){
                $(this).val(val.slice(0,-1));
            }
            if(val > 99000000){
                $(this).val(99000000);
            }
        }else if(($(this).attr('id') == 'managerflightform-flight_cost') ||
            ($(this).attr('id') == 'createhottourform-visa') ||
            ($(this).attr('id') == 'createtourform-visa') ||
            ($(this).attr('id') == 'createtourform-oil_tax') ||
            ($(this).attr('id') == 'createhottourform-oil_tax')){
            if(val.length > 4){
                $(this).val(val.slice(0,-1));
            }
            if(val > 99000){
                $(this).val(99000);
            }
        }else if(val.length > 1){
            $(this).val(val.slice(0,-1));
        }
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

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
