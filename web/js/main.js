$(function(){
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
            ($(this).attr('id') == 'createhottourform-tour_cost') ||
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

    //open dropdown
    $('[data-toggle=dropdown]').dropdown();

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
        var tab_class = $(this).attr('data-tab-class');
        var hotel_id = $(this).attr('data-hotel-id');
        var url = $('.ajax-show-hotel-full-info').attr('href');
        $.get(url,{'hotel_id': hotel_id}).done(function(response){
            var data = $.parseJSON(response);
            $('.back-to-main[data-tab-class="'+tab_class+'"]').addClass('open');
            $('.back-to-main[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').removeClass('hide');
            $('.main-tab-container[data-tab-class="'+tab_class+'"]').addClass('implicit');
            if(data.status == 'ok'){
                $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                $('.full-hotel-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').attr('data-current-hotel', hotel_id).html(data.hotel);
            }else{
                $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                $('.full-hotel-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').text(data.message);
            }
        });
    });

    //show filter, hide hotel information
    $(document).on('click', '.back-to-main', function(e){
        e.preventDefault();
        var tab_class = $(this).attr('data-tab-class');
        $('.back-to-main[data-tab-class="'+tab_class+'"]').removeClass('open');
        $('.back-to-main[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').addClass('hide');
        //$('.filter-tour .left-data').removeClass('implicit');
        //$('.filter-tour .right-data').removeClass('col-xs-12').addClass('col-md-3');
        $('.full-hotel-information[data-tab-class="'+tab_class+'"]').addClass('close-tab').removeClass('open-tab').removeAttr('data-current-hotel').empty();
        //$('.right-data').show();
        $('.main-tab-container[data-tab-class="'+tab_class+'"]').removeClass('implicit');
    });

    //show hotel in tab if user did not close it, but switch on other tab
    $('a[role="tab"]').on('click', function(){
        var url = $('.ajax-show-hotel-full-info').attr('href');
        var tab = $(this).attr('aria-controls');
        //alert(tab);
        if(tab == 'create-tour'){
            tab_class = 'hot-tour';
        }else if(tab == 'tour-from-user'){
            tab_class = 'manager-response';
        }
        var tab_current_hotel = $('#'+tab+' .full-hotel-information').attr('data-current-hotel');
        if(typeof tab_current_hotel != 'undefined'){
            $.get(url,{'hotel_id': tab_current_hotel}).done(function(response){
                var data = $.parseJSON(response);
                $('.back-to-main[data-tab-class="'+tab_class+'"]').addClass('open');
                $('.back-to-main[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').removeClass('hide');
                $('.main-tab-container[data-tab-class="'+tab_class+'"]').addClass('implicit');
                if(data.status == 'ok'){
                    $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-hotel-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').attr('data-current-hotel', tab_current_hotel).html(data.hotel);
                }else{
                    $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-hotel-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').text(data.message);
                }
            });
        }
    });

});
