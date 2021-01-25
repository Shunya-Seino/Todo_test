@extends('layout')

@section('content')
    <div class="container">
      <div class="row">
        <div class="col col-md-offset-3 col-md-6">
          <nav class="panel panel-default">
            <div class="panel-heading">既存ユーザー情報を変更する</div>
            <div class="panel-body">
              @if($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach($errors->all() as $message)
                      <li>{{ $message }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              <form
                action="{{ route('user.edit') }}"
                method="POST"
              >
                @csrf
                <div class="form-group">
                  <input type="hidden" class="form-control" name="id" id="id" value="{{ old('id', $user->id) }}" />
                  <label for="user_name">ユーザー名</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}" maxlength="32" />
                  <label for="user_address">メールアドレス</label>
                  <input type="text" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}" maxlength="255" />
                  <label for="user_password">パスワード</label>
                  <input type="text" class="form-control" name="password" id="password" maxlength="32" />
                  <label for="user_password_confirmation">パスワード(確認)</label>
                  <input type="text" class="form-control" name="password_confirmation" id="password_confirmation" maxlength="32" /><br>
                  <label for="password_confirmation">アカウントの状態　</label>
                  {{ Form::select('status' , ['1' => '有効', '2' => '無効'] , 1) }}
                </div>
                <div class="text-left">
                  <button type="submit" class="btn btn-primary">更新</button>
                  <a href="{{ route('user.index') }}" class="btn btn-default">一覧画面に戻る</a>
                </div>
              </form>
            </div>
          </nav>
        </div>
      </div>
    </div>
    @endsection