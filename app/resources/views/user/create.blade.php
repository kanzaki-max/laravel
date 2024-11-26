<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <label for="name">名前:</label>
    <input type="text" name="name" id="name" required>
    
    <label for="email">メールアドレス:</label>
    <input type="email" name="email" id="email" required>
    
    <label for="password">パスワード:</label>
    <input type="password" name="password" id="password" required>
    
    <label for="role">役割:</label>
    <select name="role" id="role">
        <option value="employee">一般</option>
        <option value="admin">管理者</option>
    </select>
    
    <button type="submit">登録</button>
</form>