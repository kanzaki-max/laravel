@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>商品詳細</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">商品名: {{ $product->name }}</h5>
            <p class="card-text">カテゴリ: {{ $product->category }}</p>
            <p class="card-text">在庫数: {{ $product->quantity }}</p>
            <p class="card-text">重量: {{ $product->weight }} kg</p>
        </div>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">戻る</a>
</div>
@endsection