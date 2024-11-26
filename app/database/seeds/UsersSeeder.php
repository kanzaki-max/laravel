<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 
use Carbon\Carbon;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 管理者のテストユーザーを作成
        User::create([
            'name' => '管理者テスト',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'), // パスワードをハッシュ化
            'role' => 'admin',
            'store_id' => null, 
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 一般ユーザーのテストユーザーを作成
        User::create([
            'name' => '一般ユーザーテスト',
            'email' => 'user@test.com',
            'password' => Hash::make('password'), // パスワードをハッシュ化
            'role' => 'employee',
            'store_id' => null, 
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
