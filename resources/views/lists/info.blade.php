<script type="text/javascript">
    $(document).ready(function(){
        Tasks.List({{$list->id}});
    });
</script>

<div style="display: none;" class="input-group mb-2" id="list_edit_group">
    <input type="text" class="form-control" id="list_edit_text" value="{{$list->title}}">
    <button class="btn btn-primary" onclick="List.Edit({{$list->id}}); ">Сохранить</button>
    <button class="btn btn-secondary" onclick="$('#list_edit_group').hide(); $('#title_group').slideDown();">Отменить</button>
</div>
<h3 id="title_group">
    <button type="button" class="btn btn-danger btn-sm float-end" onclick="List.Delete({{$list->id}})">Удалить список</button>
    <button id="task_add_group_button" type="button" class="btn btn-primary btn-sm float-end me-1" onclick="$('#task_add_group').slideDown(); $(this).hide();">Создать задачу</button>
    <button id="list_edit_button" type="button" class="btn btn-primary btn-sm float-end me-1" onclick="$('#list_edit_group').slideDown(); $('#title_group').hide();">Редактировать название списка</button>
    <b>{{$list->title}}</b>
</h3>
<div id="task_add_group" style="display: none;" class="p-2 border border-1 rounded">
    <div class="mb-3 row">
        <label for="text_task" class="col-sm-2 col-form-label">Текст задачи</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="text_task" value="">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="tag_text" class="col-sm-2 col-form-label">Теги</label>
        <div class="col-sm-10">
            <div class="d-flex flex-row flex-wrap" id="tags"></div>
            <input type="text" class="form-control" id="tag_text" onkeydown="if (event.keyCode == 13 || event.keyCode == 32){ Tasks.TagAdd('tag_text', 'tags'); return false}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="formFile" class="col-sm-2 col-form-label">Добавить изображение</label>
        <div class="col-sm-10">
            <input class="form-control" type="file" id="formFile" onchange="Tasks.ImageUploadCreateTask('images_upload', 'formFile');">
        </div>
        <div class="d-flex flex-row flex-wrap" id="images_upload"></div>
    </div>
    <button class="btn btn-primary" onclick="Tasks.Add({{$list->id}});">Создать</button> <button class="btn btn-secondary" onclick="$('#task_add_group').slideUp(); $('#task_add_group_button').show();">Отмена</button>
</div>

<div class="input-group mb-3">
    <input type="text" class="form-control" id="text_search" onkeydown="Tasks.List({{$list->id}})" placeholder="Поиск по тексту задачи" aria-label="Username">
    <span class="input-group-text"></span>
    <input type="text" class="form-control" id="tag_search"  onkeydown="if (event.keyCode === 13 || event.keyCode === 32){ Tasks.TagAdd('tag_search', 'tags_search'); Tasks.List({{$list->id}}); return false}" placeholder="Поиск по тегам(введите тег и нажмите пробел)" aria-label="Server">
</div>
<div class="d-flex flex-row flex-wrap"  id="tags_search">

</div>
<div id="tasks">

</div>
