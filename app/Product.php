<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Product extends Model
{
    // プライマリーキーの型
    protected $keyType = 'string';

    // IDの桁数
    const ID_LENGTH = 12;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if(!Arr::get($this->attributes, 'id')) {
            $this->setId();
        }
    }

    // ランダムなIDを代入
    private function setId()
    {
        $this->attributes['id'] = $this->getRandomId();
    }

    // ランダムなIDを作成
    private function getRandomId()
    {
        $characters = array_merge(
            range(0, 9), range('a', 'z'),
            range('A', 'Z'), ['-', '_']
        );

        $length = count($characters);

        $id = "";

        for($i = 0;$i < self::ID_LENGTH; $i++) {
            $id .= $characters[random_int(0, $length - 1)];
        }

        return $id;
    }

    // 本の投稿機能
    public function productStore(Int $user_id, Array $data)
    {
        // $file_name = $data['product_image']->store('public/product_image');

        $this->user_id = $user_id;
        $this->title = $data['title'];
        $this->author = $data['author'];
        $this->recommend = $data['recommend'];
        $this->text = $data['text'];
        $this->product_image = $data['product_image'];
        $this->save();

        return;
    }
}