@extends('layouts.app')

@section('content')
<h1>入庫予定確定</h1>
<p>以下の内容を確定しますか？</p>
<p>商品名: {{ $incomingStock->product->name }}</p>
<p>入庫予定日: {{ $incomingStock->income_date }}</p>
<p>数量: {{ $incomingStock->quantity }}</p>
<form method="POST" action="{{ route('incoming-stock.confirm', $incomingStock->id) }}">
    @csrf
    <button type="submit">確定する</button>
    <a href="{{ route('incoming-stock.index') }}">キャンセル</a>
</form>
@endsection