@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>商品一覧</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>カテゴリ</th>
                <th>在庫数</th>
                <th>重量</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="商品写真" class="img-fluid"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'カテゴリ未設定' }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->weight }}</td>
                    <td><a href="{{ route('products.show', $product->id) }}" class="btn btn-info">詳細</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection