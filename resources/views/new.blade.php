@extends('layout')

@section('content')
<body>
    <h1>{{ $message }}</h1>
    <form action = {{route('task.store')}} method='post'>
        {{ csrf_field() }}
        <div class='container'>
            <div class='row'>
                <div class='col-sm-3'></div>
                <div class="col-sm-6">
                    <div class='form-group'>
                        <label>担当弁護士：</label>
                        <?php
                            $user=Auth::user()->division;
                        
                            if($user==1){ ?>
                                <input type='hidden' name='lawyer_initial' value={{ Auth::user()->name }}>
                                <span>{{ Auth::user()->name }}</span>
                        <?php
                            } else {
                        ?>
                        <select type='text' name='lawyer_initial'>
                            <option>佐藤海斗</option>
                            <option>鈴木翔</option>
                            <option>高橋凛</option>
                            <option>田中浩一</option>
                            <option>伊藤莉子</option>
                            <option>　　　　　　　　　　 </option>
                        </select>
                        <?php
                            }
                        ?>
                    </div>
                    <div style="display:inline-flex">
                        <div class='form-group'>
                            <label>事件番号　：</label>
                            <input type='text' name='case_number' placeholder='00-0000-00（半角）'>
                        </div>
                        <script>
                            /*$(function(){ // 遅延処理
                                $('#button').click(
                                    function() {
                                      let num = $("input[name='case_number']").val();
                                      $.ajax({
                                        headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: 'GET',
                                        url: '/post/' + num , // url: は読み込むURLを表す
                                        dataType: 'json',data:{name:num}, // 読み込むデータの種類を記入
                                          }).done(function (results) {
                                            // 通信成功時の処理
                                            // $('#text').html(results);
                                              alert(results);
                                          }).fail(function (errorThrown) {
                                              alert(errorThrown.message);
                                          });
                                    }
                                );
                            });*/
                            $(function (){
                                $('#button1').click(function(){
                                    let caseNo = $("input[name='case_number']").val();
                                    $.ajax({
                                        headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: '/postclient/',
                                        type: 'get',
                                        data: {
                                            "caseNo" : caseNo,
                                        },
                                        dataType : "json",
                                    })
                                    .then(
                                    function (data) { // 1つ目は通信成功
                                        let client = data.post; 
                                        
                                        // console.log(json);
                                        // let clientName = JSON.parse(json);
                                        
                                        $("input[name='client_name']").val(client);
                                        //console.log(client); //ここでJQueryをつかって、依頼者名のテキスト（client_name）に値をセット（今はデバック状態です）
                                    },
                                    function () { // 2つ目はエラー
                                        console.error("読み込み失敗");
                                    });
                                });
                            
                            });
                        </script>
                        <input style=height:50% type="button" id="button1" value="取得" >
                        <br>
                        <div id="text"></div>
                    </div>
                    <div class='form-group'>
                        <label>依頼者名　：</label>
                        <input type='text' name='client_name'>
                    </div>
                    <div style="display:inline-flex">
                        <div class='form-group'>
                            <label>タイトル　：</label>
                            <select type='text' name='title' class='mr-2' id='title'>
                                <option value="郵送処理">郵送処理</option>
                                <option value="誤字脱字チェック">誤字脱字チェック</option>
                                <option value="裁判所提出">裁判所提出</option>
                                <option value="各種資料取寄せ">各種資料取り寄せ</option>
                                <option value="その他">その他</option>
                                <option>　　　　　　　　　　 </option>
                            </select>
                        </div>
                        <script>
                            $(function () {
                                $('#button2').on('click', () => {
                                    let sam = document.getElementById("title").value;
                                    if(sam=="郵送処理"){
                                        $('textarea').html('○○を○○へ○通郵送してください。速度：速達　送り方：特定記録　宛先：　保存場所：');
                                    } else if(sam=="誤字脱字チェック") {
                                        $('textarea').text('サンプル２');
                                    } else if(sam=="裁判所提出") {
                                        $('textarea').text('サンプル２');
                                    } else if(sam=="各種資料取寄せ") {
                                        $('textarea').text('サンプル２');
                                    } else {
                                        $('textarea').text('');
                                    }
                                });
                            });
                        </script>
                        <input style=height:50% type="button" id="button2" value="取得" >
                        <br>
                    </div>
                    <div class='form-group'>
                        <label>内　　容　：</label>
                        <textarea type='text' name='content' id='content' class="imeauto input-block-level" rows='8'></textarea>
                    </div>
                    <div class='form-group'>
                        <label>締め切り　：</label>
                        <select type='text' name='deadline'>
                            <option>今日中</option>
                            <option>明日中</option>
                            <option>今週中</option>
                            <option>至急</option>
                            <option>要相談</option>
                            <option>　　　　　　　　　　 </option>
                        </select>
                    </div>
                    <div class='form-group'>
                        <button type='submit' class='btn btn-primary'>新規作成</button>
                        <a href= {{ route('task.list') }}>キャンセル</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

@endsection