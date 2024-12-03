@extends('layouts.app')

@section('content')
<h1>ユーザー編集</h1>
<form method="POST" action="{{ route('user_management.update', $user->id) }}">
    @csrf
    @method('PUT')
    <label for="name">名前:</label>
    <input type="text" name="name" value="{{ $user->name }}" required>
    <label for="email">メールアドレス:</label>
    <input type="email" name="email" value="{{ $user->email }}" required>
    <label for="role">権限:</label>
    <select name="role">
        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>管理者</option>
        <option value="employee" {{ $user->role === 'employee' ? 'selected' : '' }}>一般ユーザー</option>
    </select>
    <button type="submit">更新</button>
</form>
@endsection