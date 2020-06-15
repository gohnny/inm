<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'status_id',
        'created_by_user_id',
        'assign_user_id',
    ];

    public $timestamps = true;

}
