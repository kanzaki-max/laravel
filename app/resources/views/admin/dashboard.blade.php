@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>管理者画面</h1>

    <div class="mb-3">
        <h3>商品管理</h3>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">商品一覧</a>
        <a href="{{ route('products.create') }}" class="btn btn-success">新しい商品を登録</a>
    </div>

    <div class="mb-3">
        <h3>ユーザー管理</h3>
        <a href="{{ route('users.index') }}" class="btn btn-info">ユーザー一覧</a>
        <a href="{{ route('users.create') }}" class="btn btn-success">新しいユーザーを登録</a>
    </div>
</div>
@endsection