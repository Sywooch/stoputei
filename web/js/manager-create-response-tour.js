$(function(){
//search list of hotels
    var getHotelListForResponseTour = function(){
        var url = $('.ajax-hot-tour-hotel-list').attr('href');
        var data = $('#manager-tour-response-form').serialize();
        url = url+'?filter_type=manager-response';
        $('.user-tour-container .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.user-tour-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data.message);
                $('#user-tour-response .list-data').html(data.html);
                $('.offers-tab.tab-badge.get-tour').text(data.count);
            }else{
                $('#user-tour-response .list-data').text(data.message);
                $('.offers-tab.tab-badge.get-tour').text(data.count);
            }
        });
    }

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
                getHotelListForResponseTour();
            }else{
            }
        });
    });


    //choose filed from autocomplete
    $(document).on('click', '#createtourform-hotel_id', function(){
        var hotel_id = $(this).val();
        var hotel_name = $('#createtourform-hotel_id option:selected').text();
        $('#createtourform-hotel').val(hotel_name);
        if(hotel_name.length > 20) {
            $('#createtourform-hotel').attr('data-toggle', 'tooltip').attr('title', hotel_name).attr('data-original-title', hotel_name);
            $('[data-toggle="tooltip"]').tooltip();
        }
        $(this).hide();
        getHotelListForResponseTour();
    });

    //remove hotel name from hotel-name field
    $(document).on('click', '.remove-hotel-name-manager', function(){
        $('#createtourform-hotel_id').val('');
        $('#createtourform-hotel').val('').removeAttr('data-toggle title data-original-title');
        getHotelListForResponseTour();
    });


    $(document).on('click', '.wrap', function(){
        $('#createtourform-hotel_id').hide();
    });


    //Add hotel to filter by USER or MANAGER
    $(document).on('click', '#user-tour-response .add-to-filter.manager-response', function(e){
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
            getHotelListForResponseTour();
        }
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
                $('#user-tour-response .list-data').html(data.html);
                $('.offers-tab.tab-badge').text(data.count);
                $('[data-toggle="tooltip"]').tooltip();
            }else{
                $('#user-tour-response .list-data').text(data.message);
                $('.offers-tab.tab-badge').text(data.count);
            }
        });
    }

    //open user's tour with full information
    $(document).on('click', '.tour-more-info', function(){
        var url = $('.ajax-user-tour-full-info').attr('href');
        var user_tour_id = $(this).attr('data-tour-id');
        var filter_type = $(this).attr('data-filter-type');
        url = url+'?filter_type=manager-response';
        $('.user-tour-container .loader-bg').removeClass('hide');
        $.get(url, {'user_tour_id' : user_tour_id}).done(function(response){
            var data = $.parseJSON(response);
            $('.user-tour-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data);
                $('.right-data .main-data').hide();
                $('#right-data-response').html(data.html);
                $('a[href="#tour-from-user"]').text(data.tab_name);
                $('#user-tour-response .list-data').empty().html(data.hotels);
                $('[data-toggle="tooltip"]').tooltip();
                $('.create-tour').removeClass('inactive').empty().html(data.form);
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
                $('#user-tour-response .list-data').html(data.html);
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
            $('#createtourform-visa').attr('disabled', false);
            $('#createtourform-oil_tax').attr('disabled', false);
        }else{
            $(this).attr('checked', 'checked');
            $('.add-payment').removeClass('hide');
            $('#createtourform-visa').val('').attr('disabled', true);
            $('#createtourform-oil_tax').val('').attr('disabled', true);
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



    $(document).on('change', '#createtourform-letter_filter [name="CreateTourForm[letter_filter][]"]', function(){
        $(this).closest('.checkbox-one').toggleClass('active');
        getHotelListForResponseTour();
    });

});