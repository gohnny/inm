<?php

namespace App;

use App\Models\Tasks;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use  HasApiTokens, Notifiable;

    protected $primaryKey = 'user_id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps = true;

    public function tasks()
    {
        return $this->belongsTo(Tasks::class, 'created_by_user_id', 'user_id');
    }

    public function assignedTask()
    {
        return $this->belongsTo(Tasks::class, 'assign_user_id', 'user_id');
    }

}
