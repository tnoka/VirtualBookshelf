@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <form class="form-inline">
                    <div class="form-group">
                        <input type="text" name="keyword" value="{{ $keyword }}"
                        placeholder="タイトルか著者名を入力">
                        <input type="submit" value="検索">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        @if(count($products) > 0)
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-3">
                    {{ $product->title }}
                </div>
                @endforeach
            </div>
            @else
            <p>ヒットしませんでした。</p>
            @endif

            <div class="paginate">
                {{ $products->links() }}
            </div>
    </div>
@endsection