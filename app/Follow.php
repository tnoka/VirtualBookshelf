<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follow';

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

    // フォローしているユーザー
    public function getFollow(Int $user_id)
    {
        return $this->where('following_id', $user_id)->paginate(6);
    }
    // フォローしているユーザー数
    public function getFollowCount(Int $user_id)
    {
        return $this->where('following_id', $user_id)->count();
    }

    // フォローされているユーザー
    public function getFollower(Int $user_id)
    {
        return $this->where('followed_id', $user_id)->paginate(6);
    } 
    // フォローされているユーザー数
    public function getFollowerCount(Int $user_id)
    {
        return $this->where('followed_id', $user_id)->count();
    } 

    // フォローしているユーザーのIDを取得
    public function followIds(Int $user_id)
    {
        return $this->where('following_id', $user_id)->get('followed_id');
    }
}
