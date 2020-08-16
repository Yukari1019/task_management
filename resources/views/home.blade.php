@extends('layouts/app')

@section('content')
<!--<div class="user_id">-->
<!--{{ Auth::id() }}-->
<!--</div>-->


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">システムからのメッセージ</div>
                <div class="card-body">
                    @auth
                          <p>前回、ログインされたままページが閉じられました。</p>
                          <p>ログアウトしてから、ログインし直してください。</p>
                    @endauth
                    
                    @guest
                        <p>表示されているべきでない。</p>
                    @endguest
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
