@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">入荷予定編集</h1>
    <form action="{{ route('incoming_stocks.update', $stock->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="income_date">入荷予定日</label>
            <input type="date" name="income_date" id="income_date" class="form-control" value="{{ $stock->income_date }}" required>
        </div>
        <div class="form-group">
            <label for="quantity">数量</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $stock->quantity }}" min="1" required>
        </div>
        <div class="form-group">
            <label for="weight">重量(g)</label>
            <input type="number" name="weight" id="weight" class="form-control" value="{{ $stock->weight }}" min="0" required>
        </div>
        <button type="submit" class="btn btn-primary">更新</button>
        <a href="{{ route('incoming_stocks.index') }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection