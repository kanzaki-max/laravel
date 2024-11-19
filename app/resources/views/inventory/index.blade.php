@extends('layouts.app')

@section('content')
<h1>在庫管理</h1>
<table>
    <thead>
        <tr>
            <th>商品名</th>
            <th>店舗</th>
            <th>在庫数</th>
            <th>重量</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inventories as $inventory)
        <tr>
            <td>{{ $inventory->product->name }}</td>
            <td>{{ $inventory->store->name }}</td>
            <td>{{ $inventory->quantity }}</td>
            <td>{{ $inventory->weight }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection