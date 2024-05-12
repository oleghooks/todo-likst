<ol class="list-group list-group-numbered">
    @foreach($tasks as $task)
        <li class="list-group-item d-flex justify-content-between align-items-start" id="task-{{$task->id}}">
            <div class="ms-2 me-auto">
                <div class="fw-bold">{{$task->text}}</div>
                <ul class="list-group list-group-horizontal">
                    @foreach($task->attachments as $attachment)
                        <li class="list-group-item"><a href="{{$attachment->url}}" target="_blank"> <img src="{{$attachment->url150}}"></a></li>
                    @endforeach
                </ul>
                <div>
                    <button class="btn btn-primary btn-sm" onclick="$('#task-{{$task->id}}').load('/tasks/edit_form?id={{$task->id}}');">Редактировать</button>
                </div>
            </div>
            @foreach($task->tags as $tag)
                <span class="badge bg-primary rounded-pill me-1">{{$tag}}</span>
            @endforeach
        </li>
    @endforeach
</ol>
