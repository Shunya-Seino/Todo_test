<?php
  $status = ['有効' => 1, '無効' => 2];
  $empty_chk = "no data";
  $page_values = '10';

  if(!empty($input_info->page_values)){
    $page_values = $input_info->page_values;
  }
?>

@extends('layout')
  @section('content')
  <div class="center-block">
    <div class="container">
      <div class="row">
        <div class="panel panel-default">
          <div class="panel-heading"><h3>ユーザー一覧</h3></div>
          @if($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach($errors->all() as $message)
                  <li>{{ $message }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form action="{{url('/user/list')}}" method="GET">
            <p>ユーザー名<input type="text" class="form-control" name="name_keyword" maxlength="32" value="{{ old('name_keyword', $input_info->input('name_keyword')) }}" /></p>
            <p>メールアドレス<input type="text" class="form-control" name="address_keyword" maxlength="255" value="{{ old('email_keyword', $input_info->input('address_keyword')) }}" /></p>
            <p>アカウントの状態 {{ Form::select('account_status' , ['1' => '有効', '2' => '無効'], $input_info->input('account_status') ) }} </p>
            <p><input type="submit" class="btn btn-success" value="検索"></p>
          <div class="panel-body">
            <a href="{{ route('user.create') }}" class="btn btn-default">
              <h5>新規ユーザーを追加する</h5>
            </a>
            <a href="{{ route('menu') }}" class="btn btn-default">
              <h5>メニュー画面に戻る</h5>
            </a>
          </div>
          @foreach($users as $user)
           <p hidden>{{ $empty_chk = $user->name }}</p>
           @break
          @endforeach

          @if($empty_chk === "no data")
            <h5>登録されているデータがありません。</h5>
          @else
          <table style="table-layout:fixed;" class="table table-striped">
            <thead>
              <tr>
                <th><h5>@sortablelink('name','ユーザー名')</h5></th>
                <th><h5>@sortablelink('email','メールアドレス')<h5></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
                <tr>
                  <td><pre>{{ $user->name }}</pre></td>
                  <td><pre>{{ $user->email }}</pre></td>
                  <div class="text-right">
                  <td><a href="{{ route('user.edit', ['id' => $user->id]) }}"  class="btn btn-primary">編集</a></td>
                  <td>
                  <form action="{{ route('user.destroy', ['id' => $user->id]) }}" method="post" class="float-right">
                    @csrf
                    <input type="submit" value="削除" class="btn btn-danger" onclick='return confirm("削除してもよろしいですか？");'>
                  </form>
                  </td>
                  </div>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-left">
            {{ Form::select('page_values' , ['10' => '1ページ10件表示', '20' => '1ページ20件表示', '30' => '1ページ30件表示', '40' => '1ページ40件表示', '50' => '1ページ50件表示'], $page_values ) }}
            <input type="submit" value="一覧の更新" class="btn btn-primary">
            {{ $users->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
          </div>
          </form>
          @endif
        </div>
      </div>
    </div>
  </div>
  @endsection

  