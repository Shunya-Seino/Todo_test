<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUser;
use App\Http\Requests\EditUser;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*
    public function index()
    {
        //ModelでDB接続→SQL結果取得してる
        //取得した結果をallですべてAllUsersに代入(Object的(感覚はArraylist的)な持ち方)
        //投げた先のbladeファイルでforeachして各要素をピックアップする
        $AllUsers = User::all();

        return view('user.index', [
            //user.index(/userのindex.blade.php)に投げる。
            //このuserはテーブル：database.usersを意味する。
            //このアロー式が成立しない時、SQLで取得した結果がテーブルと相違していることを意味する
            'users' => $AllUsers
        ]);
    }
    */

    public function index(Request $request)
    {
        $name_keyword = $request->input('name_keyword');
        $address_keyword = $request->input('address_keyword');
        $account_status = $request->input('account_status');
        $page_values = $request->input('page_values');
        $input_info = $request;

        $query = User::query();
 
        if (!empty($name_keyword)) {
            $query->where('name', 'LIKE', "%{$name_keyword}%");
        }

        if (!empty($address_keyword)) {
            $query->where('email', 'LIKE', "%{$address_keyword}%");
        }
 
        if (!empty($account_status)) {
            $query->where('status', '=', $account_status);
        }

        if (!empty($page_values)) {
            $SearchUsers = $query->sortable()->paginate($page_values);
        }else{
            $SearchUsers = $query->sortable()->paginate(10);
        }

        $page_values = $request->input('page_values');
        
        return view('user.index',[
            'users' => $SearchUsers,
            'input_info' => $input_info
        ]);
    }

    /**
     * ユーザー作成フォーム
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function showCreateForm(User $user)
    {
        return view('user.create', [
            'user_id' => $user->id,
        ]);
    }

    public function create(CreateUser $request)
    {
        // ユーザーモデルのインスタンスを作成する
        $NewUser = new User();
        // 各カラムに入力された値を代入する
        $NewUser->name = $request->name;
        $NewUser->email = $request->email;

        //$NewUser->password = $request->password;
        //入力値を暗号化してから代入する(Authが暗号化されたパスワードを扱うことを前提としてるので、暗号化しないと登録はできてもログインできない。)
        $NewUser->password = Hash::make($request['password']);

        //カラム status に1(有効)を固定値で渡す
        $NewUser->status = 1;
        
        // インスタンスの状態をデータベースに書き込む(save()は単なる上書きでなく、差分上書き。差分がなければ更新されない。)
        $NewUser->save();
    
        return redirect()->route('user.index', [
            'id' => $NewUser->id,
        ]);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showEditForm(Request $id)
    {
        $user_info = User::find($id->id);

        return view('user.edit', [
            'user' => $user_info,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EditUser $request)
    {
        // ユーザーモデルのインスタンスをキーで呼び出す(SQL投げるから当然キーじゃないと見つからない。見つからないとデータ形式が相違するからsave()もupdate()もできない。)
        $EditUser = User::find($request->id);
        // 各カラムに入力された値を代入する
        $EditUser->name = $request->name;
        $EditUser->email = $request->email;
        $EditUser->status = $request->status;

        //入力値を暗号化してから代入する(Authが暗号化されたパスワードを扱うことを前提としてるので、暗号化しないと登録はできてもログインできない。)
        $EditUser->password = Hash::make($request['password']);
        
        // インスタンスの状態をデータベースに書き込む(save()は単なる上書きでなく、差分上書き。差分がなければ更新されない。更新処理の場合updated_atは自動更新される。)
        $EditUser->save();
    
        return redirect()->route('user.index', [
            'id' => $EditUser->id,
        ]);
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
        //dd($id->id);
        User::find($id->id)->delete();
        return redirect(route('user.index'));
    }
}
