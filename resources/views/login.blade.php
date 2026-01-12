@extends('layout')

@section('title', 'Login')

@section('styles')
<style>
body {
    background: linear-gradient(135deg, #3d6aff, #6fa0ff);
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
}

/* CARD */
.login-card {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(12px);
    border-radius: 22px;
    padding: 32px;
    box-shadow: 0 20px 45px rgba(0,0,0,0.2);
    border: 1px solid rgba(255,255,255,0.4);
}

/* TITLE */
.login-title {
    font-weight: 800;
    color: #3d6aff;
    letter-spacing: 0.5px;
}

/* INPUT */
.form-control {
    border-radius: 14px;
    padding: 12px 16px;
    border: 1.8px solid #dde3ff;
}

.form-control:focus {
    border-color: #3d6aff;
    box-shadow: 0 0 0 0.15rem rgba(61,106,255,0.25);
}

/* ICON INPUT */
.input-group-text {
    background: #eef2ff;
    border: 1.8px solid #dde3ff;
    border-radius: 14px 0 0 14px;
}

/* BUTTON */
.btn-login {
    background: linear-gradient(135deg, #3d6aff, #5c8bff);
    border: none;
    border-radius: 16px;
    font-weight: 700;
    letter-spacing: 1px;
    padding: 12px;
    box-shadow: 0 8px 22px rgba(61,106,255,0.4);
    transition: 0.3s ease;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(61,106,255,0.6);
}

/* FOOTER TEXT */
.login-footer {
    font-size: 0.85rem;
    opacity: 0.7;
}

/* ERROR */
#error-msg {
    font-weight: 600;
}

/* PASSWORD TOGGLE */
.toggle-password {
    cursor: pointer;
    color: #3d6aff;
    transition: 0.2s;
}

.toggle-password:hover {
    opacity: 0.7;
}

/* LOADING BUTTON */
.btn-login.loading {
    pointer-events: none;
    opacity: 0.85;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 2px;
}

</style>
@endsection

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height:100vh">
    <div class="login-card w-100" style="max-width:420px">

        <div class="text-center mb-4">
            <h3 class="login-title">Food Court Login</h3>
            <p class="text-muted mb-0">Masuk sebagai Admin atau Kasir</p>
        </div>

        <!-- USERNAME -->
        <div class="mb-3">
            <label class="form-label small fw-bold text-muted">Username</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-user text-primary"></i>
                </span>
                <input type="text" id="username" class="form-control" placeholder="Masukkan username">
            </div>
        </div>

        <!-- PASSWORD -->
        <div class="mb-4">
    <label class="form-label small fw-bold text-muted">Password</label>
    <div class="input-group">
        <span class="input-group-text">
            <i class="fas fa-lock text-primary"></i>
        </span>
        <input type="password" id="password" class="form-control" placeholder="Masukkan password">
        <span class="input-group-text toggle-password" onclick="togglePassword()">
            <i class="fas fa-eye" id="eye-icon"></i>
        </span>
    </div>
</div>


<button onclick="login()" id="loginBtn" class="btn btn-login w-100">
    <span id="loginText">
        <i class="fas fa-sign-in-alt me-2"></i> MASUK
    </span>
    <span id="loginLoading" class="d-none">
        <span class="spinner-border spinner-border-sm me-2"></span>
        Memproses...
    </span>
</button>


        <p id="error-msg" class="text-danger text-center mt-3 small"></p>

        <div class="text-center mt-4 login-footer text-muted">
            © {{ date('Y') }} Food Court System
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eye-icon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
async function login() {
    const user = document.getElementById('username').value;
    const pass = document.getElementById('password').value;

    const btn = document.getElementById('loginBtn');
    const text = document.getElementById('loginText');
    const loading = document.getElementById('loginLoading');
    const errorMsg = document.getElementById('error-msg');

    errorMsg.innerText = "";

    // Aktifkan loading
    btn.classList.add('loading');
    text.classList.add('d-none');
    loading.classList.remove('d-none');

    try {
        const res = await fetch(`${apiUrl}/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ username: user, password: pass })
        });

        const data = await res.json();

        if (res.ok) {
            localStorage.setItem('authToken', data.access_token);
            localStorage.setItem('userRole', data.user.role);
            window.location.href = data.user.role === 'admin' ? '/admin' : '/kasir';
        } else {
            errorMsg.innerText = data.message || 'Login gagal';
        }

    } catch (e) {
        errorMsg.innerText = 'Gagal terhubung ke server';
    } finally {
        // Matikan loading jika gagal
        btn.classList.remove('loading');
        text.classList.remove('d-none');
        loading.classList.add('d-none');
    }
}

</script>
@endsection
