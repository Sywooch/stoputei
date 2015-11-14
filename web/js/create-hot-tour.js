$(function(){
//search list of hotels
    var getHotelListForHotTour = function(){
        var url = $('.ajax-hot-tour-hotel-list').attr('href');
        var data = $('#manager-hot-tour-create-form').serialize();
        url = url+'?filter_type=hot-tour';
        $('.manager-hot-tour-container .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-hot-tour-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                $('#create-hot-tour-response').html(data.html);
                $('.offers-tab.tab-badge.create-hot-tour').text(data.count);
                //imagePreview();
            }else{
                $('#create-hot-tour-response').text(data.message);
                $('.offers-tab.tab-badge.create-hot-tour').text(data.count);
            }
        });
    }

    var autocomplete_url_manager = $('.ajax-hotel-autocomplete-manager').attr('href');
    $(document).on('input', '#createhottourform-hotel', function(){
        var country_id = $('#createhottourform-destination').val();
        var resort_id = $('#createhottourform-resort').val();
        var query = $('#createhottourform-hotel').val();
        var url = autocomplete_url_manager+'?country_id='+country_id+'&resort_id='+resort_id+'&query='+query;
        $.get(url).done(function(response){
            var data = $.parseJSON(response);
            console.log(data.status);
            $('.manager-hot-tour-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                var list_hotels = '';
                for (var i in data.hotels) {
                    list_hotels += '<option value="'+data.hotels[i].hotel_id+'">'+data.hotels[i].hotel_name+'</option>';
                }
                $('#createhottourform-hotel_id').html(list_hotels).show();
                getHotelListForHotTour();
            }else{
            }
        });
    });


    //choose filed from autocomplete
    $(document).on('click', '#createhottourform-hotel_id', function(){
        var hotel_id = $(this).val();
        var hotel_name = $('#createhottourform-hotel_id option:selected').text();
        $('#createhottourform-hotel').val(hotel_name);
        if(hotel_name.length > 20) {
            $('#createhottourform-hotel').attr('data-toggle', 'tooltip').attr('title', hotel_name).attr('data-original-title', hotel_name);
            $('[data-toggle="tooltip"]').tooltip();
        }
        $(this).hide();
        offFilterFileds();
        getHotelListForHotTour();
    });

    //remove hotel name from hotel-name field
    $(document).on('click', '.remove-hotel-hot-tour', function(){
        onFilterFileds();
        getHotelListForHotTour();
    });


    $(document).on('click', '.wrap', function(){
        $('#createhottourform-hotel_id').hide();
    });

    //dropdown list with user's tour for manager after country change
    $(document).on('change', '#createhottourform-destination', function(){
        var destination = $(this).val();
        var resort_url = $('.ajax-resort').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#createhottourform-resort').html(select_resort);
            getHotelListForHotTour();
        });
    });

    //dropdown list with depart city if FLIGHT INCLUDED
    $(document).on('change', '#createhottourform-depart_country_to', function(){
        var destination = $(this).val();
        var resort_url = $('.ajax-resort').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#createhottourform-depart_city_there').html(select_resort);
            $('#createhottourform-voyage_through_city_there').html(select_resort);
        });
    });

    //dropdown list with depart city if FLIGHT INCLUDED
    $(document).on('change', '#createhottourform-depart_country_from', function(){
        var destination = $(this).val();
        var resort_url = $('.ajax-resort').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#createhottourform-depart_city_from_there').html(select_resort);
            $('#createhottourform-voyage_through_city_from_there').html(select_resort);
        });
    });

    //dropdown list with user's tour for manager after resort change
    $(document).on('change', '#createhottourform-resort', function(){
        getHotelListForHotTour();
    });

    //dropdown list with user's tour for manager after resort change
    $(document).on('change', '#createhottourform-stars', function(){
        getHotelListForHotTour();
    });


    //show and hide FLIGHT INCLUDED
    $(document).on('change', '#createhottourform-flight_included', function(){
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
    $(document).on('change', '#createhottourform-voyage_there', function(){
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
    $(document).on('change', '#createhottourform-voyage_from_there', function(){
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
    $(document).on('change', '#createhottourform-add_payment', function(){
        var is_checked = ($(this).attr('checked') == 'checked')?true:false;
        if(is_checked){
            $(this).removeAttr('checked');
            $('.add-payment').addClass('hide');
            $('#createhottourform-visa').attr('disabled', false);
            $('#createhottourform-oil_tax').attr('disabled', false);
        }else{
            $(this).attr('checked', 'checked');
            $('.add-payment').removeClass('hide');
            $('#createhottourform-visa').val('').attr('disabled', true);
            $('#createhottourform-oil_tax').val('').attr('disabled', true);
        }
    });

    //Manager HOT tour response submit
    $(document).on('click', '#create-hot-tour', function(e){
        e.preventDefault();
        var url = $('#manager-hot-tour-create-form').attr('action');
        //unmask
        $('[name="CreateHotTourForm[tour_cost]"]').val(parseInt(( $('#createhottourform-tour_cost').val().replace(/ /g,'').replace(/_/g,'')  )));
        var data = $('#manager-hot-tour-create-form').serialize();
        $('.manager-hot-tour-container .loader-bg').removeClass('hide');
        $.post(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.manager-hot-tour-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data.popup);
                if($('#manager-hot-tours-response .list-data .user-tour-wrapper').length > 0) {
                    $('#manager-hot-tours-response .list-data .user-tour-wrapper:first').before(data.tour);
                }else{
                    $('#manager-hot-tours-response .list-data').html(data.tour);
                }
                $('.badge.offers-tab.manager-hot-tours').text(data.count);
                $('#modal-container .modal-content').html(data.popup);
                $('#modal-container').modal({backdrop: 'static', keyboard: false});
                $('#modal-container').modal('show');
            }else{
                console.log(data.model);
                $('.form-group .help-block').text('');
                $('.field-createhottourform-'+i).removeClass('has-success has-error');
                for (var i in data.errors) {
                    $('.field-createhottourform-'+i+' .help-block').text(data.errors[i]);
                    $('.field-createhottourform-'+i).removeClass('has-success').addClass('has-error');
                }
            }
        });
    });

    //handling modal
    $(document).on('click', '.create-one-more-hot-tour', function(){
        var url = $('.ajax-create-one-more-hot-tour').attr('href');
        $('[id*="createhottourform"]').val('');
        $('[id*="createhottourform"] [type="radio"]:checked').attr('checked', false);
        $('[id*="createhottourform"] [type="checkbox"]:checked').attr('checked', false);
        $('#createhottourform-is_hot_tour').val(1);
        $('[name="CreateHotTourForm[flight_included]"]').removeAttr('checked');
        $('.hot-tour.flight-included').addClass('hide');
        $('.badge.tab-badge.create-hot-tour').text('0');
        $('[class*="field-createhottourform"]').removeClass('has-success has-error');
        $('[class*="field-createhottourform"] .help-block').text('');
        $('#create-hot-tour-response').empty();
    });

    //add hotel name to filter
    $(document).on('click', '#create-hot-tour-response .add-to-filter.hot-tour', function(e){
        e.preventDefault();
        var hotel_id = $(this).attr('data-hotel-id');
        var hotel_name = $(this).attr('data-hotel-name');
        var hotel_star = $(this).attr('data-hotel-star');
        var option = '<option value="'+hotel_id+'">'+hotel_name+'</option>';
            $('#createhottourform-hotel_id').html(option);
            $("#createhottourform-hotel_id option").filter(function () {
                return $(this).val() == hotel_id;
            }).attr('selected', true);
            $('#createhottourform-hotel').val(hotel_name);
        offFilterFileds(hotel_star);
            getHotelListForHotTour();
    });

    $(document).on('change', '#createhottourform-letter_filter [name="CreateHotTourForm[letter_filter][]"]', function(){
        $(this).closest('.checkbox-one').toggleClass('active');
        getHotelListForHotTour();
    });

    function offFilterFileds(hotel_star){
        $('.field-createhottourform-stars').addClass('disabled');
        $('#createhottourform-stars [name="CreateHotTourForm[stars][]"]').attr('disabled', true).prop('checked', false);
        $('#createhottourform-stars [name="CreateHotTourForm[stars][]"]').filter(function () {
            return $(this).val() == hotel_star;
        }).prop('checked', true);
    }

    function onFilterFileds(){
        $('#createhottourform-hotel_id').val('');
        $('#createhottourform-hotel').val('').removeAttr('data-toggle title data-original-title');
        $('.field-createhottourform-stars').removeClass('disabled');
        $('#createhottourform-stars [name="CreateHotTourForm[stars][]"]').removeAttr('disabled');
        $('#createhottourform-stars [name="CreateHotTourForm[stars][]"]').prop('checked', false);
    }

});