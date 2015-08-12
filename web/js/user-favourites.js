$(function(){
   $(document).on('click', '#user-tour-response-list .add-to-favourite, #user-hot-tours-response .add-to-favourite', function(e){
       e.preventDefault();
       var url = $(this).attr('href');
       $.post(url).done(function(response){
           var data = $.parseJSON(response);
           if(data.status == 'ok'){
               $('.badge.offers-tab.tab-badge.favourites-tours').text(data.count);
               if(data.action == 'add'){
                   $('#user-favourite-tours-response .list-data').prepend(data.tour);
                    $('.favourite-user-tour[data-tour-id="'+data.tour_id+'"]').addClass('glyphicon-heart favourite').removeClass('glyphicon-heart-empty');
               }else if(data.action == 'delete'){
                   $('.favourite-user-tour[data-tour-id="'+data.tour_id+'"]').removeClass('glyphicon-heart favourite').addClass('glyphicon-heart-empty');
                   $('#user-favourite-tours-response .favourite-user-tour[data-tour-id="'+data.tour_id+'"]').remove();
               }
           }else{
               alert(data.message);
           }
       });
   })

    //dropdown list with user's tour for manager after country change
    $(document).on('change', '#userfavouriteform-destination', function(){
        getUserFavouriteToursList();
    });

    //get user favourites list
    function getUserFavouriteToursList(){
        var url = $('.ajax-get-user-favourites-tours-list').attr('href');
        var data = $('#user-favourite-tours-form').serialize();
        $('.user-favourites-tours .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.user-favourites-tours .loader-bg').addClass('hide');
            console.log(data.model);
            if(data.status == 'ok') {
                $('#user-favourite-tours-response .list-data').html(data.tours);
                $('#user-favourite-tours-response .favourites-count').text(data.count);
            }else{
                $('#user-favourite-tours-response .list-data').html(data.message);
                $('#user-favourite-tours-response .favourites-count').text(data.count);
            }
        });
    }

    //delete user favourite tour from tab
    $(document).on('click', '#user-favourite-tours-response .add-to-favourite', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.post(url).done(function(response){
            var data = $.parseJSON(response);
            if(data.status == 'ok'){
                $('.badge.offers-tab.tab-badge.favourites-tours').text(data.count);
                if(data.action == 'delete'){
                    $('#user-favourite-tours-response .user-tour-wrapper[data-tour-id="'+data.tour_id+'"]').fadeOut().delay(1000).remove();
                }
            }else{
                alert(data.message);
            }
        });
        return false;
    });
});