<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $visible = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    // ユーザー一覧取得（自分以外）
    public function getAllUsers(Int $user_id)
    {
        return $this->where('id', '<>', $user_id)->paginate(5);
    }

    public function destroyUser(Int $user_id)
    {
        return $this->where('id', $user_id)->delete();
    }

}
