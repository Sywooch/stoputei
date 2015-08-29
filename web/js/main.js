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
    $(document).on('click', '.more-hotel-info-manager', function(e){
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
                $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                $('.full-hotel-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').attr('data-current-hotel', hotel_id).html(data.hotel);
            }else{
                $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
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
    $('.manager a[role="tab"].hotel').on('click', function(){
        var url = $('.ajax-show-hotel-full-info').attr('href');
        var tab = $(this).attr('aria-controls');
        //alert(tab);
        if(tab == 'create-tour'){
            tab_class = 'hot-tour';
        }else if(tab == 'tour-from-user'){
            tab_class = 'manager-response';
        }else{
            tab_class = '';
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
                    $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-hotel-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').attr('data-current-hotel', tab_current_hotel).html(data.hotel);
                }else{
                    $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-hotel-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').text(data.message);
                }
            });
        }
    });

    //order tour list
    $(document).on('change', '[name="order-tour-list"]', function(){
        var value = $(this).val();
        var container_id = $(this).closest('div').attr('id');
        var type = $(this).attr('data-type');
        alert(type);
        $(this).closest('.loader-bg').removeClass('hide');
        var data = [];
            $('#'+container_id+' .user-tour-wrapper').each(function(){
                data.push($(this).attr('data-tour-id'));
            });
        var url = $('.ajax-order-tours-list').attr('href');
        $.get(url, {'ids': data, 'order_by': value, 'type': type}).done(function(response){
            $(this).closest('.loader-bg').addClass('hide');
            var data = $.parseJSON(response);
            if(data.status == 'ok'){
                $('#'+container_id+' .list-data').html(data.tourList);
            }else{
                $('#'+container_id+' .list-data').text(data.message);
            }
        });
    });

    //show full tour info
    $(document).on('click', '.tour-full-info-user', function(e){
        e.preventDefault();
        var url = $('.ajax-tour-full-info').attr('href');
        var tour_id = $(this).attr('data-tour-id');
        var main_container = $(this).closest('.main-tab-container');
        var tab_class = main_container.attr('data-tab-class');
        main_container.closest('[name="order-tour-list"]').hide();
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .order-list').addClass('hidden-select');
        //clear tour full info in close tab
        $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').empty();
        $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').empty();

        //reload tab
        $('.full-tour-information[data-tab-class="'+tab_class+'"]').empty().html('<img src="/images/loader.gif" class="reload-tour"/>');
        $.get(url, {'tour_id' : tour_id}).done(function(response){
            $('.back-to-main-from-tour[data-tab-class="'+tab_class+'"]').addClass('open');
            $('.back-to-main-from-tour[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').removeClass('hide');
            var data = $.parseJSON(response);
            if(data.status == 'ok'){
                $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data').addClass('col-xs-3 small-left').removeClass('col-md-9').attr('data-current-tour', tour_id);
                $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data .'+tab_class+':first').addClass('close-left').removeClass('col-md-4');
                $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data .'+tab_class+':last').addClass('col-xs-12').removeClass('col-md-8');
                $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data .'+tab_class+':last .list-data .user-tour-wrapper').addClass('small-column');
                $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data .'+tab_class+':last .list-data .user-tour-wrapper .body').addClass('col-xs-8').removeClass('col-xs-6');
                $('.main-tab-container[data-tab-class="'+tab_class+'"] .right-data').addClass('small-right col-xs-9').removeClass('col-md-3').attr('data-current-tour', tour_id);
                $('.main-tab-container[data-tab-class="'+tab_class+'"] .right-data .main-data').addClass('hide');
                $('.main-tab-container[data-tab-class="'+tab_class+'"] .right-data .full-tour-information').addClass('show').delay(1000).html(data.tour);
                $('.main-tab-container[data-tab-class="'+tab_class+'"] .full-tour-information').addClass('col-xs-12').removeClass('col-xs-12').attr('data-current-tour', tour_id);
            }else{
                $('.main-tab-container[data-tab-class="'+tab_class+'"] .full-tour-information').text(data.message);
            }
        });
    });

    //rechange user tour full information
    $('.user a[role="tab"].tour').on('click', function() {
        var tab = $(this).attr('aria-controls');
        if (tab == 'favourites') {
            tab_class = 'user-favourite-tours';
        } else if (tab == 'offers') {
            tab_class = 'user-offers';
        } else if(tab == 'hot-tour'){
            tab_class = 'user-hot-tours';
        } else{
            tab_class = '';
        }
        $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').empty();
        $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').empty();
        var current_tour_id = $('.main-tab-container[data-tab-class="'+tab_class+'"] .full-tour-information').attr('data-current-tour');

        if(typeof current_tour_id != 'undefined'){
            $('.main-tab-container[data-tab-class="'+tab_class+'"] .order-list').addClass('hidden');
            var url = $('.ajax-tour-full-info').attr('href');
            //add tour full info in ipening tab container
            $.get(url, {'tour_id' : current_tour_id}).done(function(response){
                $('.back-to-main-from-tour[data-tab-class="'+tab_class+'"]').addClass('open');
                $('.back-to-main-from-tour[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').removeClass('hide');
                var data = $.parseJSON(response);
                if(data.status == 'ok'){
                    $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data').addClass('col-xs-3 small-left').removeClass('col-md-9').attr('data-current-tour', current_tour_id);
                    $('.main-tab-container[data-tab-class="'+tab_class+'"] .full-tour-information').addClass('col-xs-12').removeClass('col-xs-9').attr('data-current-tour', current_tour_id);
                    $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data .'+tab_class+':last').addClass('col-xs-12').removeClass('col-md-8');
                    $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data .'+tab_class+':last .list-data .user-tour-wrapper').addClass('small-column');
                    $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data .'+tab_class+':last .list-data .user-tour-wrapper .body').addClass('col-xs-8').removeClass('col-xs-6');
                    $('.main-tab-container[data-tab-class="'+tab_class+'"] .right-data').addClass('small-right col-xs-9').removeClass('col-md-3').attr('data-current-tour', current_tour_id);
                    $('.main-tab-container[data-tab-class="'+tab_class+'"] .right-data .full-tour-information').addClass('show col-xs-12').removeClass('col-xs-9').delay(1000).html(data.tour);
                    //$('.main-tab-container[data-tab-class="'+tab_class+'"] .full-tour-information').html(data.tour);
                }else{

                    $('.main-tab-container[data-tab-class="'+tab_class+'"] .order-list').removeClass('hidden-select');
                    $('.main-tab-container[data-tab-class="'+tab_class+'"] .full-tour-information').text(data.message);
                }
            });
        }
    });

    //show filter, hide full tour information
    $(document).on('click', '.back-to-main-from-tour', function(e){
        e.preventDefault();
        var tab_class = $(this).attr('data-tab-class');
        $('.back-to-main-from-tour[data-tab-class="'+tab_class+'"]').removeClass('open');
        $('.back-to-main-from-tour[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').addClass('hide');
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .order-list').removeClass('hidden-select');
        //hide full tour information
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data').removeClass('col-xs-3 small-left').addClass('col-md-9').removeAttr('data-current-tour');
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data .'+tab_class+':first').removeClass('close-left').addClass('col-md-4');
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data .'+tab_class+':last').removeClass('col-xs-12').addClass('col-md-8');
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data .'+tab_class+':last .list-data .user-tour-wrapper').removeClass('small-column');
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .left-data .'+tab_class+':last .list-data .user-tour-wrapper .body').removeClass('col-xs-8').addClass('col-xs-6');
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .right-data').addClass('small-right col-xs-9').addClass('col-md-3').removeAttr('data-current-tour');
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .right-data .main-data').removeClass('hide');
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .right-data .full-tour-information').removeClass('show').empty();
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .full-tour-information').removeClass('col-xs-12 show').addClass('col-xs-12').removeAttr('data-current-tour')
    });


    //show hotel information, hide filter
    $(document).on('click', '.tour-full-info-manager', function(e){
        e.preventDefault();
        var tab_class = $(this).closest('.main-tab-container').attr('data-tab-class');
        var tour_id = $(this).attr('data-tour-id');
        var url = $('.ajax-tour-full-info').attr('href');
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .order-list').addClass('hidden-select');
        $.get(url,{'tour_id' : tour_id}).done(function(response){
            var data = $.parseJSON(response);
            $('.back-to-main-from-tour-manager[data-tab-class="'+tab_class+'"]').addClass('open');
            $('.back-to-main-from-tour-manager[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').removeClass('hide');
            $('.main-tab-container[data-tab-class="'+tab_class+'"]').addClass('implicit');
            if(data.status == 'ok'){
                $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                $('.full-tour-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').attr('data-current-tour', tour_id).html(data.tour);
            }else{
                $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                $('.full-tour-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').text(data.message);
            }
        });
    });

    //show filter, hide full tour information in manager
    $(document).on('click', '.back-to-main-from-tour-manager', function(e){
        e.preventDefault();
        var tab_class = $(this).attr('data-tab-class');
        $('.back-to-main-from-tour-manager[data-tab-class="'+tab_class+'"]').removeClass('open');
        $('.back-to-main-from-tour-manager[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').addClass('hide');
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .order-list').removeClass('hidden-select');
        //$('.filter-tour .left-data').removeClass('implicit');
        //$('.filter-tour .right-data').removeClass('col-xs-12').addClass('col-md-3');
        $('.full-tour-information[data-tab-class="'+tab_class+'"]').addClass('close-tab').removeClass('open-tab').removeAttr('data-current-tour').empty();
        //$('.right-data').show();
        $('.main-tab-container[data-tab-class="'+tab_class+'"]').removeClass('implicit');
    });


    //show tour in tab if manager did not close it, but switch on other tab
    $('.manager a[role="tab"].tour').on('click', function(){
        var url = $('.ajax-tour-full-info').attr('href');
        var tab = $(this).attr('aria-controls');
        //alert(tab);
        if(tab == 'my-offers'){
            tab_class = 'manager-offers';
        }else if(tab == 'my-hot-tours'){
            tab_class = 'manager-hot-tours';
        }else{
            tab_class = '';
        }
        var tab_current_tour = $('#'+tab+' .full-tour-information').attr('data-current-tour');
        if(typeof tab_current_tour != 'undefined'){
            $('.main-tab-container[data-tab-class="'+tab_class+'"] .order-list').addClass('hidden-select');
            $.get(url,{'tour_id': tab_current_tour}).done(function(response){
                var data = $.parseJSON(response);
                $('.back-to-main-from-tour-manager[data-tab-class="'+tab_class+'"]').addClass('open');
                $('.back-to-main-from-tour-manager[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').removeClass('hide');
                $('.main-tab-container[data-tab-class="'+tab_class+'"]').addClass('implicit');
                if(data.status == 'ok'){
                    $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-tour-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').attr('data-current-tour', tab_current_tour).html(data.tour);
                }else{
                    $('.main-tab-container[data-tab-class="'+tab_class+'"] .order-list').removeClass('hidden-select');
                    $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-tour-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').text(data.message);
                }
            });
        }
    });



    //show hotel information, hide filter (USER)
    $(document).on('click', '.more-hotel-info-user', function(e){
        e.preventDefault();
        var tab_class = $(this).closest('.main-tab-container').attr('data-tab-class');
        var hotel_id = $(this).attr('data-hotel-id');
        var url = $('.ajax-show-hotel-full-info').attr('href');
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .order-list').addClass('hidden-select');
        $.get(url,{'hotel_id': hotel_id}).done(function(response){
            var data = $.parseJSON(response);
            $('.back-to-main-from-user-get-tour[data-tab-class="'+tab_class+'"]').addClass('open');
            $('.back-to-main-from-user-get-tour[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').removeClass('hide');
            $('.main-tab-container[data-tab-class="'+tab_class+'"]').addClass('implicit');
            if(data.status == 'ok'){
                $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                $('.full-hotel-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').attr('data-current-hotel', hotel_id).html(data.hotel);
            }else{
                $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                $('.full-hotel-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').text(data.message);
            }
        });
    });

    //show filter, hide hotel information (USER)
    $(document).on('click', '.back-to-main-from-user-get-tour', function(e){
        e.preventDefault();
        var tab_class = $(this).attr('data-tab-class');
        $('.main-tab-container[data-tab-class="'+tab_class+'"] .order-list').removeClass('hidden-select');
        $('.back-to-main-from-user-get-tour[data-tab-class="'+tab_class+'"]').removeClass('open');
        $('.back-to-main-from-user-get-tour[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').addClass('hide');
        //$('.filter-tour .left-data').removeClass('implicit');
        //$('.filter-tour .right-data').removeClass('col-xs-12').addClass('col-md-3');
        $('.full-hotel-information[data-tab-class="'+tab_class+'"]').addClass('close-tab').removeClass('open-tab').removeAttr('data-current-hotel').empty();
        //$('.right-data').show();
        $('.main-tab-container[data-tab-class="'+tab_class+'"]').removeClass('implicit');
    });

    //show hotel in tab if user did not close it, but switch on other tab (USER)
    $('.user a[role="tab"].hotel').on('click', function(){
        var url = $('.ajax-show-hotel-full-info').attr('href');
        var tab = $(this).attr('aria-controls');
        //alert(tab);
        if(tab == 'get-tour'){
            tab_class = 'get-tour';
        }else{
            tab_class = '';
        }
        var tab_current_hotel = $('#'+tab+' .full-hotel-information').attr('data-current-hotel');
        if(typeof tab_current_hotel != 'undefined'){
            $('.main-tab-container[data-tab-class="'+tab_class+'"] .order-list').addClass('hidden-select');
            $.get(url,{'hotel_id': tab_current_hotel}).done(function(response){
                var data = $.parseJSON(response);
                $('.back-to-main-from-user-get-tour[data-tab-class="'+tab_class+'"]').addClass('open');
                $('.back-to-main-from-user-get-tour[data-tab-class="'+tab_class+'"] .glyphicon-menu-right').removeClass('hide');
                $('.main-tab-container[data-tab-class="'+tab_class+'"]').addClass('implicit');
                if(data.status == 'ok'){
                    $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-hotel-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').attr('data-current-hotel', tab_current_hotel).html(data.hotel);
                }else{
                    $('.full-hotel-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-tour-information:not([data-tab-class="'+tab_class+'"])').addClass('close-tab').removeClass('open-tab').empty();
                    $('.full-hotel-information[data-tab-class="'+tab_class+'"]').removeClass('close-tab').addClass('open-tab').text(data.message);
                }
            });
        }
    });

    //order flight list USER
    $(document).on('change', '#flight-response [name="order-flight-list"]', function(){
        var value = $(this).val();
        var container_id = $(this).closest('div').attr('id');
        $(this).closest('.loader-bg').removeClass('hide');
        var data = [];
        $('#'+container_id+' .flight-wrapper').each(function(){
            data.push($(this).attr('data-flight-id'));
        });
        var url = $('.ajax-order-flights-list-user').attr('href');
        $.get(url, {'ids': data, 'order_by': value}).done(function(response){
            $(this).closest('.loader-bg').addClass('hide');
            var data = $.parseJSON(response);
            if(data.status == 'ok'){
                $('#'+container_id+' .list-data').html(data.tourList);
            }else{
                $('#'+container_id+' .list-data').text(data.message);
            }
        });
    });

    //order flight list MANAGER
    $(document).on('change', '#manager-flight-response [name="order-flight-list"]', function(){
        var value = $(this).val();
        var container_id = $(this).closest('div').attr('id');
        $(this).closest('.loader-bg').removeClass('hide');
        var data = [];
        $('#'+container_id+' .flight-wrapper').each(function(){
            data.push($(this).attr('data-flight-id'));
        });
        var url = $('.ajax-order-flights-list-manager').attr('href');
        $.get(url, {'ids': data, 'order_by': value}).done(function(response){
            $(this).closest('.loader-bg').addClass('hide');
            var data = $.parseJSON(response);
            if(data.status == 'ok'){
                $('#'+container_id+' .list-data').html(data.tourList);
            }else{
                $('#'+container_id+' .list-data').text(data.message);
            }
        });
    });

});
