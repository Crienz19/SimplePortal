<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPreliminary extends Model
{
   protected $fillable = [
       'user_id',
       'requirement_id',
       'status',
       'path'
   ];

   public function preliminary()
   {
       return $this->hasMany('App\Preliminary', 'requirement_id', 'id');
   }

   public function getById($id)
   {
       return $this->find($id);
   }
}
