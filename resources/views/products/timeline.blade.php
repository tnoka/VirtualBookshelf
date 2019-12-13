@extends('layout.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <h3 class="col-md-8 mb-3 text-center text-muted">タイムライン</h3>

            @if(isset($timelines))
                @foreach ($timelines as $timeline)
                    <div class="col-md-8 mb-3">
                        <div class="card">
                            <div class="cart-header p-3 w-100 d-flex">
                                <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$timeline->user->profile_image) }}" class="rounded-circle" width="50" height="50">
                                <div class="ml-2 d-flex flex column">
                                    <p class="mb-0">{{ $timeline->user->name }}</p>
                                    <a href="{{ url('users/' .$timeline->user->id) }}" class="">ユーザー名 : {{ $timeline->user->name }}</a>
                                    <p class="mb-0 text-secondary">ユーザーID : {{ $timeline->user->id }}</p>
                                </div>
                                <div class="ml-2 d-flex flex-column flex-grow-1">
                                    <p class="mb-0 text-secondary">投稿日時</p>
                                    <p class="mb-0 text-secondary">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <h4><a href="{{ url('products/' .$timeline->id) }}" class="pl-4">{{ $timeline->title }} / {{ $timeline->author }}</a></h4>
                                <a href="{{ url('products/' .$timeline->id) }}"><img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$timeline->product_image) }}"  alt="" width="300" height="300" class="mt-4 d-block mx-auto img-fluid img-responsive thumbnail aligncenter size-full " style="cursor:pointer"></a>
                                <p class="form-control pl-4 mb-0">おすすめ度 : {{ $timeline->recommend }}</p>
                                <p class="form-control pl-4 mb-0">{{ $timeline->text }}</p>
                            </div>
                            <div class="card-footer py-1 d-flex justify-content-end bg-white">
                                @if ($timeline->user->id === Auth::user()->id)
                                    <div class="dropdown mr-3 d-flex align-items-center">
                                        <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-fw"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <form method="POST" action="{{ url('products/' .$timeline->id) }}" class="mb-0">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ url('products/' .$timeline->id .'/edit') }}" class="dropdown-item">編集</a>
                                                <button type="submit" class="dropdown-item del-btn">削除</button>
                                            </form>
                                        </div>
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
                                        @if (!in_array(Auth::user()->id, array_column($timeline->favorites->toArray(), 'user_id'), TRUE))
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
                @endif
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
