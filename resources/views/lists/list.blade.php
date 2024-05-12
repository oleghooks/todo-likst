<ul class="list-group border-0 rounded-0 bg-white">
    @foreach ($lists as $list)
        <li id="list_{{$list->id}}" onclick="List.Info({{$list->id}})" class="list_info border-0 border-bottom   list-group-item @if($current_id == $list->id) active @endif" >{{$list->title}}</li>
    @endforeach
</ul>
