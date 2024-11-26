@extends('layouts.app')

@section('content')
<div class="container">
    <h1>カテゴリ編集</h1>
    <form method="POST" action="{{ route('categories.update', $category->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">カテゴリ名</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">更新</button>
    </form>
</div>
@endsection