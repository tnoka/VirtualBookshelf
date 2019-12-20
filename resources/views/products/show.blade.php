@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <h3 class="col-md-8 mb-3 text-center text-muted">詳細画面</h3>

            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-haeder p-3 w-100 d-flex">
                        <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$product->user->profile_image) }}" class="rounded-circle" width="50" height="50" alt="">
                        <div class="ml-2 d-flex flex-column">
                            <a href="{{ url('users/' .$product->user->id) }}" class="">ユーザー名 : {{ $product->user->name }}</a>
                            <p class="mb-0 text-secondary">ユーザーID : {{ $product->user->id }}</p>
                        </div>
                        <div class="d-flex justify-content-end flex-grow-1">
                            <p class="mb-0 text-secondary">{{ $product->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="pl-4">{{ $product->title }} / {{ $product->author }}</p>
                        <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$product->product_image) }}" alt="" width="300" height="300" class="d-block mx-auto img-fluid img-responsive thumbnail aligncenter size-full wp-image-425"/>
                        <p class="form-control pl-4 mb-0">おすすめ度 : {{ $product->recommend }}</p>
                        <p class="form-control pl-4 mb-0">{{ $product->text }}</p>
                    </div>

                    <div class="card-footer py-1 d-flex justify-content-end bg-white">
                        @if ($product->user->id === Auth::user()->id)
                            <div class="mr-3 d-flex align-items-center">
                                <form method="POST" action="{{ url('products/' .$product->id) }}" class="mb-0 d-flex flex-row">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ url('products/' .$product->id .'/edit') }}" class="dropdown-item">編集</a>
                                    <button type="submit" class="dropdown-item del-btn">削除</button>
                                </form>
                            </div>
                        @endif
                        <div class="mr-3 d-flex align-items-center">
                            <a href="{{ url('products/' .$product->id) }}"><i class="far fa-comment fa-fw"></i></a>
                            @if(is_countable($product->comments))
                                <p class="mb-0 text-secondary">{{ count($product->comments) }}</p>
                            @else
                                <p class="mb-0 text-secondary">0</p>
                            @endif
                        </div>

                        <div class="d-flex align-items-center">
                            @if (!in_array(Auth::user()->id, array_column($product->favorites->toArray(), 'user_id'), TRUE))
                                <form method="POST" action="{{ url('favorites/') }}" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn p-0 border-0 text-primary"><i class="far fa-heart fa-fw"></i></button>
                                </form>
                            @else
                            <form method="POST" action="{{ url('favorites/' .array_column($product->favorites->toArray(), 'id', 'user_id')[Auth::user()->id]) }}" class="mb-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn p-0 border-0 text-danger"><i class="fas fa-heart fa-fw"></i></button>
                            </form>
                            @endif
                            @if(is_countable($product->favorites))
                                <p class="mb-0 text-secondary">{{ count($product->favorites) }}</p>
                            @else
                            <p class="mb-0 text-secondary">0</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3">
                <ul class="list-group">
                    @forelse($comments as $comment)
                        <li class="list-group-item">
                            <div class="py-3 w-100 d-flex">
                                <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$comment->user->profile_image) }}" class="rounded-circle" width="50" height="50" alt="">
                                <div class="ml-2 d-flex flex-column">
                                    <a href="{{ url('users/' .$comment->user->id) }}" class="text-secondary">{{ $comment->user->id}}</a>
                                    <p class="mb-0">{{ $comment->user->name }}</p>
                                </div>
                                <div class="d-flex justify-content-end flex-grouw-1">
                                    <p class="mb-0 text-secondary">{{ $comment->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                            <div class="py-3">
                                {!! nl2br(e($comment->text)) !!}
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item">
                            <p class="mb-0 text-secondary">コメントはまだありません。</p>
                        </li>
                    @endforelse
                    <li class="list-group-item">
                        <div class="py-3">
                            <form method="POST" action="{{ route('comments.store') }}">
                                @csrf
                                <div class="form-group row mb-0">
                                    <div class="col-md-12 p-3 w-100 d-flex">
                                        <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                                        <div class="ml-2 d-flex flex-column">
                                            <a href="{{ url('users/' .$user->id) }}">{{ $user->name }}</a>
                                            <p class="mb-0 text-secondary">{{ $user->id }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <textarea class="mb-3 form-control @error('text') is-invalid @enderror" name="text" required autocomplete="text" rows="4">{{ old('text') }}</textarea>
                                        @error('text')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary">確定</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
