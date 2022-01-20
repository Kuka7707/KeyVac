<?php

namespace App;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Project as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;



class Project extends Model
{
    use HasApiTokens, Notifiable;
    protected $table = 'projects';
	public $timestamps = true;
    protected $fillable = ['name', 'description', 'status','admin','project_id'];
    protected $casts = ['participants'=>'array'];
    public function user()
    {
         return $this->belongsTo('App\User', 'admin');
      }
      public function task()
    {
         return $this->belongsTo('App\Task', 'project_id');
      }
    
}
