@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品編集</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="form-group">
            <label for="category_id">カテゴリ</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">在庫数</label>
            <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}" required>
        </div>
        <div class="form-group">
            <label for="weight">重量</label>
            <input type="number" name="weight" class="form-control" value="{{ $product->weight }}" required>
        </div>
        <div class="form-group">
            <label for="image">画像</label>
            <input type="file" name="image" id="image" class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection