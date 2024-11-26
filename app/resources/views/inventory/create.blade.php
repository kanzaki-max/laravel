@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>在庫を登録</h1>

    <!-- 在庫追加フォーム -->
    <form action="{{ route('inventory.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="product_id">商品</label>
            <select name="product_id" class="form-control" required>
                <option value="">商品を選択</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="category_id">カテゴリ</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">カテゴリを選択</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">在庫数</label>
            <input type="number" name="quantity" class="form-control" required min="1">
        </div>

        <div class="form-group">
            <label for="weight">重量 (kg)</label>
            <input type="number" name="weight" class="form-control" required step="0.01" min="0">
        </div>

        <button type="submit" class="btn btn-primary">保存</button>
    </form>
</div>
@endsection