<!DOCTYPE html>
<html>
<head><title>Super Admin Login</title></head>
<body style="font-family:sans-serif;max-width:320px;margin:80px auto">
    <h3>Super Admin Login</h3>

    @if ($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="/login">
        @csrf
        <p><input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required style="width:100%"></p>
        <p><input type="password" name="password" placeholder="Password" required style="width:100%"></p>
        <button type="submit">Login</button>
    </form>
</body>
</html>