@extends('layout')

@section('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
@endsection

@section('content')
    <div class="container">
      <div class="row">
        <div class="col col-md-offset-3 col-md-6">
          <nav class="panel panel-default">
            <div class="panel-heading">新規Todoを追加する</div>
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
              <form action="{{ route('todo.create') }}" method="post">
                @csrf
                <div class="form-group">
                  <label for="todo_title">タイトル名</label>
                  <input type="text" class="form-control" name="title" id="title" maxlength="32" value="{{ old('title') }}" />
                  <label for="todo_detail">詳細内容</label>
                  <input type="text" class="form-control" name="detail" id="detail" maxlength="1024" value="{{ old('detail') }}" />
                  <label for="todo_start_date">開始日</label>
                  <input type="text" class="form-control" name="start_date" id="start_date" value="{{ old('start_date') }}" />
                  <label for="todo_due_date">期限日</label>
                  <input type="text" class="form-control" name="due_date" id="due_date" value="{{ old('due_date') }}" />
                  <label for="status">状態</label>
                  <select name="status" id="status" class="form-control">
                    @foreach(\App\Models\Todo::STATUS as $key => $val)
                      <option value="{{ $key }}"{{ $key == old('status') ? 'selected' : '' }}>{{ $val['label'] }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="text-left">
                  <button type="submit" class="btn btn-primary">登録</button>
                  <a href="{{ route('todo.index') }}" class="btn btn-default">一覧画面に戻る</a>
                </div>
              </form>
            </div>
          </nav>
        </div>
      </div>
    </div>
    @endsection

    @section('scripts')
    <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
    <script>
      flatpickr(document.getElementById('start_date'), {
        locale: 'ja',
        dateFormat: "Y/m/d"
      });
    </script>
    <script>
      flatpickr(document.getElementById('due_date'), {
        locale: 'ja',
        dateFormat: "Y/m/d"
      });
    </script>
    @endsection