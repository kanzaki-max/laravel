@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>商品一覧</h1>
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
                    <td>{{ $product->weight }}</td>
                    <td>
                        <!-- 詳細ボタンでモーダルを開く -->
                        <button class="btn btn-info" data-toggle="modal" data-target="#productModal{{ $product->id }}">詳細</button>
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
                                <ul>
                                @if (isset($product->inventories) && $product->inventories->isNotEmpty())
                                        @foreach ($product->inventories as $inventory)
                                            <li>
                                            <strong>数量:</strong> {{ $inventory->quantity }} <br>
                                                <strong>予定日:</strong> {{ $inventory->arrival_date }}
                                            </li>
                                        @endforeach
                                @else
                                        <li>入荷予定はありません。</li>
                                @endif
                                </ul>

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