

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
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm" style="max-width: 300px;">
                </div>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>
@endforeach
