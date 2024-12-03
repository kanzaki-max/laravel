@extends('layouts.app')

@section('content')
<h1>ユーザー管理</h1>
<table>
    <thead>
        <tr>
            <th>名前</th>
            <th>メールアドレス</th>
            <th>権限</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>
                <a href="{{ route('user_management.edit', $user->id) }}">編集</a>
                <form method="POST" action="{{ route('user_management.delete', $user->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection