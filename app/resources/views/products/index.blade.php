@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>商品一覧</h1>
    @if(auth()->user()->role === 'admin')
        <div class="mb-3 text-right">
            <a href="{{ route('products.create') }}" class="btn btn-success">商品登録</a>
        </div>
    @endif
    <!-- 検索フォーム -->
    <form method="GET" action="{{ route('products.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="商品名で検索" value="{{ request('name') }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-control">
                    <option value="">カテゴリを選択</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="arrival_date" class="form-control" value="{{ request('arrival_date') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">検索</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered" id="product-list">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>カテゴリ</th>
                <th>在庫数</th>
                <th>重量</th>
                <th>詳細</th>
                <th>編集・削除</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 100px;"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'カテゴリ未設定' }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->weight }} g</td>
                    <td>                  
                        <!-- 詳細ボタンでモーダルを開く -->
                        <button class="btn btn-info" data-toggle="modal" data-target="#productModal{{ $product->id }}">詳細</button>
                    </td>
                    <td>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('products.edit', ['product' => $product->id]) }}" class="btn btn-warning btn-sm">編集</a>
                        <form action="{{ route('products.destroy', ['product' => $product->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</button>
                        </form>
                    @endif
                    </td>
                </tr>

                <!-- 商品詳細モーダル -->
                <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="productModalLabel{{ $product->id }}">{{ $product->name }} の詳細</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="閉じる">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- 商品画像 -->
                                <div class="text-center mb-4">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm" style="max-width: 300px;">
                                </div>
                
                                <!-- 商品情報 -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card shadow-sm mb-3">
                                            <div class="card-body">
                                                <h6 class="card-subtitle mb-2 text-muted">基本情報</h6>
                                                <p><strong>カテゴリ:</strong> {{ $product->category->name ?? 'カテゴリ未設定' }}</p>
                                                <p><strong>在庫数:</strong> {{ $product->quantity }}</p>
                                                <p><strong>重量:</strong> {{ $product->weight }} g</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card shadow-sm mb-3">
                                            <div class="card-body">
                                                <h6 class="card-subtitle mb-2 text-muted">入荷予定</h6>
                                                @if ($product->incomingStocks->where('status', '!=', 'completed')->isNotEmpty())
                                                    <ul class="list-unstyled">
                                                        @foreach ($product->incomingStocks as $stock)
                                                            <li class="mb-2">
                                                                <p><strong>予定日:</strong> {{ $stock->income_date }}</p>
                                                                <p><strong>数量:</strong> {{ $stock->quantity }}</p>
                                                                <p><strong>重量:</strong> {{ $stock->weight }}</p>                                                            
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-muted">入荷予定はありません。</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                
                                <!-- 出庫フォーム -->
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">出庫管理</h6>
                                        <form action="{{ route('products.reduce', $product->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="quantity">出庫数</label>
                                                <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="weight">出庫重量 (g)</label>
                                                <input type="number" name="weight" id="weight" class="form-control" min="1" required>
                                            </div>
                                            <button type="submit" class="btn btn-danger btn-block">持ち出す</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- 在庫追加フォーム -->
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">在庫追加</h6>
                                        <form action="{{ route('inventory.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="form-group">
                                                <label for="arrival_date{{ $product->id }}">入荷予定日</label>
                                                <input type="date" id="arrival_date{{ $product->id }}" name="arrival_date" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity{{ $product->id }}">追加数量</label>
                                                <input type="number" id="quantity{{ $product->id }}" name="quantity" class="form-control" min="1" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="weight{{ $product->id }}">追加重量</label>
                                                <input type="number" id="weight{{ $product->id }}" name="weight" class="form-control" min="1" required>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary btn-block">在庫を追加</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let page = 1;
    let loading = false;

    $(window).on('scroll', function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            if (loading) return;
            loading = true;
            page++;

            $.ajax({
                url: "{{ route('products.load') }}",
                type: "GET",
                data: {
                    page: page,
                    name: "{{ request('name') }}",
                    category: "{{ request('category') }}"
                },
                success: function(response) {
                    $('#product-list tbody').append(response);
                },
                error: function() {
                    $(window).off('scroll');
                },
                complete: function() {
                    loading = false;
                }
            });
        }
    });
});
</script>
@endsection