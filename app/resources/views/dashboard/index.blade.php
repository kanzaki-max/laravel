@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <h1>管理者画面</h1>
    <a href="{{ route('inventory.index') }}" class="btn btn-primary">在庫管理</a>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">商品登録</a>
    <a href="{{ route('user.create') }}" class="btn btn-success">ユーザー登録</a>
</div>
@endsection