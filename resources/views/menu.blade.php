@extends('layout')

@section('content')
<div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-default">
          <div class="panel-heading">
            <div class="text-center">
            ご利用の機能を選択してください
            </div>
          </div>
          <div class="panel-body">
            <div class="text-center">
              <a href="{{ route('user.index') }}" class="btn btn-primary">
                ユーザー管理ページへ
              </a>
            </div>
          </div>
          <div class="panel-body">
            <div class="text-center">
              <a href="{{ route('todo.index') }}" class="btn btn-primary">
                タスク管理ページへ
              </a>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection
