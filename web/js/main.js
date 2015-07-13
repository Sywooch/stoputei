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
    $('.hotels-container, .user-tour-container, .create-tour').css('max-height', windowH+'px');

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
    $('#gettourform-destination').on('change', function(){
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
    $('#gettourform-resort').on('change', function(){
        getHotelList();
    });

    //get a tour on ajax(stars)
    $('#gettourform-stars .checkbox').on('change', function(){
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
                $('.offers-tab.tab-badge').text(data.count);
            }else{
                $('#hotel-response').text(data.message);
                $('.offers-tab.tab-badge').text(data.count);
            }
        });
    }

    //create route to autocomplete
    var autocomplete_url = $('.ajax-hotel-autocomplete').attr('href');
    $('#gettourform-hotel').on('input', function(){
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
    $('#gettourform-hotel_id').on('click', function(){
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
            $('#createtourform-hotel_id').val(hotel_id);
            $('#createtourform-hotel').val(hotel_name);
        }else {
            $('#gettourform-hotel_id').html(option);
            $("#gettourform-hotel_id option").filter(function () {
                return $(this).val() == hotel_id;
            }).attr('selected', true);
            $('#gettourform-hotel').val(hotel_name);
        }
    });

    $('#submit-tour').on('click', function(e){
        e.preventDefault();
        var url = $('#get-tour-form').attr('action');
        var data = $('#get-tour-form').serialize();
        $('.hotels-container .loader-bg').removeClass('hide');
        $.post(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.hotels-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data.message);
                $('#modal-container .modal-content').text(data.message);
                $('#modal-container').modal('show');
            }else{
                $('.form-group .help-block').text('');
                for (var i in data.errors) {
                    $('.field-gettourform-'+i+' .help-block').text(data.errors[i]);
                    $('.field-gettourform-'+i).removeClass('has-success').addClass('has-error');
                }
            }
        });
    })

    //dropdown list with user's tour for manager after country change
    $('#createtourform-destination').on('change', function(){
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
    $('#createtourform-resort').on('change', function(){
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

});
