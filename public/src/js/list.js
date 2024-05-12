let List = {
    Add: function(){
        const text = $('#list_add_text').val();
        if(text.length) {
            $('#list_add_text').val('');
            $.ajax({
                url: '/list/add',
                method: 'POST',
                data: {title: text},
                success: function (response) {
                    List.Load();
                }
            });
        }
    },
    Load: function(){
        let current_id = $('#current_list_id').val();
        $.ajax({
           url: '/list?current_id='+current_id,
           method: 'GET',
           success: function (response){
               if(response != $('#lists-group').html())
                   $('#lists-group').html(response);
           }
        });
    },
    Info: function(id){
        $('.list-group .active').removeClass('active');
        $('#current_list_id').val(id);
        $('#list_'+id).addClass('active');
        $.ajax({
            url: '/list/info?id='+id,
            method: 'GET',
            success: function (response){
                if($('#current_list_id').val() == id)
                    $('#list_info').html(response);
                else
                    console.log('net');
            }
        });
    },
    Delete: function (id){
        $('#list_info').empty();
        $('#current_list_id').val(0);
        $.ajax({
            url: '/list/delete?id='+id,
            method: 'GET',
            success: function (response){
                List.Load();
            }
        });
    },
    Edit: function(id){
        let text_edit = $('#list_edit_text');
        if(text_edit.val().length > 1) {
            $('#list_edit_group').hide();
            $('#title_group').slideDown();
            $('#title_group b').text(text_edit.val());
            $.ajax({
                url: '/list/edit',
                method: 'POST',
                data: {
                    title: text_edit.val(),
                    id: id
                }
            });
        }
    }
}
