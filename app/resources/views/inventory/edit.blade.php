@extends('layouts.app')

@section('content')
<div class="container">
    <h1>在庫編集</h1>
    <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="quantity">数量</label>
            <input type="number" name="quantity" class="form-control" value="{{ $inventory->quantity }}" required>
        </div>
        <div class="form-group">
            <label for="income_date">入荷予定日</label>
            <input type="date" name="income_date" class="form-control" value="{{ $inventory->income_date }}" required>
        </div>
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection