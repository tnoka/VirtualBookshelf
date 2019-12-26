@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3 p-0">
                <div class="container">
                    <div class="row">
                        <div class="col-md px-0 d-flex align-items-center mb-3">
                            <div class="pr-4 ml-5">
                            <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$user->profile_image) }}" class="rounded-circle" width="100" height="100">
                            </div>
                            <div class="mt-3 d-flex flex-column">
                                <h5 class="mb-0 pt-3 font-weight-bold">ユーザー名 : {{ $user->name }}</h5>
                                <span class="text-secondary">ユーザーID : {{ $user->id }}</span>
                                <div class="d-flex flex-column justify-content-between">
                                    <div class="d-flex">
                                        @if($user->id === Auth::user()->id)
                                            <div class="mt-3 d-flex">
                                                <a href="{{ url('users/' .$user->id .'/edit') }}" class="btn btn-primary mr-2">編集</a>
                                                <a href="{{ route('logout') }}" class="btn btn-secondary"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">ログアウト
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        @else
                                            <div class="mt-3 d-flex">
                                                @if($is_following)
                                                    <form action="{{ route('unFollow', $user->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-danger mr-2">フォロー解除</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('follow', $user->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-primary mr-2">フォローする</button>
                                                    </form>
                                                @endif
                                                @if($is_followed)
                                                    <span class="bg-secondary text-light px-2 d-flex align-items-center" style="font-size:11px;">フォロワー</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="tab my-2 justify-content-center">
                    <li class="tab__item px-0 pt-0 ml-3 mr-0"><a class="btn btn-lg px-2" href="{{ url('users/' .$user->id) }}">
                            <div class="text-secondary">本 棚</div>
                            <div class="">{{ $product_count }}</div></a>
                    </li>
                    <li class="tab__item px-0 pt-0 mr-0"><a class="btn btn-lg px-2" href="{{ url('favorites/' .$user->id) }}">
                        <div class="text-secondary">読みたい</div>
                        <div class="">{{ $favorite_count }}</div></a>
                    </li>
                    <li class="tab__item tab__item--active px-0 pt-0 mr-0"><a class="btn btn-lg px-2" href="{{ route('followIndex', $user->id) }}">
                        <strong>
                            <div class="">フォロー</div>
                            <div class="">{{ $follow_count }}</div></a>
                        </strong>
                    </li>
                    <li class="tab__item px-0 pt-0 mr-0"><a class="btn btn-lg px-2" href="{{ route('followerIndex', $user->id) }}">
                        <div class="text-secondary">フォロワー</div>
                        <div class="">{{ $follower_count }}</div></a>
                    </li>
                </ul>
            </div>
            
            @if(isset($follows))
                <div class="col-md-8">
                    @foreach ($follows as $follow)
                        @if($follow->isFollowed($user->id))
                            <div class="card">
                                <div class="card-haeder p-3 w-100 d-flex">
                                    <a href="{{ url('users/' .$follow->id) }}"><img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$follow->profile_image) }}" class="rounded-circle" width="50" height="50" alt=""></a>
                                    <div class="ml-2 flex-column">
                                        <a href="{{ url('users/' .$follow->id) }}" class="text-muted font-weight-bold">{{ $follow->name }}</a>
                                        @if (auth()->user()->isFollowed($follow->id))
                                            <p class="px-1 bg-secondary text-light">フォローされています</p>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-end flex-grow-1">
                                        @if(auth()->user()->isFollowing($follow->id))
                                            <form action="{{ route('unFollow', $follow->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger">フォロー解除</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $follows->links() }}
        </div>
    </div>
@endsection
