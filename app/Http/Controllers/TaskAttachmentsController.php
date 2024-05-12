<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskAttachmentsController extends Controller
{
    public function add(Request $request){
        $request->validate([
            'file' => 'required',
        ]);
        $task_id = $request->input('task_id');
        $file_temp = $request->file('file');
        if($task_id) {
            $task = Task::where('id', $task_id)->where('user_id', Auth::id())->first();
            if(!$task)
                $task_id = 0;
        }
        if($request->hasFile('file'))
        {
            $name = md5(rand(0,99999).rand(0,99999)).".jpg";
            $to_path = public_path() . '/attachs/';
            if($file_temp->move($to_path, $name)){
                 $task = TaskAttachment::create([
                        'task_id' => $task_id ?? 0,
                        'url' => "/attachs/".$name,
                        'user_id' => Auth::id(),
                        'url150' => "/imagefly/w150-h150-c/attachs/".$name
                    ]);
                return response()->json([
                    'status_code' => '200',
                    'url_image' => "/attachs/".$name,
                    'attachment_id' => $task->id,
                    'url150' => "/imagefly/w150-h150-c/attachs/".$name
                ]);
            }
        }
    }
}
