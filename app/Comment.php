<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{   
    // 変更を許可する
    protected $fillable = [
        'text'
    ];

    // JSONに含める属性
    protected $visible = [
        'author', 'text',
    ];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }

    public function getComment($product_id)
    {
        return $this->with('author')->where('product_id', $product_id)->get();
    }
}
