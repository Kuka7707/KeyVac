<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   /**
   * Seed the application's database.
   *
   * @return void
   */
  
   public function run()
   {
      DB::table('users')->insert([
          [
            'email' => 'erzhan.hype@gmail.com',
            'phone' => '+77085943448',
            'password' => bcrypt('password'),
            'status' => "ACTIVE",
            'name' => 'Admin',
            'lastname' => 'Shaldybayev',
            'firstname' => 'Erzhan',

         ], 
         [
            'email' => 'kamila.tuleubayeva@gmail.com',
            'phone' => '+77751274134',
            'password' => bcrypt('root'),
            'status' => "ACTIVE",
            'name' => 'Admin',
            'lastname' => 'Tuleubayeva',
            'firstname' => 'Kamila',
            'gender'=> 'Female',
         ]
      ]);
      

      DB::table('user_roles')->insert([
         [
            "role_id"=>1,
            "user_id"=>1,
         ],
      ]);

      DB::table('roles')->insert([
         [
            "name"=>"Администратор",
            'edit' => 1,
            'read' => 1,
            'delete' => 1,
         ],

         [
            "name"=>"Техническая поддержка",
            'edit' => 0,
            'read' => 1,
            'delete' => 0,
         ],

         [
            "name"=>"Административный отдел",
            'edit' => 0,
            'read' => 1,
            'delete' => 0,
         ],
      ]);
      DB::table('projects')->insert([
         [
            'name' => 'CRM',
            'description' =>'new project',
            'status'=>'В работе',
            'admin' =>'Kamila',
         
            
         ]
      ]);
      DB::table('users_statuses')->insert([
         [
            "name" => "ACTIVE", 
         ],
         [
            "name" => "INACTIVE",
         ]
      ]);
      DB::table('genders')->insert([
         [
            "name" => "Male", 
         ],
         [
            "name" => "Female",
         ]
      ]);
      
}
}
