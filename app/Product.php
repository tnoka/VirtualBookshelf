<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // 本の投稿機能
    public function productStore(Int $user_id, Array $data)
    {
        $file_name = $data['product_image']->store('public/product_image');

        $this->user_id = $user_id;
        $this->title = $data['title'];
        $this->author = $data['author'];
        $this->recommend = $data['recommend'];
        $this->text = $data['text'];
        $this->product_image = basename($file_name);
        $this->save();

        return;
    }
}