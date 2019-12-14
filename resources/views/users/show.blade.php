@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="d-inline-flex">
                        <div class="p-3 d-flex flex-column">
                            <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$user->profile_image) }}" class="rounded-circle" width="100" height="100">
                            <div class="mt-3 d-flex flex-column">
                                <h4 class="mb-0 font-weight-bold">ユーザー名 : {{ $user->name }}</h4>
                                <span class="text-secondary">ユーザーID : {{ $user->id }}</span>
                            </div>
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between">
                            <div class="d-flex">
                                <div>
                                    @if($user->id === Auth::user()->id)
                                    <a href="{{ url('users/' .$user->id .'/edit') }}" class="btn btn-primary">プロフィール編集</a>
                                    @else
                                        @if($is_following)
                                            <form action="{{ route('unFollow', $user->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger mb-1">フォロー解除</button>
                                            </form>
                                        @else
                                            <form action="{{ route('follow', $user->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-primary mb-1">フォローする</button>
                                            </form>
                                        @endif

                                        @if($is_followed)
                                            <span class="mt-2 p-1 bg-secondary text-light" style="font-size:11px;">フォローされています</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                                <div class="mt-3 ml-2 d-flex flex-column" style="font-size:14px;">
                                    <a href="#" class="font-weight-bold py-1">読んだ本　 {{ $product_count }}</a>
                                    <a href="#" class="font-weight-bold py-1">フォロー　 {{ $follow_count }}</a>
                                    <a href="#" class="font-weight-bold py-1">フォロワー {{ $follower_count }}</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($timelines))
                @foreach($timelines as $timeline)
                    <div class="col-md-8 mb-3">
                        <div class="card">
                            <div class="card-header p-3 w-100 d-flex">
                                <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                                <div class="ml-2 d-flex flex-column flex-grow-1">
                                    <p class="mb-0 text-secondary">ユーザー名 : {{ $timeline->user->name }}</p>
                                    <p class="mb-0 text-secondary">ユーザーID : {{ $timeline->user->id }}</p>
                                </div>
                                <div class="ml-2 d-flex flex-column flex-grow-1">
                                    <p class="mb-0 text-secondary">投稿日時</p>
                                    <p class="mb-0 text-secondary">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <h4><a href="{{ url('products/' .$timeline->id) }}" class="pl-4">{{ $timeline->title }} / {{ $timeline->author }}</a></h4>
                                <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$timeline->product_image) }}" width="300" height="300" class="mt-3 d-block mx-auto img-fluid img-responsive thumbnail aligncenter size-full wp-image-425" style="cursor:pointer" />
                                <p class="form-control pl-4 mb-0">おすすめ度 : {{ $timeline->recommend }}</p>
                                <p class="form-control pl-4 mb-0">{{ $timeline->text }}</p>
                            </div>
                            <div class="card-footer py-1 d-flex justify-content-end bg-white">
                                @if ($timeline->user->id === Auth::user()->id)
                                    <div class="mr-3 d-flex align-items-center">
                                            <form method="POST" action="{{ url('products/' .$timeline->id) }}" class="mb-0 d-flex flex-row">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ url('products/' .$timeline->id .'/edit') }}" class="dropdown-item">編集</a>
                                                <button type="submit" class="dropdown-item del-btn">削除</button>
                                            </form>
                                    </div>
                                @endif
                                <div class="mr-3 d-flex align-items-center">
                                    <a href="{{ url('products/' .$timeline->id) }}"><i class="far fa-comment fa-fw"></i></a>
                                    @if(is_countable($timeline->comment))
                                        <p class="mb-0 text-secondary">{{ count($timeline->comment) }}</p>
                                    @else
                                    <p class="mb-0 text-secondary">0</p>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center">
                                    {{-- @if (!in_array(Auth::user()->id, array_column($timeline->favorites->toArray(), 'user_id'), TRUE))
                                        <form method="POST" action="{{ url('favorites/') }}" class="mb-0">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $timeline->id }}">
                                            <button type="submit" class="btn p-0 border-0 text-primary"><i class="far fa-heart fa-fw"></i></button>
                                        </form>
                                    @else
                                        <form method="POST"action="{{ url('favorites/' .array_column($timeline->favorites->toArray(), 'id', 'user_id')[Auth::user()->id]) }}" class="mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn p-0 border-0 text-danger"><i class="fas fa-heart fa-fw"></i></button>
                                        </form>
                                    @endif --}}
                                    @if(is_countable($timeline->favorites))
                                    <p class="mb-0 text-secondary">{{ count($timeline->favorites) }}</p>
                                    @else
                                    <p class="mb-0 text-secondary">0</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $timelines->links() }}
        </div>
    </div>
    @endsection
