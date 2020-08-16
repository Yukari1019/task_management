<div class='left-column'>
    <a class='btn btn-primary' href={{ route('task.new')}}>新規作成</a>
</div>
<div class='right-column'>
    <form action= {{ route('task.list')}} method="get">
        {{ csrf_field() }}
        <label>キーワード：</label>
        <input type='text' name='keyword'>
        <button type='submit' class='btn btn-outline-primary'>検索</button>
        <a href={{ route('task.list') }}>クリア</a>
    </form>
</div>

             