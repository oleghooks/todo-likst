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
            'task_id' => 'required'
        ]);
        $task_id = $request->input('task_id');
        $file_temp = $request->file('file');
        $task = Task::where('id', $task_id)->where('user_id', Auth::id())->first();
        if($request->hasFile('file') && $task)
        {
            $name = md5(rand(0,99999).rand(0,99999)).".jpg";
            $to_path = public_path() . '/attachs/';
            if($file_temp->move($to_path, $name)){
                TaskAttachment::create([
                    'task_id' => $task_id,
                    'url' => $name,
                    'user_id' => Auth::id(),
                    'url_150' => ""
                ]);
                return response()->json([
                    'status_code' => '200',
                    'url_image' => $to_path.$name
                ]);
            }
            //Storage::disk('google')->put('/bids_attachs/'.$request->input('order_id').$name, File::get($to_path.$name));
        }
    }
}
