@extends('layout')

@section('content')
<body>
    <h1 style='width:80%;'>{{ $message }}</h1>
    <div class='wrapper'>
        <div class="container-fluid">
            <table class='table table-striped table-hover'>
                <thead>
        			<tr>
        				<th >No.</th>
        				<th >日付</th>
        				<th >担当弁護士</th>
        				<th >事件番号</th>
        				<th >依頼者</th>
        				<th >タイトル</th>
        				<th >担当事務</th>
        				<th >期限</th>
        			</tr>
        		</thead>
        		
                @foreach($tasks as $task)
                <tr>
                    <td><a  href='{{route('task.show', [ 'id'=>$task->id ]) }}' >
                        {{ $task->id}}</a>
                    </td>
                    <td><?php $updated_at =  $task->updated_at;
                            echo date('Y/m/d', strtotime($updated_at)); ?>
                    </td>
                    <td>{{$task->lawyer_initial}}</td>
                    <td>{{$task->case_number}}</td>
                    <td>{{$task->client_name}}</td>
                    <td>{{$task->title}}</td>
                    <td><?php 
                        if($task->staff_name=='null'){
                            echo '';
                        }else{
                            echo $task->staff_name;
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
        </div>
        <div style='width:20%;'>
            <a class='btn btn-primary' href={{ route('task.new')}} style="width:160px; margin:2px 7px"> 新規作成 </a><br>
            <p> </p>
            <form action= {{ route('task.list')}} method="get">
            {{ csrf_field() }}
                <div style='margin:7px'>
                    <p>キーワード検索：</p>
                    <div class="radioArea" id="makeImg">
                      <input type="radio" name="n1" id="r1" checked><label for="r1">未処理</label><br>
                      <input type="radio" name="n1" id="r2" value=3><label for="r2">処理済み</label>
                    </div>
                    
                    <input type="text" placeholder="年/月/日から" name='from' type="date" style="width:238px" onfocus="(this.type='date')" onblur="(this.type='text')" >
                    <input type="text" placeholder="年/月/日まで" name='to' type="date" style="width:238px" onfocus="(this.type='date')" onblur="(this.type='text')" >
                    <input type='text' name='lawyer_initial' placeholder='担当弁護士'><br>
                    <input type='text' name='case_number' placeholder='事件番号'><br>
                    <input type='text' name='client_name' placeholder='依頼者名'><br>
                    <input type='text' name='title' placeholder='タイトル'><br>
                    <input type='text' name='staff_name' placeholder='担当事務'><br>
                    <button type='submit' class='btn btn-outline-primary' style='margin:5px'>検索</button>
                    <a href={{ route('task.list') }} style='margin:7px'>クリア</a>
                </div>
            </form>
        </div>
    </div>
</body>    

@endsection