@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>商品一覧</h1>
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
    <table class="table table-bordered">
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
                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="商品写真" class="img-fluid" style="max-width: 100px;"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'カテゴリ未設定' }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->weight }}　g</td>
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
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel{{ $product->id }}">{{ $product->name }}の詳細</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- 商品詳細情報 -->
                                <p><strong>商品画像:</strong></p>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid mb-3">
                                <p><strong>カテゴリ:</strong> {{ $product->category->name ?? 'カテゴリ未設定' }}</p>
                                <p><strong>在庫数:</strong> {{ $product->quantity }}</p>
                                <p><strong>重量:</strong> {{ $product->weight }}</p>

                                <!-- 入荷予定リスト -->
                                <h6>入荷予定</h6>
                                <ul style="list-style-type: none; padding: 0; margin: 0;">
                                @if ($product->incomingStocks->isNotEmpty())
                                        @foreach ($product->incomingStocks as $stock)
                                            <li>
                                            <strong>数量:</strong> {{ $stock->quantity }} <br>
                                            <strong>予定日:</strong> {{ $stock->income_date }}
                                            </li>
                                        @endforeach
                                </ul>
                                @else
                                        <span>入荷予定はありません。</span>
                                @endif
                                <form action="{{ route('inventory.destroy', $stock->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                </form>
                                

                                <!-- 在庫追加フォーム -->
                                <h6 class="mt-4">在庫追加</h6>
                                <form action="{{ route('inventory.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="form-group">
                                        <label for="quantity{{ $product->id }}">追加数量</label>
                                        <input type="number" id="quantity{{ $product->id }}" name="quantity" class="form-control" min="1" required>
                                        @error('quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="arrival_date{{ $product->id }}">入荷予定日</label>
                                        <input type="date" id="arrival_date{{ $product->id }}" name="arrival_date" class="form-control" required>
                                        @error('arrival_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">在庫を追加</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection