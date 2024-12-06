@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">商品詳細</h1>

    <div class="card shadow-sm">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded-start">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="card-title text-primary">{{ $product->name }}</h3>
                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item"><strong>在庫数:</strong> {{ $product->quantity }}</li>
                        <li class="list-group-item"><strong>重量:</strong> {{ $product->weight }} g</li>
                        <li class="list-group-item">
                            <strong>カテゴリ:</strong> {{ $product->category->name ?? 'カテゴリ未設定' }}
                        </li>
                    </ul>

                    @if (session('outgoing'))
                        <div class="mt-4">
                            <h5 class="text-primary">持ち出し内容</h5>
                            <ul class="list-group">
                                <li class="list-group-item"><strong>持ち出す数量:</strong> {{ session('outgoing.quantity') }}</li>
                                <li class="list-group-item"><strong>持ち出す重量:</strong> {{ session('outgoing.weight') }}　g</li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg">商品一覧に戻る</a>
    </div>
</div>
@endsection