@extends('layout')

@section('title', 'Login')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card card-custom p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">Food Court Login</h3>
            <p class="text-muted">Masuk sebagai Admin atau Kasir</p>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" id="username" class="form-control" placeholder="Masukkan username">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" id="password" class="form-control" placeholder="Masukkan password">
        </div>
        <button onclick="login()" class="btn btn-primary w-100 btn-custom py-2">MASUK</button>
        <p id="error-msg" class="text-danger text-center mt-3 small"></p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    async function login() {
        const user = document.getElementById('username').value;
        const pass = document.getElementById('password').value;
        
        try {
            const res = await fetch(`${apiUrl}/login`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ username: user, password: pass })
            });
            const data = await res.json();
            
            if (res.ok) {
                localStorage.setItem('authToken', data.access_token);
                localStorage.setItem('userRole', data.user.role);
                window.location.href = data.user.role === 'admin' ? '/admin' : '/kasir';
            } else {
                document.getElementById('error-msg').innerText = data.message;
            }
        } catch (e) {
            document.getElementById('error-msg').innerText = "Gagal terhubung ke server";
        }
    }
</script>
@endsection