@extends('layouts.app')

@section('content')
<div class="container">
    <h1>カテゴリ登録</h1>

    <!-- エラーメッセージ表示 -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- カテゴリ登録フォーム -->
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">カテゴリ名</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
</div>
@endsection