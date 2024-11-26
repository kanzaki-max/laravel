@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品登録</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="category_id">カテゴリ</label>
            <select id="category_id" name="category_id" class="form-control">
                <option value="">カテゴリを選択してください</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <a href="{{ route('categories.create') }}" class="btn btn-link mt-2">カテゴリを追加する</a>
        </div>
        <div class="form-group">
            <label for="quantity">数量</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <div class="form-group">
            <label for="weight">重量</label>
            <input type="text" class="form-control" id="weight" name="weight" required>
        </div>
        <div class="form-group">
            <label for="image">商品写真</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
</div>
@endsection