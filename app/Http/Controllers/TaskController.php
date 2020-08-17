<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request);
        //$request = Input::get('request');
        $input = $request->all();
        //dd($input);
        
        //if($request->has('lawyer_initial','case_number','client_name','title','staff_name')){
        if(!empty($input['from']) || !empty($input['to']) || !empty($input['lawyer_initial']) || !empty($input['case_number']) || !empty($input['client_name']) || !empty($input['title']) || !empty($input['staff_name'])){
            
            if(empty($input['from']) && empty($input['to'])){
                
                $message = '検索結果画面';
                $query = Task::query();
                
                foreach ($request->only(['lawyer_initial','case_number','client_name','title', 'staff_name']) as $key => $value) {
                    $query->where($key, 'like', '%'.$value.'%');
                }
                
                if($request->n1==="3"){
                $query->where('status','=',$request->n1);
                } else {
                $query->where(function($query){
                    $query->orWhere('status','=',1)
                          ->orWhere('status','=',2);
                    });
                }
                
            } else {
                
                $message = '検索結果画面';
                $query = Task::query();
                
                foreach ($request->only(['lawyer_initial','case_number','client_name','title', 'staff_name']) as $key => $value) {
                    $query->where($key, 'like', '%'.$value.'%');
                }
                
                $from[0] = $request->from;
                $to[0] = $request->to;
                $query->whereBetween('updated_at', [$from[0], $to[0]]);
                
                if($request->n1==="3"){
                    $query->where('status','=',$request->n1);
                } else {
                    $query->where(function($query){
                        $query->orWhere('status','=',1)
                              ->orWhere('status','=',2);
                    });
                
                }
                
            }
            $tasks = $query->get();
           //$tasks = $query->toSql();
           //$a = $query->getBindings();
           //dd($tasks, $a);
            
        //} elseif($request->has('from','to')) {
        // } elseif(!empty($input['from']) || !empty($input['to'])) {
        //     $message = '検索結果画面';
        //     $from[0] = $request->from;
        //     $to[0] = $request->to;
        //     $tasks = Task::whereBetween('updated_at', [$from[0], $to[0]])->get();
            
        } else {
            $message = 'タスク一覧画面';
            $tasks = Task::where(function($query){
                $query->orWhere('status','=',1)
                      ->orWhere('status','=',2);
            })->get();
        }
        return view('index', ['message' => $message, 'tasks' => $tasks]);
    }
        
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $message = "新規タスク作成画面";
        return view('new',['message'=>$message]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new Task();
        
        $task->lawyer_initial= $request->lawyer_initial;
        $task->case_number=$request->case_number;
        $task->client_name=$request->client_name;
        $task->title=$request->title;
        $task->content=$request->content;
        $task->status= 1;
        $task->deadline=$request->deadline;
        $task->staff_name = "";
        $task->save();
        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, Task $task)
    {
        $message = "タスク詳細画面";
        $task = Task::find($id);
        return view('show', ['message'=>$message, 'task'=>$task]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id, Task $task)
    { 
        $message = "編集画面";
        $task = Task::find($id);
        return view('edit', ['message'=>$message, 'task'=>$task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Task $task)
    {
        $task=Task::find($id);
        $task->lawyer_initial=$request->lawyer_initial;
        $task->case_number=$request->case_number;
        $task->client_name=$request->client_name;
        $task->title=$request->title;
        $task->content=$request->content;
        $task->deadline=$request->deadline;
        $task->save();
        return redirect()->route('task.show', ['id' => $task->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, Task $task)
    {
        $task = Task::find($id);
        $task->delete();
        return redirect('/tasks');
    }
    
    public function doing(Request $request, $id, Task $task)
    {
        $task=Task::find($id);
        $task->staff_name=$request->staff_name;
        $task->status=$request->status;
        $task->save();
        return redirect()->route('task.list');
    }
    
    public function done(Request $request, $id, Task $task)
    {
        $task=Task::find($id);
        $task->status=$request->status;
        $task->save();
        return redirect()->route('task.list');
    }
    
    public function mypage(Request $request, Task $task)
    {
        $name = Auth::user()->name;
        $division = Auth::user()->division;
        //dd($division);
        $input = $request->all();
        
        if($division==1){
            
            // if($request->has('updated_at', 'case_number','client_name','title','staff_name')){
            //     $message = $name.'の処理：検索結果画面';
            //     $query = Task::query();
            //     $query->where('lawyer_initial', '=', $name);
            //     foreach ($request->only(['updated_at','case_number','client_name','title', 'staff_name']) as $key => $value) {
            //         $query->where($key, 'like', '%'.$value.'%');
            //     }
                
            //     if($request->n1==="3"){
            //         $query->where('status','=',$request->n1);
            //     } else {
            //         $query->where(function($query){
            //             $query->orWhere('status','=',1)
            //                   ->orWhere('status','=',2);
            //         });
                    
            //     }
            //     $tasks = $query->get();
           
            
            
            if(!empty($input['from']) || !empty($input['to']) || !empty($input['case_number']) || !empty($input['client_name']) || !empty($input['title']) || !empty($input['staff_name'])){
            
                if(empty($input['from']) && empty($input['to'])){
                    
                    $message = $name.'の指示：検索結果画面';
                    
                    $query = Task::query();
                    
                    $query->where('lawyer_initial', '=', $name);
                    
                    foreach ($request->only(['case_number','client_name','title', 'staff_name']) as $key => $value) {
                        $query->where($key, 'like', '%'.$value.'%');
                    }
                    
                    if($request->n1==="3"){
                    $query->where('status','=',$request->n1);
                    } else {
                    $query->where(function($query){
                        $query->orWhere('status','=',1)
                              ->orWhere('status','=',2);
                    });
                    }
                
                } else {
                    
                    $message = $name.'の指示：検索結果画面';
                    
                    $query = Task::query();
                    
                    $query->where('lawyer_initial', '=', $name);
                    
                    foreach ($request->only(['case_number','client_name','title', 'staff_name']) as $key => $value) {
                        $query->where($key, 'like', '%'.$value.'%');
                    }
                    
                    $from[0] = $request->from;
                    $to[0] = $request->to;
                    $query->whereBetween('updated_at', [$from[0], $to[0]]);
                    
                    if($request->n1==="3"){
                        $query->where('status','=',$request->n1);
                    } else {
                        $query->where(function($query){
                            $query->orWhere('status','=',1)
                                  ->orWhere('status','=',2);
                        });
                        
                    }
                }
                $tasks = $query->get();
            } else {
                $message = $name.'さんの指示タスク一覧';
                $tasks = Task::where('lawyer_initial','=',$name)
                        ->get();
            }
            return view('lawyer_mypage', ['message'=>$message, 'tasks'=>$tasks] );
            
        } elseif($division==2) {
            
            // if($request->has('updated_at', 'lawyer_initial','case_number','client_name','title')){
            //     $message = $name.'の処理：検索結果画面';
            //     $query = Task::query();
            //     $query ->where('staff_name', '=', $name);
            //     foreach ($request->only(['updated_at','lawyer_initial','case_number','client_name','title']) as $key => $value) {
            //             $query->where($key, 'like', '%'.$value.'%');
            //         }
                
            //     if($request->n1==="3"){
            //         $query->where(function($query){
            //             $query->where('status','=',3);
            //         });
            //     } else {
            //         $query->where(function($query){
            //             $query->orWhere('status','=',1)
            //                   ->orWhere('status','=',2);
            //         });
                    
            //     }
            //     $tasks = $query->get();
            
            
            
            if(!empty($input['from']) || !empty($input['to']) || !empty($input['lawyer_initial']) || !empty($input['case_number']) || !empty($input['client_name']) || !empty($input['title'])){
            //dd($input);
                
                if(empty($input['from']) && empty($input['to'])){
                    $message = $name.'の処理：検索結果画面';
                    
                    $query = Task::query();
                    
                    $query ->where('staff_name', '=', $name);
                    
                    foreach ($request->only(['lawyer_initial', 'case_number','client_name','title']) as $key => $value) {
                        $query->where($key, 'like', '%'.$value.'%');
                    }
                    
                    if($request->n1==="3"){
                    $query->where('status','=',$request->n1);
                    } else {
                    $query->where(function($query){
                        $query->orWhere('status','=',1)
                              ->orWhere('status','=',2);
                    });
                    }
                    
                } else {
                    
                    $message = $name.'の処理：検索結果画面';
                    
                    $query = Task::query();
                    
                    $query ->where('staff_name', '=', $name);
                    
                    foreach ($request->only(['lawyer_initial', 'case_number','client_name','title']) as $key => $value) {
                        $query->where($key, 'like', '%'.$value.'%');
                    }
                    
                    $from[0] = $request->from;
                    $to[0] = $request->to;
                    $query->whereBetween('updated_at', [$from[0], $to[0]]);
                    
                    if($request->n1==="3"){
                        $query->where('status','=',$request->n1);
                    } else {
                        $query->where(function($query){
                            $query->orWhere('status','=',1)
                                  ->orWhere('status','=',2);
                        });
                    }
                    
                }
                $tasks = $query->get();
                
            } else {
                $message = $name.'さんの処理タスク一覧';
                $tasks = Task::where('staff_name','=',$name)->get();
            }
            return view('staff_mypage', ['message'=>$message, 'tasks'=>$tasks] );
            
        } else {
            return view('errors');
        }
    }
}