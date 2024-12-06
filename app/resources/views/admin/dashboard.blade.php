@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5">管理者画面</h1>

    <div class="row g-4">
        <!-- 商品管理 -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h3 class="card-title">商品管理</h3>
                </div>
                <div class="card-body">
                    <p>商品の一覧や新規登録、カテゴリ管理ができます。</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">商品一覧</a>
                        <a href="{{ route('products.create') }}" class="btn btn-outline-success">商品登録</a>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">カテゴリ一覧</a>
                        <a href="{{ route('incoming_stocks.index') }}" class="btn btn-outline-dark">入荷一覧</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ユーザー管理 -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">ユーザー管理</h3>
                </div>
                <div class="card-body">
                    <p>ユーザーの一覧表示や新規登録が可能です。</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-info">ユーザー一覧</a>
                        <a href="{{ route('users.create') }}" class="btn btn-outline-success">ユーザー登録</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection