<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    // 主キーの設定
    protected $primaryKey = [
        'following_id',
        'followed_id'
    ];

    // 変更を許可する
    protected $fillable = [
        'following_id',
        'followed_id'
    ];

    public $timestamps = false;
    
    // AutoIncrementではないのでfalse
    public $incrementing = false;

    // フォローしているユーザー数
    public function getFollowCount(Int $user_id)
    {
        return $this->where('following_id', $user_id)->count();
    }

    // フォローされているユーザー数
    public function getFollowerCount(Int $user_id)
    {
        return $this->where('followed', $user_id)->count();
    } 
}
