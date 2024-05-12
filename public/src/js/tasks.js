let Tasks = {
    TagAdd: function(tag_name, tags_group){
        const tag = $('#'+tag_name);
        const tags_gr = $('#'+tags_group);
        let option = "";
        if(tag_name === "tag_search")
            option = " Tasks.List($(\'#current_list_id\').val())";
        if(tag.val().length > 0)
            tags_gr.prepend('<div id="tag" class="p-1 me-1 mb-1 rounded text-bg-secondary bg-secondary"><b>'+tag.val()+'</b><span class="ms-2 fw-bold c" style="cursor: pointer;" onclick="$(this).parent().remove();'+option+'">X</span></div>');
        tag.val('');
        return false;
    },
    ImageUploadCreateTask: function(images_group, file_input_name, task_id){
        let formData = new FormData();
        formData.append('file', $("#"+file_input_name)[0].files[0]);
        if(task_id)
            formData.append('task_id', task_id);
        $.ajax({
            type: "POST",
            url: '/tasks/upload',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            dataType : 'json',
            success: function(msg){
                console.log(msg);
                $('#'+images_group).prepend('<div id="image_upload" attachment-id="'+msg.attachment_id+'" class="p-1 me-1 mb-1 rounded text-bg-secondary bg-light text-center"><img class="rounded" src="'+msg.url150+'"><br /><button class="btn btn-danger btn-sm m-1" onclick="$(this).parent().remove();">Удалить</button><button class="btn btn-success btn-sm m-1" onclick="$(this).parent().remove(); $(\'#formFileEdit\').click();">Заменить</button></div>');

            }
        });
    },
    Add: function(list_id){
        let tags = [];
        let images = [];
        const text = $('#text_task').val();
        $('#tags #tag').each(function(){
            tags.push($(this).find('b').text());
        });
        $('#images_upload #image_upload').each(function(){
            images.push($(this).attr('attachment-id'));
        });
        $('#tags').empty();
        $('#images_upload').empty();
        $('#text_task').val("");
        $("#formFile").val("");
        $('#task_add_group').slideUp();
        $('#task_add_group_button').show();
        $.ajax({
            url: '/tasks/add',
            method: 'POST',
            data: {
                list_id: list_id,
                text: text,
                images: images.toString(),
                tags: tags.toString()
            },
            success: function(response){
                Tasks.List(list_id);
            }
        })
    },
    Edit: function(task_id, list_id){
        let tags = [];
        let images = [];
        const text = $('#text_task_edit').val();
        $('#tags_edit #tag').each(function(){
            tags.push($(this).find('b').text());
        });
        $('#images_upload_edit #image_upload').each(function(){
            images.push($(this).attr('attachment-id'));
        });
        $('#task-'+task_id).attr('style', 'opacity: 0.3');
        $.ajax({
            url: '/tasks/edit',
            method: 'POST',
            data: {
                task_id: task_id,
                text: text,
                images: images.toString(),
                tags: tags.toString()
            },
            success: function(response){
                Tasks.List(list_id);
            }
        })
    },
    List: function(list_id){
        let search_text = $('#text_search').val();
        let tags = [];

        $('#tags_search #tag').each(function(){
            tags.push($(this).find('b').text());
        });

        $.ajax({
            url: '/tasks/list',
            method: 'GET',
            data: {
                id: list_id,
                search_text: search_text,
                sort: "tags",
                sort_text: tags.toString()
            },
            success: function (response){
                if($('#current_list_id').val() == list_id)
                    $('#tasks').html(response);
            }
        })
    }
}
