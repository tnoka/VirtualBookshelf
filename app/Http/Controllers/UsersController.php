<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use App\Product;
use App\Follow;

class UsersController extends Controller
{
    // ユーザー一覧
    public function index(User $user)
    {
        $all_users = $user->getAllUsers(auth()->user()->id);

        return view('users.index', [
            'all_users' => $all_users
        ]);
    }

    // ユーザー詳細
    public function show(User $user, Product $product, Follow $follow)
    {
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        $timelines = $product->getUserTimeLine($user->id);
        $product_count = $product->getProductCount($user->id);
        $follow_count = $follow->getFollowerCount($user->id);
        $follower_count = $follow->getFollowerCount($user->id);

        return view('users.show', [
            'user' => $user,
            'is_following' => $is_following,
            'is_followed' => $is_followed,
            'timelines' => $timelines,
            'product_count' => $product_count,
            'follow_count' => $follow_count,
            'follower_count' => $follower_count,
        ]);
    }

    // ユーザー編集
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    // プロフィール更新
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255', Rule::unique('users')->ignore($user->id),
            'profile_image' => 'file|image|mimes:jpeg,jpg,png|max:8192'
        ]);
        $validator->validate();
        $user->updateProfile($data);

        return redirect('users/'.$user->id);
    }

    // public function destroy(User $user)
    // {
    //     $user = auth()->user();
    //     $user->destroyUser($user->id);

    //     return response($user, 200);    
    // }

    // フォロー
    public function follow(User $user)
    {
        $follower = auth()->user();
        // フォローしているか
        $is_following = $follower->isFollowing($user->id);
        if(!$is_following) {
            // フォローしていなければフォローする
            $follower->follow($user->id);
            return back();
        }
    }

    // フォロー解除
    public function unFollow(User $user)
    {
        $follower = auth()->user();
        // フォローしているか
        $is_following = $follower->isFollowing($user->id);
        if($is_following) {
            // フォローしていればフォローを解除する
            $follower->unFollow($user->id);
            return back();
        }
    }
}