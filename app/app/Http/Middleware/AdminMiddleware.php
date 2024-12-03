<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // ユーザーが管理者かどうかを確認
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // 管理者でない場合はログインページへリダイレクト
        return redirect('/login');
    }
}