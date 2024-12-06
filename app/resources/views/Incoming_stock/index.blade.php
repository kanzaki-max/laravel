@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">入荷予定情報一覧</h1>

    <!-- 成功メッセージの表示 -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- 入荷予定情報一覧テーブル -->
    <table class="table table-striped table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>商品名</th>
                <th>入荷予定日</th>
                <th>数量</th>
                <th>重量(g)</th>
                <th>ステータス</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($incomingStocks as $stock)
                <tr>
                    <td>{{ $stock->product->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($stock->income_date)->format('Y年m月d日') }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ $stock->weight ?? '0.00' }}</td>
                    <td>
                        @if ($stock->status === 'pending')
                            <span class="badge bg-warning text-dark">未処理</span>
                        @elseif ($stock->status === 'confirmed')
                            <span class="badge bg-primary">確認済み</span>
                        @elseif ($stock->status === 'completed')
                            <span class="badge bg-success">完了</span>
                        @endif
                    </td>
                    <td>
                        <!-- 編集ボタン -->
                        <a href="{{ route('incoming_stocks.edit', $stock->id) }}" class="btn btn-warning btn-sm">編集</a>

                        <!-- 完了ボタン -->
                        @if ($stock->status === 'pending')
                            <form action="{{ route('incoming_stocks.complete', $stock->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">完了</button>
                            </form>
                        @endif

                        <!-- 削除ボタン -->
                        @if ($stock->status === 'completed' && auth()->user()->role === 'admin')
                            <form action="{{ route('incoming_stocks.destroy', $stock->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">入荷予定情報がありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection