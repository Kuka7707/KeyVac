<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Projects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('created_at');         
            $table->string('status');
            $table->text('description');
            $table->string('admin');
            $table->json('participants');
           
          
         });
       
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
        //
    }
}
