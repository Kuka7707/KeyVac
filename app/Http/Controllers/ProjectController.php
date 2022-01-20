<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Project;
use App\Statuses;
use App\Task;
class ProjectController extends Controller
{
    //
    public function index()
    {
        $projects = Project::with(['task'])->get();
        $new = Project::where('status','=','2')->get();
        $doing = Project::where('status','=','1')->get();
        $done= Project::where('status','=','3')->get();

       
        $statuses = Statuses::all();
    /*     $jsonString= Project::with('participants');
        $cart =  json_decode(json_encode($jsonString),true);  */
        /* $cart = JSON.parse($jsonString ); */
        /* $members=DB::select('select projects.participants from projects');
        $cart = json_decode($members); */

        $data=[
            'projects'=>$projects,
            'status'=>$statuses,
             'new'=>$new,
             'doing'=>$doing,
             'done'=>$done  /* ,
            'cart'=>$cart */
            
        ];
        return response()->json($data);
    }    
    public function store(Request $request)
    {     
            $project = new Project;
            $project->name= $request->input('name');
            $project->status= $request->input('status');
            $project->description= $request->input('description');
            $project->admin= $request->input('admin');
            $project->participants=$request->input('participants');
                   
            $project->save();

               /* 
                'name' => $request->input('name'),
                'status' => $request->input('status'),                
                'description' => $request->input('description'),
                'admin' => $request->input('admin')  
            ]); */
       /*  $data =['project'=>$project];
        return response()->json($data); */

    }
    public function destroy($id){
        $project = Project::find($id);
        $project->delete();  
        return response()->json($project);

    }
    public function show($id)
   {
      $project = Project::find($id);/* ->with(['task'])->get() */
      $data = [
         'project'=>$project
      ];
      return response()->json($data);
   }
   public function update(Request $request, $id)
   {
      $project = Project::find($id);
      $project->name = $request->get('name');
      $project->status = $request->get('status');
      $project->description = $request->get('description');
     /*  $project->participants = $request->get(json_decode('participants',true)); */
     $project->participants = $request->get('participants');

      $project->admin = $request->get('admin');
      
      $project->save();
      $data = [
         'project' => $project
      ];

      return response()->json($data);
   }
   /* public function getCreatedAtAttribute($date)
{
    return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
} */

 
   
}
