<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Comment;
use App\User;
class CommentController extends Controller
{
    //
    public function index()

    {
        $comments= Comment::with(['user'])->get();   
        
        $data=[
            'comments'=>$comments 
        ];
        return response()->json($data);
        
    }
    public function store(Request $request){
        $comments = new Comment;
        $comments->comment = $request->input('comment');
        $comments->user_id = $request->input('user_id');
        $comments->task_id = $request->input('task_id');
        $comments->save();
    }
    public function show($task_id)
    {
        $comments = Comment::find($task_id);
        $data = [
           'comments'=>$comments
        ];
        return response()->json($data);
    }
   
    public function update(Request $request, $id)
    {
        $comments = Comment::find($id);
        $comments->comment = $request->get('comment');
        $data = [
            'comments' => $comments
         ];
         return response()->json($data);
    }
    public function destroy($id)
    {
        $comments = Comment::find($id);
        $comments->delete();  
        return response()->json($comments);
    }

}
