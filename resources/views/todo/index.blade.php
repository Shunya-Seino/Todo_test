<?php
  $status = ['有効' => 1, '無効' => 2];
  $empty_chk = "no data";
  
  $todo_statuses = array( 1 => '未着手', 2 => '着手中', 4 => '保留中' );
  $saved_todo_statuses = array( 1 => '未着手', 2 => '着手中', 4 => '保留中' );

  if(!empty($input_info->todo_statuses)){
    foreach($input_info->todo_statuses as $status){
      $saved_todo_statuses[$status] = "";
    }
  }

  $page_values = '10';

  if(!empty($input_info->page_values)){
    $page_values = $input_info->page_values;
  }
?>

  @extends('layout')

  @section('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
  @endsection
  
  @section('content')
  <div class="center-block">
    <div class="container">
      <div class="row">
        <div class="panel panel-default">
          <div class="panel-heading"><h3>Todo一覧</h3></div>
          @if($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach($errors->all() as $message)
                  <li>{{ $message }}</li>
                @endforeach
              </ul>
            </div>
          @endif
            <form action="{{url('/todo/list')}}" method="GET">
              </br><p>　タイトル</br><input type="text" class="form-control" name="title" id="title" maxlength="32" value="{{ old('title', $input_info->input('title')) }}" /></p></br>
              <p>　詳細内容</br><input type="text" class="form-control" name="detail" id="detail" maxlength="1024" value="{{ old('detail', $input_info->input('detail')) }}" /></p></br>
              
              <div class="form-inline">
                <p>　開始日</br><input type="text" class="form-control" name="start_date_from" id="start_date_from" value="{{ old('start_date_from', $input_info->input('start_date_from')) }}" />　～　<input type="text" class="form-control" name="start_date_to" id="start_date_to" value="{{ old('start_date_to', $input_info->input('start_date_to')) }}" /></p></br>
                <p>　期限日</br><input type="text" class="form-control" name="due_date_from" id="due_date_from" value="{{ old('due_date_from', $input_info->input('due_date_from')) }}" />　～　<input type="text" class="form-control" name="due_date_to" id="due_date_to" value="{{ old('due_date_to', $input_info->input('due_date_to')) }}" /></p></br>
              </div>
              <p>　状態　
              @foreach ( $todo_statuses as $i => $todo_status )
                {{ Form::checkbox( 'todo_statuses[]', $i, !in_array( $todo_statuses[$i],$saved_todo_statuses ),['class' => 'md-check', 'id' => $todo_status] ) }}
                {{ Form::label($todo_status,  $todo_status) }}
              @endforeach
              </p>
              <p>　<input type="submit" class="btn btn-success" value="検索"></p>
            <div class="panel-body">
              <a href="{{ route('todo.create') }}" class="btn btn-default">
                <h5>新規のTodoを追加する</h5>
              </a>
              <a href="{{ route('menu') }}" class="btn btn-default">
                <h5>メニュー画面に戻る</h5>
              </a>
            </div>
            @foreach($todos as $todo)
              <p hidden>{{ $empty_chk = $todo->title }}</p>
             @break
            @endforeach
            @if($empty_chk === "no data")
              <h5>登録されているデータがありません。</h5>
            @else
            <table style="table-layout:fixed;" class="table table-striped">
              <thead>
                <tr>
                  <th><h5>Todo番号</h5></th>
                  <th><h5>@sortablelink('title','タイトル')</h5></th>
                  <th><h5>@sortablelink('detail','詳細内容')<h5></th>
                  <th><h5>@sortablelink('start_date','開始日')<h5></th>
                  <th><h5>@sortablelink('due_date','期限日')<h5></th>
                  <th><h5>@sortablelink('status','状態')<h5></th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($todos as $todo)
                  <tr>
                    <td><pre>{{ $todo->id }}</pre></td>
                    <td><pre>{{ $todo->title }}</pre></td>
                    <td><pre>{{ $todo->detail }}</pre></td>
                    <td><pre>{{ $todo->start_date }}</pre></td>
                    <td><pre>{{ $todo->due_date }}</pre></td>
                    <td><pre><span class="label {{ $todo->status_class }}">{{ $todo->status_label }}</span></pre></td>
                    <div class="text-right">
                    <td><a href="{{ route('todo.edit', ['id' => $todo->id]) }}"  class="btn btn-primary">編集</a></td>
                    <td>
                    <form action="{{ route('todo.destroy', ['id' => $todo->id]) }}" method="post" class="float-right">
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
                {{ $todos->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
            </div>
            </form>
            @endif
          </div>  
        </div>
      </div>
    </div>
  </div>
  @endsection

  @section('scripts')
    <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
    <script>
    flatpickr(document.getElementById('start_date_from'), {
      locale: 'ja',
      dateFormat: "Y/m/d"
    });
    </script>
    <script>
    flatpickr(document.getElementById('start_date_to'), {
      locale: 'ja',
      dateFormat: "Y/m/d"
    });
    </script>
    <script>
    flatpickr(document.getElementById('due_date_from'), {
      locale: 'ja',
      dateFormat: "Y/m/d"
    });
    </script>
    <script>
    flatpickr(document.getElementById('due_date_to'), {
      locale: 'ja',
      dateFormat: "Y/m/d"
    });
    </script>
    
  </script>
  @endsection