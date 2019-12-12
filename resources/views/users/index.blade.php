@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <h3 class="col-md-8 mb-3 text-center text-muted">登録者一覧</h3>

        <div class="col-md-8">
          @foreach ($all_users as $user)
            <div class="card">
              <div class="card-haeder p-3 w-100 d-flex">
                <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50" alt="">
                <div class="ml-2 flex-column">
                  <a href="{{ url('users/' .$user->id) }}" >ユーザー名 : {{ $user->name }}</a>
                  <p class="mb-0 text-secondary">ユーザーID : {{ $user->id }}</p>
                </div>
                @if (auth()->user()->isFollowed($user->id))
                  <div class="px-2">
                    <span class="px-1 bg-secondary text-light">フォローされています</span>
                  </div>
                @endif
                <div class="d-flex justify-content-end flex-grow-1">
                  @if(auth()->user()->isFollowing($user->id))
                    <form action="{{ route('unFollow', $user->id) }}" method="POST">

                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-danger">フォロー解除</button>
                    </form>
                  @else
                    <form action="{{ route('follow', $user->id) }}" method="POST">
                      {{ csrf_field() }}

                      <button type="submit" class="btn btn-primary">フォローする</button>
                    </form>
                  @endif
                </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="my-4 d-flex justify-content-center">
      {{ $all_users->links() }}

    </div>
</div>
@endsection
