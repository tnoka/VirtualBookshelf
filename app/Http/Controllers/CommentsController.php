<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Comment;

class CommentsController extends Controller
{
    public function store(Request $request, Comment $comment)
    {
        $user = auth()->user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'product_id' => 'required|string',
            'text' => 'required|string|max:200'
        ]);

        $validator->validate();
        $comment->commentStore($user->id, $data);

        return back();
    }
}
