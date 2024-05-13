@extends('layouts.app')

@section('content')
<input type="hidden" id="is_logged" value="1">
<input type="hidden" id="current_list_id" value="0">
<div class="container h-100">
    <div class="d-flex flex-row w-100 h-100 rounded border bg-white">
        <div class="w-25 h-100 border-end overflow-auto">
            <div class="input-group mb-3 p-1">
                <input type="text" class="form-control" id="list_add_text" placeholder="Название списка" aria-label="Название списка" aria-describedby="list_add">
                <button class="btn btn-primary" type="button" id="list_add" onclick="List.Add();">Создать</button>
            </div>
            <div id="lists-group"></div>
        </div>

        <div class="w-75 h-100 overflow-auto p-2" id="list_info"></div>
    </div>
</div>
@endsection
