@extends('layouts.app')

@section('content')
<div class="container">
    <h1>ユーザー編集</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="role">権限</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>管理者</option>
                <option value="employee" {{ $user->role === 'employee' ? 'selected' : '' }}>一般ユーザー</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection