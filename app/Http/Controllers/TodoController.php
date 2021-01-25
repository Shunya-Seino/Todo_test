<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\IndexTodo;
use App\Http\Requests\CreateTodo;
use App\Http\Requests\EditTodo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,IndexTodo $srcrequest)
    {
        //$data = $request->session()->all();
        //dd($data);
        //dd($srcrequest);
        $current_user_id = Auth::user()->users();

        $title_keyword = $request->input('title');
        $detail_keyword = $request->input('detail');
        $todo_statuses = $request->input('todo_statuses');

        $start_date_from = $request->input('start_date_from');
        $start_date_to = $request->input('start_date_to');

        $due_date_from = $request->input('due_date_from');
        $due_date_to = $request->input('due_date_to');

        $page_values = $request->input('page_values');

        $query = Todo::query();

        $query -> where('user_id', $current_user_id);

        if (!empty($title_keyword)) {
            $query->where('title', 'LIKE', "%{$title_keyword}%");
        }

        if (!empty($detail_keyword)) {
            $query->where('detail', 'LIKE', "%{$detail_keyword}%");
        }

        if (!empty($todo_statuses)){
            foreach($todo_statuses as $todo_status){
                if($todo_status <> 3){
                    $query->where('status', '=', (int)$todo_status);
                }
            }
        }

        $query->where('status', '<>', 3);

        if(!empty($start_date_from) and !empty($start_date_to)){
            $query->whereBetween('start_date', [$start_date_from, $start_date_to]);
        }else{
            if (!empty($start_date)) {
                $query->where('start_date', '>=' , $start_date_from);
            }
            if (!empty($due_date)) {
                $query->where('start_date', '<=' , $start_date_to);
            }
        }

        if(!empty($due_date_from) and !empty($due_date_to)){
            $query->whereBetween('due_date', [$due_date_from, $due_date_to]);
        }else{
            if (!empty($start_date)) {
                $query->where('due_date', '>=' , $due_date_from);
            }
            if (!empty($due_date)) {
                $query->where('due_date', '<=' , $due_date_to);
            }
        }

        if (!empty($page_values)) {
            $SearchTodos = $query->sortable()->paginate($page_values);
        }else{
            $SearchTodos = $query->sortable()->paginate(10);
        }

        return view('todo/index', [
            'todos' => $SearchTodos,
            'input_info' => $request,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCreateForm(Todo $todo)
    {
        return view('todo.create', [
            'id' => $todo->id,
            //'user_id' => $todo->user_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Todo $todo, CreateTodo $request)
    {
        // ユーザーモデルのインスタンスを作成する
        $NewTodo = new Todo();
        // 各カラムに入力された値を代入する
        $NewTodo->user_id = Auth::user()->users();
        $NewTodo->title = $request->title;
        $NewTodo->detail = $request->detail;
        $NewTodo->start_date = $request->start_date;
        $NewTodo->due_date = $request->due_date;
        $NewTodo->status = $request->status;

        $NewTodo->save();

        // インスタンスの状態をデータベースに書き込む(save()は単なる上書きでなく、差分上書き。差分がなければ更新されない。)
        //$NewTodo->save();
    
        return redirect()->route('todo.index', [
            'id' => $NewTodo->id,
        ]);
    }

    public function showEditForm(Request $id)
    {
        $todo_info = Todo::find($id->id);
        //dd($todo_info);

        return view('todo.edit', [
            'todo' => $todo_info,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EditTodo $request)
    {
        // ユーザーモデルのインスタンスをキーで呼び出す(SQL投げるから当然キーじゃないと見つからない。見つからないとデータ形式が相違するからsave()もupdate()もできない。)
        $EditTodo = Todo::where('id', '=', $request->id)
                        ->where('user_id', '=', Auth::user()->users())
                        ->first();
        
        // 各カラムに入力された値を代入する
        $EditTodo->title = $request->title;
        $EditTodo->detail = $request->detail;
        $EditTodo->start_date = $request->start_date;
        $EditTodo->due_date = $request->due_date;
        $EditTodo->status = $request->status;

        //入力値を暗号化してから代入する(Authが暗号化されたパスワードを扱うことを前提としてるので、暗号化しないと登録はできてもログインできない。)
        //$EditUser->password = Hash::make($request['password']);
        
        // インスタンスの状態をデータベースに書き込む(save()は単なる上書きでなく、差分上書き。差分がなければ更新されない。更新処理の場合updated_atは自動更新される。)
        $EditTodo->save();
    
        return redirect()->route('todo.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $id)
    {
        Todo::find($id->id)->delete();
        return redirect(route('todo.index'));
    }
}
