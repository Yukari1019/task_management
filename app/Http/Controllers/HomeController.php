<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $auths = Auth::user();
        if (Auth::check()) {
        // ログイン済みのときの処理
            return view('home', [ 'auths' => $auths ]);
        } else {
        // ログインしていないときの処理
            return view('login');
        }
    }
    
    public function logout(){
        return Auth::logout();
    }
}
