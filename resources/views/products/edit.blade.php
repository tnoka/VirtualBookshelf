@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-haeder">Update</div>

                        <div class="card-body">
                            <form action="{{ route('products.update',['products' => $products]) }}" method="POST" > 
                                @csrf
                                @method('PUT')

                                <div class="form-froup row mb-0">
                                    <div class="col-md-12 p-3 w-100 d-flex">
                                        <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                                            <div class="ml-2 d-flex flex-column">
                                                <p class="mb-0">{{ $user->name }} </p>
                                                <a href="{{ url('users/ .$user->id') }}" class="text-secondary">{{ $user->id}}</a>
                                            </div>
                                    </div>
                                    <div class="col-md-12">
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ? : $products->title }}" required autocomplete="title" autofocus>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="author" class="col-md-4 col-form-label text-md-right">{{ __('Author') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="author" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') ? : $products->author }}" required autocomplete="author" autofocus>
                                    @error('author')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="recommend" class="col-md-4 col-form-label text-md-right">{{ __('Recommend') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="recommend" class="form-control @error('recommend') is-invalid @enderror" name="recommend" value="{{ old('recommend') ? : $products->recommend }}" required autocomplete="recommend" autofocus>
                                    @error('recommend')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                                        <textarea name="text" class="form-control mb-3" required autocomplete="text" rows="10">{{ old('text') ? : $products->text }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary">確定</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
