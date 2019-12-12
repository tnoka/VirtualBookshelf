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
        'name', 'email', 'password','profile_image'
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

    // リレーション
    public function products()
    {
        return $this->hasMany('App\Product');
    }
    
    // 第1引数では最終的な接続先モデルを指定する
    // 第2引数では中間テーブル名を指定する
    // 第3引数では接続元モデルIDを示す中間テーブル内のカラムを指定する
    // 第4引数では接続先モデルIDを示す中間テーブル内のカラムを指定する
    public function followers()
    {
        return $this->belongsToMany(self::class, 'follow', 'followed_id', 'following_id');
    }

    public function follows()
    {
        return $this->belongsToMany(self::class, 'follow', 'following_id', 'followed_id');
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

    // フォローする
    public function follow(Int $user_id)
    {
        return $this->follows()->attach($user_id);
    }

    // フォローを解除する
    public function unFollow(Int $user_id)
    {
        return $this->follows()->detach($user_id);
    }
    // フォローしているか
    public function isFollowing(Int $user_id)
    {
        return(boolean) $this->follows()->where('followed_id', $user_id)->first(['id']);
    }

    // フォローされているか
    public function isFollowed(Int $user_id)
    {
        return(boolean) $this->followers()->where('following_id', $user_id)->first(['id']);
    }

}
