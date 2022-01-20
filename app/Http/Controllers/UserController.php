<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
   public function index()
   {
      $users = User::all();
      $data= ['users' => $users];
      return response()->json($data);
   }

  /*  public function index(Request $request)
   {
      if (Auth::check()){

         $users = User::orderBy('created_at', 'desc')->with(['role']);
         $roles = Role::all();

         if($request->has('fio') && $request->fio != null){
            $users->where('first_name', 'like', "%$request->fio%")->orWhere('middle_name', 'like', "%$request->fio%")->orWhere('last_name', 'like', "%$request->fio%");
         }

         if($request->has('login') && $request->login != null){
            $users->where('name', 'like', "%$request->login%");
         }

         if($request->has('operator') && $request->operator != null){
            $users->where('operator', 'like', "%$request->operator%");
         }
         if($request->has('role') && $request->role != null){
            $users->where('role_id', '=', "$request->role");
         }

         if($request->has('email') && $request->email != null){
            $users->where('email', '=', "$request->email");
         }
         $users = $users->paginate(10);
         $data = [
            'users' => $users,
            'roles' => $roles
         ];
         return response()->json($data);
      }
   }
 */
   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $institutions = Institution::where('isactive','=','YES')->get();
      return view("users.create", ['institutions' => $institutions]);
   }  

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
     /*  $validation = Validator::make($request->all(),[
         'first_name' => 'required',
         'last_name' => 'required', 
         'role_id' => 'required',
         'email' => 'required|string|unique:users|email',
         'password' => 'required|confirmed|min:8'
      ]);
      if ($validation->fails()) {
         return response()->json([
            'success' => false,
            'result' => $validation->getMessageBag()->all()
         ]);
      } */
    
         $user = User::create([
            'name' => $request->input('name'),
            'firstname' => $request->input('first_name'),         
            'lastname' => $request->input('last_name'),
            'email' => $request->input('email'),
            'role'=>$request->input('role'),
            'phone'=> $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'status'=>$request->input('status')
                     ]);
         /* if($user){
            $user->role()->attach($request->input('role_id'));
            return response()->json( $user);
         
      } */
   } 
   /**
   * Display the specified resource.
   *
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
      $user = User::find($id);
    
       $roles=[  
               [ 'id' => 1,
                 'name' => "Оператор"],
               [ 'id' => 2,
                 'name' => "Администратор"],
               [ 'id' => 3,
                 'name' => "Исполнитель"]
            ];
      $data = [  'user'=>$user,
                 
                 'roles'=> $roles];
      return response()->json($data);     
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      $user = User::find($id);
      $institutions = Institution::where('isactive','=','YES')->get();
      $data= ['user'=>$user, 'institutions' => $institutions];
      return response()->json($data);
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id)
   {  $user = User::find($id);
     
      $current_password = $user->password;
      $pass = $request->input('password');
      if($pass != null){
         $password = Hash::make($pass);
      }else{
         $password = $current_password;
      }
     


    
      $user ->update([
         'name' => $request->input('name'),
         'firstname' => $request->input('firstname'),      
         'lastname' => $request->input('lastname'),
         'email' => $request->input('email'),
         'phone' => $request->input('phone'),
         'status'=>$request->input('status'),
         'password' => $password,

      ]);
      //$user->role()->attach($request->input('role_id'));
      $user->role()->sync([$request->input('role')]);

     /*  if($userUpdate){
         return redirect()->route('users.show', ['user'=>$user->id])
         ->with('success', 'User updated successfully');
      }

      if(!$validator){
         return redirect()->back()->withErrors($validator)->withInput(Input::all());
      } */
      return response()->json($user);

   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
   public function destroy( $id)
   {
      $users = User::find($id);
        $users->delete();  
        return response()->json($users);
   }


}
