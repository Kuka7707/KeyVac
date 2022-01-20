<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up()
   {
      Schema::create('tasks', function (Blueprint $table) {
         $table->id();
         $table->string('name')->nullable();
         $table->text('description')->nullable();
         $table->string('executor_uid');
         $table->string('co_executor_uid')->nullable();
         $table->integer('owner_uid')->unsigned();
         $table->integer('status_id')->unsigned();
         $table->string('project_id')->nullable();
         $table->date('end');
         $table->file('files');
         $table->string('unit');
         $table->timestamps();
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down()
   {
      Schema::dropIfExists('tasks');
   }
}
