<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TasksController extends Controller
{
    public function list(Request $request)
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
        $tasks = Task::where('list_id', $id)->where('user_id', Auth::id());

        //Если поле поиска имеет текст то фильтруем
        if($search_text)
            $tasks->where('text', 'LIKE', '%'.$search_text.'%');

        //Если в поисе есть теги фильтруем и по ним
        if($sort === 'tags')
        {
            $sort_text = explode(",", $sort_text);
            foreach ($sort_text as $tag)
                $tasks->where('tags', 'LIKE', '%'.$tag.'%');
        }
        $tasks->orderBy('updated_at', 'DESC');
        //Делам запрос
        $tasks = $tasks->get();
        //В массив tasks добавляем каждому task его вложения в переменную attachments
        foreach($tasks as &$task) {
            $task->attachments = TaskAttachment::where('task_id', $task->id)->get();
            $task->tags = explode(",", $task->tags);
        }
        //Возвращаем blade шаблон
        return view('tasks.list', [
            'tasks' => $tasks
        ]);
        //var_dump($tasks);
    }

    public function add(Request $request):JsonResponse
    {
        //Валидация на присутствие текста
        $request->validate([
           'text' => 'required',
            'list_id' => 'required',
        ]);


        $list = Lists::where('id', $request->input('list_id'))->where('user_id', Auth::id())->first();

        if($list)
        {
            //Присвоение переменных входных параметрам
            $text = $request->input('text');
            $tags = $request->input('tags') ?? "";
            $images = $request->input('images') ?? "";

            try {
                //Попытка внести запись в БД
                $task = Task::create([
                    'list_id' => $list->id,
                    'text' => $text,
                    'tags' => $tags,
                    'user_id' => Auth::id()
                ]);
                if($task && $images){
                    $images = explode(',', $images);
                    foreach ($images as $image){
                        $attachment = TaskAttachment::where('id', $image)->where('user_id', Auth::id())->first();
                        $attachment->task_id = $task->id;
                        $attachment->save();
                    }
                }
                //Если все хорошо ответ JSON status code 200
                return response()->json([
                    'status_code' => 200,
                    'task' => $task
                ]);
             } catch (\Exception) {
                //Если не получилось, то 500
                return response()->json([
                    'status_code' => 500,
                    'desc' => 'Ошибка при создании задания'
                ], 500);
            }
        }
        else
            return response()->json([
                'status_code' => 500,
                'desc' => 'Это не ваш список или вы не имеете к нему доступа'
            ], 500);
    }

    public function editForm(Request $request){
        $request->validate([
            'id' => 'required'
        ]);
        $task_id = $request->input('id');
        $task = Task::find($task_id);
        if($task->user_id === Auth::id()){
            $task->attachments = TaskAttachment::where('task_id', $task->id)->get();
            $task->tags = explode(",", $task->tags);
            return view('tasks.edit', ['task' => $task]);
        }
        else
            //Если нет, то ошибка 500
            return response()->json([
                'status_code' => 500,
                'desc' => 'Это не ваше задание или вы не имеете к нему доступ'
            ], 500);

    }
    public function edit(Request $request):JsonResponse
    {
        //Проверка на валидацию
        $request->validate([
            'task_id' => 'required',
            'text' => 'required'
        ]);

        //Присвоение переменных входным параметрам
        $id = $request->input('task_id');
        $text = $request->input('text');
        $tags = $request->input('tags') ?? "";
        $images = $request->input('images') ?? "";

        //Запрос в бд что есть такое задание у такого пользователя
        $task = Task::where('id', $id)->where('user_id', Auth::id())->first();
        if($task){
            $task->text = $text;
            $task->tags = $tags;
            $task->save();

            DB::table('tasks_attachments')
                ->where('task_id', $id)
                ->where('user_id', Auth::id())
                ->update([
                    'task_id' => 0
                ]);
            $images = explode(',', $images);
            foreach ($images as $image){
                $attachment = TaskAttachment::where('id', $image)->where('user_id', Auth::id())->first();
                $attachment->task_id = $task->id;
                $attachment->save();
            }
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
