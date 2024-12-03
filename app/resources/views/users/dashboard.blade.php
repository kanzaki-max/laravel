@extends('layouts.app')

@section('content')
<div class="container">
    <h1>ユーザートップ画面</h1>
    <a href="{{ route('products.index') }}" class="btn btn-primary">商品一覧</a>
</div>
@endsection