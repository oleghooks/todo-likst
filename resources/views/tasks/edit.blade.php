<div id="task_edit_group" class="p-2 border border-1 rounded">
    <div class="mb-3 row">
        <label for="text_task_edit" class="col-sm-2 col-form-label">Текст задачи</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="text_task_edit" value="{{$task->text}}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="tag_text_edit" class="col-sm-2 col-form-label">Теги</label>
        <div class="col-sm-10">
            <div class="d-flex flex-row flex-wrap" id="tags_edit">
                @foreach($task->tags as $tag)
                    <div id="tag" class="p-1 me-1 mb-1 rounded text-bg-secondary bg-secondary">
                        <b>{{$tag}}</b>
                        <span class="ms-2 fw-bold c" style="cursor: pointer;" onclick="$(this).parent().remove();">X</span>
                    </div>
                @endforeach
            </div>
            <input type="text" class="form-control" id="tag_text_edit" onkeydown="if (event.keyCode == 13 || event.keyCode == 32){ Tasks.TagAdd('tag_text_edit', 'tags_edit'); return false}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="formFileEdit" class="col-sm-2 col-form-label">Добавить изображение</label>
        <div class="col-sm-10">
            <input class="form-control" type="file" id="formFileEdit" onchange="Tasks.ImageUploadCreateTask('images_upload_edit', 'formFileEdit' ,{{$task->id}});">
        </div>
        <div class="d-flex flex-row flex-wrap" id="images_upload_edit">
            @foreach($task->attachments as $attachment)
                <div id="image_upload" attachment-id="{{$attachment->id}}" class="p-1 me-1 mb-1 rounded text-bg-secondary bg-light text-center">
                    <img class="rounded" src="{{$attachment->url150}}"><br />
                    <button class="btn btn-danger btn-sm m-1" onclick="$(this).parent().remove();">Удалить</button>
                    <button class="btn btn-success btn-sm m-1" onclick="$(this).parent().remove(); $('#formFileEdit').click();">Заменить</button>
                </div>
            @endforeach
        </div>
    </div>
    <button class="btn btn-primary" onclick="Tasks.Edit({{$task->id}}, {{$task->list_id}});">Сохранить</button> <button class="btn btn-secondary" onclick="Tasks.List({{$task->list_id}});">Отмена</button>
</div>
