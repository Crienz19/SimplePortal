<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicRequirement extends Model
{
    protected $fillable = [
        'user_id',
        'requirement_id',
        'status',
        'path'
    ];
}
