@extends('layout')

@section('content')
<body>
    <h1>{{ $message }}</h1>
    <form action = {{ route('task.update', ['id'=>$task->id]) }} method='post'>
        {{ csrf_field() }}
        <div class='container'>
            <div class='row'>
                <div class='col-sm-3'></div>
                <div class='col-sm-6'>
                    <div class='form-group'>
                        <label>担当弁護士：</label>
                        <input type='text' name='lawyer_initial' value="{{ $task->lawyer_initial }}">
                    </div>
                    <div class='form-group'>
                        <label>事件番号　：</label>
                        <input type='text' name='case_number' value= "{{ $task->case_number }}">
                    </div>
                    <div class='form-group'>
                        <label>依頼者名　：</label>
                        <input type='text' name='client_name' value= "{{ $task->client_name }}">
                    </div>
                    <div class='form-group'>
                        <label>タイトル　：</label>
                        <input type='text' name='title' value= "{{ $task->title }}">
                    </div>
                    <div class='form-group'>
                        <label>内　　容　：</label>
                        <textarea type='text' name='content'>{{ $task->content }}</textarea>
                    </div>
                    <div class='form-group'>
                        <label>締め切り　：</label>
                        <input type='text' name='deadline' value= "{{ $task->deadline }}">
                    </div>
                    <div class='form-group'>
                        <button type='submit' class='btn btn-primary'>保存する</button>
                        <a href= {{ route('task.show', ['id'=>$task->id]) }}>キャンセル</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

