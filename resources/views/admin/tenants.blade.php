<!DOCTYPE html>
<html>
<head><title>Tenants</title></head>
<body style="font-family:sans-serif;max-width:720px;margin:40px auto">
    <h3>Tenants</h3>

    @if (session('ok'))
        <p style="color:green">{{ session('ok') }}</p>
    @endif
    @if ($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif

    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <tr><th>ID</th><th>Name</th><th>Domain</th><th>Database</th></tr>
        @foreach ($tenants as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->name }}</td>
                <td><a href="http://{{ $t->domain }}:8000/login" target="_blank">{{ $t->domain }}</a></td>
                <td>{{ $t->db_name }}</td>
            </tr>
        @endforeach
    </table>

    <h4>Naya tenant banao</h4>
    <form method="POST" action="/tenants">
        @csrf
        <p><input name="name" placeholder="Company name (Initech)" value="{{ old('name') }}" required></p>
        <p><input name="subdomain" placeholder="subdomain (initech)" value="{{ old('subdomain') }}" required> .localhost</p>
        <p><input type="email" name="admin_email" placeholder="Admin email" value="{{ old('admin_email') }}" required></p>
        <p><input type="password" name="admin_password" placeholder="Admin password (min 8)" required></p>
        <button type="submit">Create Tenant</button>
    </form>

    <form method="POST" action="/logout" style="margin-top:30px">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>