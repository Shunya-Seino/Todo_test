@extends('layout')

@section('content')
    <div class="container">
      <div class="row">
        <div class="col col-md-offset-3 col-md-6">
          <nav class="panel panel-default">
            <div class="panel-heading">新規ユーザーを追加する</div>
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
              <form action="{{ route('user.create') }}" method="post">
                @csrf
                <div class="form-group">
                  <label for="user_name">ユーザー名</label>
                  <input type="text" class="form-control" name="name" id="name" maxlength="32" value="{{ old('name') }}" />
                  <label for="user_address">メールアドレス</label>
                  <input type="text" class="form-control" name="email" id="email" maxlength="255" value="{{ old('email') }}" />
                  <label for="user_password">パスワード</label>
                  <input type="text" class="form-control" name="password" id="password" maxlength="32" />
                  <label for="user_password_confirmation">パスワード(確認)</label>
                  <input type="text" class="form-control" name="password_confirmation" id="password_confirmation" maxlength="32" />
                </div>
                <div class="text-left">
                  <button type="submit" class="btn btn-primary">登録</button>
                  <a href="{{ route('user.index') }}" class="btn btn-default">一覧画面に戻る</a>
                </div>
              </form>
            </div>
          </nav>
        </div>
      </div>
    </div>
    @endsection