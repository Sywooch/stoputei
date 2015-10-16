$(function(){
    $('.admin-panel .actions.delete').on('click', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var remove_user = confirm('Вы действительно хотите удалить пользователя?');
        if(remove_user) {
            $.post(url).done(function (response) {
                var data = $.parseJSON(response);
                if (data.status == 'ok') {
                    $('tr[data-key="' + data.id + '"]').fadeOut(1000);
                } else {
                    alert(data.message);
                }
            });
        }
    })

    $('.admin-panel .actions .delete.payment').on('click', function(e){

    });
});