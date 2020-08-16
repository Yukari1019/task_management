<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    //public function show(Request $request, $id, Post $post)
    public function show(Request $request)
    {
        //logの出力先は /task_management/storage/logs/laravel-[日付].log
        //画面がない（jsonデータを戻している）のでddが使えないのです。。
        \Log::debug($request);
        
        //$post = Post::find($request, 'client_name')->where('case_number', $request)->get();
        //$post = Post::find($request['caseNo']);
        
        /*https://blog.capilano-fw.com/?p=665#i-2 こちらが参考になると思います。
        　今回やりたいSQLは select client_name from post where case_number = [request値]　です
        */
        $post = Post::select('client_name')->where('case_number', $request['caseNo'])->get();
        \Log::debug($post);
        
        $ret = $post[0]['client_name'];
        \Log::debug($ret);
        
        return response()->json(['post' => $ret]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
