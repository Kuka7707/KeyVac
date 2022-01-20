<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use App\Statuses;
use Illuminate\Http\Request;
/* use Image; */

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        $tasks= Task::all();
        $statuses =  Statuses::all();
        $data=[
            'tasks'=>$tasks,
            'status'=>$statuses
            
        ];
   
        
        return response()->json($data);
        
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
        $tasks = new Task;
        $tasks->name= $request->input('name');
        $tasks->status_id= $request->input('status_id');
        $tasks->executor_uid= $request->input('executor_uid');
        $tasks->co_executor_uid= $request->input('co_executor_uid'); 
        $tasks->description= $request->input('description');
        $tasks->owner_uid= $request->input('owner_uid');
        $tasks->project_id=$request->input('project_id');
        /* $tasks->files=$request->input('files');  */
       /*  $f = request('files');
      $files = '';
      if ($f != '') {
         $image = Image::make($f);
         $mime = $image->mime();
         $extension = explode('/', $mime)[1];
         $files = 'screen_'.substr(time(), 5)."." . $extension;
         $image->save(public_path('uploads'.$files));
      } */
      /*   $f =$request->input('files');
        $original_name= $f->getClientOriginalName() ;    
        
        $f->move(public_path('uploads'), $original_name); */
        /* $tasks->files= $files;  */
      /*   $f = request('file');
         $original_name= $f->getClientOriginalName() ;    
         $file_extension= $f->clientExtension() ;   
         $filename = time().'_'.$original_name.'.'.$file_extension;
         $f->move(public_path('uploads'), $original_name);
         $file_size =$request->file('file')->getClientSize();
      
       
            $file = new File;
            $file->user_id = Auth::user()->id;
            $file->folder_id = $request->input('folder_id');
            $file->filename = $request->input('filename');
            $file->file_type = $file_extension;
            $file->filesize = $file_size; 
            $file->path = 'uploads/'.$original_name; */
        $tasks->unit=$request->input('unit');
        $tasks->end = $request->input('end');
        $tasks->save();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tasks = Task::find($id);
        $data = [
           'tasks'=>$tasks
        ];
        return response()->json($tasks);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tasks = Task::find($id);
        $tasks->name= $request->get('name');
        $tasks->status_id= $request->get('status_id');
        $tasks->executor_uid= $request->get('executor_uid');
        $tasks->co_executor_uid= $request->get('co_executor_uid'); 
        $tasks->description= $request->get('description');
        $tasks->owner_uid= $request->get('owner_uid');
        $tasks->project_id=$request->get('project_id');
        $tasks->files=$request->get('files');
        $tasks->end=$request->get('end');
        $tasks->unit=$request->get('unit');
        $tasks->save();
        $data = [
           'tasks' => $tasks
        ];
  
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasks = Task::find($id);
        $tasks->delete();  
        return response()->json($tasks);
    }
}
