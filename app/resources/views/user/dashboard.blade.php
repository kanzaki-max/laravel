@extends('layouts.app')

@section('content')
<h1>一般ユーザートップ画面</h1>
<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection