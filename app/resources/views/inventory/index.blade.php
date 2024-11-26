@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>在庫管理</h1>
    <a href="{{ route('inventory.create' )}}" class="btn btn-primary">在庫追加</a>
        <table class="table table-borderd mt-3">
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
</div>
@endsection