@extends('layouts.app')

@section('content')
    <h1>商品詳細</h1>
        <p>商品名: {{ $product->name }}</p>
        <p>カテゴリ: {{ $product->category->name }}</p>
        <p>重量: {{ $product->weight }}</p>
        <p>画像: <img src="{{ $product->image_path }}" alt="{{ $product->name }}"></p>
        <a href="/inventory">在庫管理に戻る</a>
@endsection