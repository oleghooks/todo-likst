<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TasksController extends Controller
{
    public function list(Request $request):View
    {
        //Проверка на присутствие id
        $request->validate([
            'id' => 'required'
        ]);
        //Присвоение переменных входным параметрам
        $id = $request->input('id');
        $sort = $request->input('sort');
        $sort_text = $request->input('sort_text');
        $search_text = $request->input('search_text');


        //Поиск в базе данных задач по list_id
        $tasks = Task::where('list_id', $id);

        //Если поле поиска имеет текст то фильтруем
        if($search_text)
            $tasks->where('text', 'LIKE', '%'.$search_text.'%');

        //Если в поисе есть теги фильтруем и по ним
        if($sort === 'tags')
        {
            $sort_text = explode(",", $sort_text);
            foreach ($sort_text as $tag)
                $tasks->where('tags', 'LIKE', $tag);
        }
        //Делам запрос
        $tasks->get();
        //В массив tasks добавляем каждому task его вложения в переменную attachments
        foreach($tasks as &$task)
            $task->attachments = TaskAttachment::where('task_id', $task->id)->get();
        //Вовзращаем blade шаблон
        return view('tasks.list', [
            'tasks' => $tasks
        ]);
    }

    public function add(Request $request):JsonResponse
    {
        //Валидация на присутствие текста
        $request->validate([
           'text' => 'required'
        ]);

        //Присвоение переменных входных параметрам
        $text = $request->input('text');
        $tags = $request->input('tags') ?? "";

        try{
            //Попытка внести запись в БД
            $task = Task::create([
                'text' => $text,
                'tags' => $tags,
            ]);
            //Если все хорошо ответ JSON status code 200
            return response()->json([
                'status_code' => 200,
                'task' => $task
            ]);
        }
        catch (\Exception){
            //Если не получилось, то 500
            return response()->json([
                'status_code' => 500,
                'desc' => 'Ошибка при создании задания'
            ], 500);
        }
    }

    public function edit(Request $request):JsonResponse
    {
        //Проверка на валидацию
        $request->validate([
            'id' => 'required',
            'text' => 'required'
        ]);

        //Присвоение переменных входным параметрам
        $id = $request->input('id');
        $text = $request->input('text');
        $tags = $request->input('tags') ?? "";

        //Запрос в бд что есть такое задание у такого пользователя
        $task = Task::where('id', $id)->where('user_id', Auth::id())->get();
        if($task){
            $task->text = $text;
            $task->tags = $tags;
            $task->save();
            return response()->json([
                'status_code' => 200,
            ]);
        }
        else{
            //Если нет, то ошибка 500
            return response()->json([
                'status_code' => 500,
                'desc' => 'Это не ваше задание или вы не имеете к нему доступ'
            ], 500);
        }
    }

    public function delete(Request $request):JsonResponse{
        $request->validate([
            'id' => 'required'
        ]);
        $task = Task::where('id', $request->input('id'))->where('user_id', Auth::id())->first();
        if($task){
            $task->delete();
            return response()->json([
                'status_code' => 200,
            ]);
        }
        else
            return response()->json([
                'status_code' => 500,
                'desc' => 'Это не ваше задание или вы не имеете к нему доступ'
            ], 500);
    }

}
