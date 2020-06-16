<?php

namespace App\Models;

use App\User;
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

    public function createByUser()
    {
        return $this->hasOne(User::class, 'user_id', 'created_by_user_id');
    }

    public function assignedUser()
    {
        return $this->hasOne(User::class, 'user_id', 'assign_user_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }





}
