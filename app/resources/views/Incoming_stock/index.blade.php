@extends('layouts.app')

@section('content')
<h1>入庫予定一覧</h1>
<table>
    <thead>
        <tr>
            <th>商品名</th>
            <th>入庫予定日</th>
            <th>数量</th>
            <th>ステータス</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($incomingStocks as $stock)
        <tr>
            <td>{{ $stock->product->name }}</td>
            <td>{{ $stock->income_date }}</td>
            <td>{{ $stock->quantity }}</td>
            <td>{{ $stock->status }}</td>
            <td>
                @if ($stock->status === 'pending')
                <form action="{{ route('incoming-stock.confirm', $stock->id) }}" method="POST">
                    @csrf
                    <button type="submit">確定</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection