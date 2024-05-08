<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use App\Models\Lists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListsController extends Controller
{
    public function list(Request $request){
        $request->validate([
            'current_id' => 'numeric'
        ]);
        $current_id = $request->input('current_id');

        $list = Lists::where('user_id', Auth::id())->get();

        return view('lists', [
            'current_id' => $current_id,
            'list' => $list
        ]);
    }

    public function add(Request $request){
        $request->validate([
            'title' => 'required'
        ]);
        $title = $request->input('title');

        try {
            Lists::create([
                'title' => $title,
                'user_id' => Auth::id()
            ]);
            return response()->json([
                'status_code' => '200'
            ]);
        }
        catch (Exception){
            return response()->json([
                'status_code' => '500',
                'desc' => 'Ошибка при создании списка. Обратитесть к администратору'
            ], 500);
        }
    }

    public function delete(Request $request){
        $request->validate([
            'id' => 'required|numeric'
        ]);
        $id = $request->input('id');
        $list = Lists::where('id', $id)->where('user_id', Auth::id())->first();
        if($list){
            $list->delete();
            return response()->json([
                'status_code' => '200',
                'desc' => 'Список успешно удален'
            ]);
        }
        else
            return response()->json([
                'status_code' => '404',
                'desc' => 'Список не найден или уже удален'
            ], 404);
    }

    public function info(Request $request){
        $request->validate([
            'id' => 'required|numeric',
        ]);
        $id = $request->input('id');
        $list = Lists::where('id', $id)->where('user_id', Auth::id())->first();
        if($list){
            return view('lists.info', [
                'list' => $list
            ]);
        }
        else
            return "Вы не имеете доступа к этому списку";
    }


}
