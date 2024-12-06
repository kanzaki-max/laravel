@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4">ユーザートップ画面</h1>
        <p class="text-muted">こちらのページから商品・在庫入荷一覧をご確認いただけます。</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3 class="card-title mb-4">商品管理</h3>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg w-100">商品一覧</a>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="card-title mb-4">在庫管理</h3>
                        <a href="{{ route('incoming_stocks.index') }}" class="btn btn-primary btn-lg w-100">在庫入荷一覧</a>
                    </div>      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection