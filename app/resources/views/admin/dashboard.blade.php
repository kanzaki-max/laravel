@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>管理者トップ画面</h1>
    <a href="{{ route('users.create' )}}" class="btn btn-primary">ユーザー登録</a>
    <div class="mt-4">
        <a href="{{ route('products.create') }}" class="btn btn-primary">商品登録</a>
        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">在庫管理</a>
    </div>
    <div class="mt-4">
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="btn btn-danger">
           ログアウト
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>
@endsection