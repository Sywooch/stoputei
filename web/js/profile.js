$(function(){
    $('#profileeditform-country').on('change', function() {
        var country_id = $(this).val();
        var region_url = $('.get-city-dropdown').attr('href');
        $.get(region_url,{'country_id':country_id}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#profileeditform-region_id').html(select_resort);
        });
    });

    $("[name='bootstrap-switch-checkbox']").bootstrapSwitch();
    $('input[name="bootstrap-switch-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
        var type = $(this).attr('data-type');
        if(state) {
            if(type == 'password'){
                $('input[name="ProfileEditForm[password]"]').removeAttr('disabled');
                $('input[name="ProfileEditForm[password_repeat]"]').removeAttr('disabled');
            }else {
                $('input[name="ProfileEditForm[' + type + ']"]').removeAttr('disabled');
            }
        }else{
            if(type == 'password'){
                $('input[name="ProfileEditForm[password]"]').attr('disabled', true);
                $('input[name="ProfileEditForm[password_repeat]"]').attr('disabled', true);
            }else {
                $('input[name="ProfileEditForm[' + type + ']"]').attr('disabled', true);
            }
        }
    });
})