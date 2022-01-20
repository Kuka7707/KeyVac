<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
   protected $fillable = [
      'name', 'created_at', 'description', 'project', 'owner', 'executor', 'project_id', 'files'
      
   ];
   public function user()
   {
        return $this->belongsTo('App\User', 'owner','executor');
     }
}
