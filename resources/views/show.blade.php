@extends('layout')

@section('content')
<body>
    <h1>{{ $message }}</h1>
    <div class='container'>
        <div class='row'>
            <div class='col-sm-3'></div>
            <div class="col-sm-6">
                <div class='form-group'>
                    <p>No.{{ $task->id." "}}
                        <?php $updated_at =  $task->updated_at;
                                echo date('Y/m/d', strtotime($updated_at)) ?>
                        {{$task->lawyer_initial." "}}</p>
                    <p>事件番号：{{$task->case_number}}
                       {{$task->client_name}}</p>
                    <p>タイトル：{{$task->title}}</p>
                    <p>内　　容：{{$task->content}}</p>
                    <p>期　　限：{{$task->deadline}}</p>
                    @if($task->status == 1)
                        <div style="display:inline-flex">
                            <form action = {{ route('task.doing', ['id'=>$task->id]) }} method='post'>
                            {{ csrf_field() }}
                                <input type='hidden' name='staff_name' value='{{Auth::user()->name}}'>
                                <input type='hidden' name='status' value=2>
                                <button type='submit' class='btn btn-primary'>処理する</button>
                            </form>
                            <a class='btn btn-outline-primary' href= {{ route('task.edit', ['id'=>$task->id]) }}>編集する</a>
                            <a class='btn btn-outline-primary' href= {{ route('task.delete', ['id'=>$task->id]) }}  onclick="clickEvent()">削除する</a>
                            <script>
                                function clickEvent() {
                                    let result = confirm('削除しますか？');
                                    if( result ) {
                                        console.log('削除しました');
                                    } else {
                                        console.log('キャンセルしました');
                                    }
                                }
                            </script>
                        </div>
                    @elseif($task->status == 2 && $task->staff_name == Auth::user()->name)
                        <div style="display:inline-flex">
                            <form action = {{ route('task.doing', ['id'=>$task->id]) }} method='post'>
                                {{ csrf_field() }}
                                <input type='hidden' name='staff_name' value=null>
                                <input type='hidden' name='status' value=1>
                                <button type='submit' class='btn btn-primary'>処理しない</button>
                            </form>
                            <form action = {{ route('task.done', ['id'=>$task->id]) }} method='post'>
                                {{ csrf_field() }}
                                <input type='hidden' name='status' value=3>
                                <button type='submit' class='btn btn-primary'>処理ずみ</button>
                            </form>
                            <a class='btn btn-outline-primary' href= {{ route('task.edit', ['id'=>$task->id]) }}>編集する</a>
                            <a class='btn btn-outline-primary' href= {{ route('task.delete', ['id'=>$task->id]) }}  onclick="clickEvent()">削除する</a>
                            <script>
                                function clickEvent() {
                                    let result = confirm('削除しますか？');
                                    if( result ) {
                                        console.log('削除しました');
                                    } else {
                                        console.log('削除しませんでした');
                                    }
                                }
                            </script>
                        </div>
                    @elseif($task->status == 2 && $task->staff_name != Auth::user()->name )
                        <h3>！！{{$task->staff_name}}さんが処理中です！！</h3>
                    @elseif($task->status==3)
                        <h3>処理済みです</h3>
                    @endif
                    <br>
                    <a href= {{ route('task.list') }}>一覧に戻る</a>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection