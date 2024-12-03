@extends('layouts.app')

@section('content')
<h1>在庫削除確認</h1>
<p>以下の在庫を削除しますか？</p>
<p>商品名: {{ $inventory->product->name }}</p>
<p>現在の数量: {{ $inventory->quantity }}</p>
<form method="POST" action="{{ route('inventory.delete', $inventory->id) }}">
    @csrf
    @method('DELETE')
    <button type="submit">削除する</button>
    <a href="{{ route('inventory.index') }}">キャンセル</a>
</form>
@endsection