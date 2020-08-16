@extends('layout')

@section('content')
<body>
    <h1 style='width:80%;'>{{ $message }}</h1>
    <div class='wrapper'>
        <table class='table table-striped table-hover',  style='margin:7px'>
            <thead>
    			<tr>
    				<th>No.</th>
    				<th>日付</th>
    				<th>担当弁護士</th>
    				<th>事件番号</th>
    				<th>依頼者</th>
    				<th>タイトル</th>
    				<th>担当事務</th>
    				<th>期限</th>
    			</tr>
    		</thead>
    		
            @foreach($tasks as $task)
            <tr>
                <td><a  href='{{route('task.show', [ 'id'=>$task->id ]) }}' style='display:block' >
                    {{ $task->id}}</a>
                </td>
                <td><?php $updated_at =  $task->updated_at;
                        echo date('Y/m/d', strtotime($updated_at)) ?>
                </td>
                <td>{{$task->lawyer_initial}}</td>
                <td>{{$task->case_number}}</td>
                <td>{{$task->client_name}}</td>
                <td>{{$task->title}}</td>
                <td><?php 
                    if($task->staff_name=='null'){
                        echo '';
                    }else{
                        echo $task->staff_name."  ";
                    } ?>
                </td>
                <td>{{$task->deadline}}</td>
            </tr>
            @endforeach
            <script>
                $("table").on("click", "tr", function(e) {
                    if ($(e.target).is("a,input")) // anything else you don't want to trigger the click
                        return;

                    location.href = $(this).find("a").attr("href");
                });
            </script>
        </table>
        <div style='width:20%;'>
            <form action= {{ route('task.mypage')}} method="get">
            {{ csrf_field() }}
                <div style='margin:7px'>
                    <p>キーワード検索：</p>
                    <div class="radioArea" id="makeImg">
                      <input type="radio" name="n1" id="r1" checked><label for="r1">未処理</label><br>
                      <input type="radio" name="n1" id="r2" value=3><label for="r2">処理済み</label>
                    </div>
                    
                    <input name="updated_at" type="date" style="width:238px"><br>
                    <input type='text' name='case_number' placeholder='事件番号'><br>
                    <input type='text' name='client_name' placeholder='依頼者名'><br>
                    <input type='text' name='title' placeholder='タイトル'><br>
                    <input type='text' name='staff_name' placeholder='担当事務'><br>
                    <button type='submit' class='btn btn-outline-primary' style='margin:5px'>検索</button>
                    <a href={{ route('task.mypage') }} style='margin:7px'>クリア</a>
                </div>
            </form>
        </div>
    </div>
    <br>
    <a href= {{ route('task.list') }}>一覧に戻る</a>
</body>    
@endsection