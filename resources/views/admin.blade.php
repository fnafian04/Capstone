@extends('layout')
@section('title', 'Admin Dashboard')

@section('styles')
<style>
/* ———————— RESET ———————— */
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: 'Inter', sans-serif;
    background: #f5f6fb;
    color: #1f1f1f;
}

/* WRAPPER */
#wrapper {
    display: flex;
    min-height: 100vh;
}

/* ————————— SIDEBAR ————————— */
#sidebar-wrapper {
    width: 260px;
    background: #1f2d98;
    padding: 32px 20px;
    border-radius: 0 28px 28px 0;
    color: white;
    position: fixed;
    top: 0;
    bottom: 0;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    z-index: 1000;
}

.sidebar-heading {
    text-align: center;
    font-size: 1.6rem;
    font-weight: 800;
    margin-bottom: 40px;
    color: white !important;
}

.list-group-item {
    background: transparent;
    color: #e4e7ff;
    padding: 14px 16px;
    margin-bottom: 10px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: 0.2s;
}

.list-group-item:hover {
    background: rgba(255,255,255,0.18);
    transform: translateX(6px);
}

.list-group-item.active {
    background: rgba(255,255,255,0.25);
    color: white;
    font-weight: 600;
}

/* ————————— MAIN CONTENT ————————— */
#page-content-wrapper {
    flex: 1;
    margin-left: 260px;
    padding: 34px 48px;
}

/* ————————— DASHBOARD CARDS ————————— */
.card-custom {
    border-radius: 26px;
    padding: 28px;
    background: white;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    border: none !important;
    transition: 0.25s ease;
    position: relative;
}

.card-custom:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.09);
}

.card-custom h5 {
    font-size: 1rem;
    opacity: 0.7;
}

.card-custom h1 {
    font-size: 3rem;
    font-weight: 800;
}

/* ————————— GRID LAYOUT (like example) ————————— */
.row.g-4 > div {
    display: flex;
}

/* ————————— TABLE ————————— */
.table {
    border-radius: 22px !important;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    background: white;
}

.table thead {
    background: #f1f3ff !important;
    font-weight: 700;
}

.table-striped tbody tr:nth-of-type(odd) {
    background: #fafbff;
}

.table tbody tr:hover {
    background: #eef1ff !important;
    transform: scale(1.01);
}

/* ————————— BUTTONS ————————— */
button, .btn {
    border-radius: 14px !important;
    font-weight: 600;
    padding: 10px 16px !important;
}

.btn-success {
    background: linear-gradient(135deg, #15cd72, #4be08a);
    border: none;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
}

.btn-outline-primary {
    border: 2px solid #667eea !important;
    color: #667eea !important;
}

/* ————————— MODAL ————————— */
.modal-content {
    border-radius: 28px !important;
    padding: 10px;
    box-shadow: 0 15px 45px rgba(0,0,0,0.2);
}

.modal-header {
    border-bottom: none;
    border-radius: 20px;
    background: #f8f9ff !important;
}

.modal-body {
    padding: 26px;
}

/* ————————— FORM FIELD ————————— */
.form-control, .form-select {
    border-radius: 16px !important;
    padding: 12px 16px !important;
    border: 2px solid #e7e9f5;
    background: #ffffff;
    transition: 0.2s;
}

.form-control:focus, 
.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
}

/* ————————— SOFT IMAGE PREVIEW ————————— */
.img-preview {
    border-radius: 18px;
    transition: 0.2s;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.img-preview:hover {
    transform: scale(1.05);
}

/* ————————— SECTION TRANSITION ————————— */
.section-content {
    display: none;
    animation: fadeIn 0.4s ease;
}

.section-content.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px);}
    to { opacity: 1; transform: translateY(0);}
}

/* ————————— STYLE KASIR (FIXED) ————————— */
.card-kasir { 
    border-radius: 16px; 
    border: 1px solid #eef1ff; 
    background: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03); 
    padding: 16px; 
    transition: 0.3s;
    height: 100%; /* Supaya tinggi kartu sama rata */
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.card-kasir:hover { 
    transform: translateY(-5px); 
    border-color: #667eea; 
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.1);
}

.avatar-circle {
    width: 48px; height: 48px; 
    background: linear-gradient(135deg, #e0e7ff, #eff2ff); 
    color: #4f46e5;
    border-radius: 50%; 
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 1.2rem;
    flex-shrink: 0; /* Mencegah avatar gepeng */
}
</style>
@endsection

@section('content')
<div id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">Food Court</div>
        <div class="list-group list-group-flush mt-2">
            <a class="list-group-item active" onclick="showSection('dashboard', this)"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a class="list-group-item" onclick="showSection('pending', this)"><i class="fas fa-clock"></i> Pesanan Pending</a>
            <a class="list-group-item" onclick="showSection('riwayat', this)"><i class="fas fa-history"></i> Riwayat</a>
            <a class="list-group-item" onclick="showSection('toko', this)"><i class="fas fa-store"></i> Kelola Toko</a>
            <a class="list-group-item" onclick="showSection('kasir', this)"><i class="fas fa-users-cog"></i> Manajemen Kasir</a>
            <a class="list-group-item" onclick="showSection('menu', this)"><i class="fas fa-utensils"></i> Kelola Menu</a>
            <a class="list-group-item text-danger mt-5" href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div id="page-content-wrapper">
        
        <div id="dashboard" class="section-content active">
            <h3 class="mb-4 fw-bold text-dark">Dashboard Overview</h3>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card card-custom bg-primary text-white h-100 p-4 position-relative overflow-hidden">
                        <div class="position-relative z-1">
                            <h5 class="fw-light">Total Toko</h5>
                            <h1 class="display-4 fw-bold mb-0" id="count-toko">0</h1>
                        </div>
                        <i class="fas fa-store position-absolute" style="font-size: 8rem; right: -20px; bottom: -20px; opacity: 0.2;"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom bg-success text-white h-100 p-4 position-relative overflow-hidden">
                        <div class="position-relative z-1">
                            <h5 class="fw-light">Total Menu</h5>
                            <h1 class="display-4 fw-bold mb-0" id="count-menu">0</h1>
                        </div>
                        <i class="fas fa-utensils position-absolute" style="font-size: 8rem; right: -20px; bottom: -20px; opacity: 0.2;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div id="pending" class="section-content">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5 class="m-0 fw-bold"><i class="fas fa-clock text-warning me-2"></i>Pesanan Pending</h5>
                    <button class="btn btn-sm btn-outline-primary" onclick="loadPending()"><i class="fas fa-sync-alt"></i></button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="table-light"><tr><th>Waktu</th><th>Meja</th><th>Pelanggan</th><th class="text-end">Total</th><th class="text-center">Status</th></tr></thead>
                        <tbody id="pending-list"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="riwayat" class="section-content">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5 class="m-0 fw-bold"><i class="fas fa-history text-success me-2"></i>Riwayat Transaksi</h5>
                    <button class="btn btn-sm btn-outline-primary" onclick="loadRiwayat()"><i class="fas fa-sync-alt"></i></button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="table-light"><tr><th class="col-id">ID</th><th>Waktu</th><th>Meja</th><th>Pelanggan</th><th>Kasir</th><th class="text-end">Total</th><th class="text-center">Status</th></tr></thead>
                        <tbody id="riwayat-list"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="toko" class="section-content">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5 class="m-0 fw-bold">Data Toko</h5>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tokoModal" onclick="resetFormToko()">
                        <i class="fas fa-plus me-1"></i> Tambah Toko
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th class="col-id">ID</th>
                                    <th style="width: 80px;">Logo</th> <th style="width: 20%;">Nama Toko</th>
                                    <th style="min-width: 200px;">Alamat</th>
                                    <th>No Telp</th>
                                    <th class="col-action">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="toko-list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="kasir" class="section-content">
    <div class="card card-custom">
        <div class="card-header-custom d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h5 class="m-0 fw-bold">Manajemen Kasir</h5>
            <button class="btn btn-success btn-sm" onclick="openKasirModal()">
                <i class="fas fa-plus me-1"></i> Tambah Kasir
            </button>
        </div>
        
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th class="col-id">ID</th>
                            <th style="width: 80px;">Avatar</th>
                            <th>Username</th>
                            <th class="col-action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="list-kasir"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

        <div id="menu" class="section-content">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5 class="m-0 fw-bold">Data Menu</h5>
                    <div class="d-flex gap-2">
                        <select id="toko-filter" class="form-select form-select-sm w-auto" onchange="loadMenu()">
                            <option value="">Semua Toko</option>
                        </select>
                        <button class="btn btn-success btn-sm" onclick="openAddMenuModal()">
                            <i class="fas fa-plus"></i> Tambah Menu
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th class="col-id">ID</th>
                                    <th>Foto</th>
                                    <th>Menu</th>
                                    <th>Toko</th>
                                    <th class="text-end">Harga</th>
                                    <th class="col-action">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="menu-list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div> 

        

    </div>
</div>

<div class="modal fade" id="tokoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light"><h5 class="modal-title fw-bold">Form Toko</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" id="id-toko">
                <div class="mb-3"><label class="form-label fw-bold">Nama Toko</label><input type="text" id="nama-toko" class="form-control"></div>
                <div class="mb-3"><label class="form-label fw-bold">Alamat</label><textarea id="alamat-toko" class="form-control" rows="2"></textarea></div>
                <div class="mb-3"><label class="form-label fw-bold">No. Telepon (WA)</label><input type="text" id="telp-toko" class="form-control"></div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Logo Toko</label>
                    <input type="file" id="logo-toko" class="form-control" accept="image/*">
                    <div id="preview-logo-toko" class="mt-2 d-flex justify-content-center"></div>
                </div>
            </div>
            <div class="modal-footer bg-light"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="button" class="btn btn-primary" onclick="saveToko()">Simpan Data</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="menuModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light"><h5 class="modal-title fw-bold" id="menu-modal-title">Form Menu</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" id="id-menu">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3"><label class="form-label fw-bold">Pilih Toko</label><select id="id-toko-menu" class="form-select"></select></div>
                        <div class="mb-3"><label class="form-label fw-bold">Nama Menu</label><input type="text" id="nama-menu" class="form-control"></div>
                        <div class="mb-3"><label class="form-label fw-bold">Harga (Rp)</label><input type="number" id="harga-menu" class="form-control"></div>
                        <div class="mb-3"><label class="form-label fw-bold">Deskripsi</label><textarea id="desc-menu" class="form-control" rows="3"></textarea></div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Foto (Bisa Banyak)</label>
                            <input type="file" id="foto-menu" class="form-control" accept="image/*" multiple>
                            <small class="text-muted d-block mt-1">Tahan Ctrl untuk pilih banyak file.</small>
                        </div>
                        <div id="container-foto-existing" style="display: none;">
                            <label class="fw-bold mt-2">Foto Saat Ini:</label>
                            <div id="existing-photos" class="d-flex flex-wrap gap-2 mt-2 border p-2 rounded bg-light" style="min-height: 100px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="button" class="btn btn-primary" onclick="saveMenu()">Simpan Data</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="addKasirModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modal-kasir-title">Tambah Akun Kasir</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formAddKasir">
                    <input type="hidden" id="id-kasir">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" class="form-control" id="username-kasir" required placeholder="Contoh: kasir_pagi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="text" class="form-control" id="password-kasir" placeholder="Kosongi jika tidak ingin mengubah password">
                        <small class="text-muted d-block mt-1" id="hint-password" style="display:none;">* Isi hanya jika ingin ganti password</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold mt-3">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const token = localStorage.getItem('authToken');
    if(localStorage.getItem('userRole') !== 'admin') window.location.href = '/login';
    
    const tokoModal = new bootstrap.Modal(document.getElementById('tokoModal'));
    const menuModal = new bootstrap.Modal(document.getElementById('menuModal'));
    const kasirModal = new bootstrap.Modal(document.getElementById('addKasirModal'));

    function showSection(id, el) {
        document.querySelectorAll('.section-content').forEach(div => div.classList.remove('active'));
        document.getElementById(id).classList.add('active');
        document.querySelectorAll('.list-group-item').forEach(item => item.classList.remove('active'));
        el.classList.add('active');

        if(id === 'pending') loadPending();
        if(id === 'riwayat') loadRiwayat();
        if(id === 'toko') loadToko();
        if(id === 'menu') { loadTokoDropdown(); loadMenu(); }
        if(id === 'kasir') loadKasir();
        if(id === 'dashboard') loadCounts();
    }

    function logout() { localStorage.clear(); window.location.href = '/login'; }

    // --- API CALLS ---
    async function loadPending() {
        const tbody = document.getElementById('pending-list');
        tbody.innerHTML = '<tr><td colspan="5" class="text-center py-3">Memuat...</td></tr>';
        try {
            const res = await fetch(`${apiUrl}/admin/pending`, { headers: { 'Authorization': `Bearer ${token}` } });
            const data = await res.json();
            let html = data.length ? '' : '<tr><td colspan="5" class="text-center py-4 text-muted">Tidak ada pesanan pending</td></tr>';
            data.forEach(o => {
                html += `<tr><td>${new Date(o.waktu_pemesanan).toLocaleString()}</td><td>${o.no_meja}</td><td>${o.nama_pelanggan}</td><td class="text-end fw-bold">${formatRupiah(o.total_pembayaran)}</td><td class="text-center"><span class="badge bg-warning text-dark">PENDING</span></td></tr>`;
            });
            tbody.innerHTML = html;
        } catch(e) { console.error(e); }
    }

    async function loadRiwayat() {
        const tbody = document.getElementById('riwayat-list');
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-3">Memuat...</td></tr>';
        try {
            const res = await fetch(`${apiUrl}/admin/riwayat`, { headers: { 'Authorization': `Bearer ${token}` } });
            const data = await res.json();
            let html = data.length ? '' : '<tr><td colspan="7" class="text-center py-4">Kosong</td></tr>';
            data.forEach(o => {
                const kasir = o.kasir ? o.kasir.username : '-';
                const badge = o.status_pesanan == 'selesai' ? 'bg-success' : 'bg-primary';
                html += `<tr><td class="text-center">#${o.id_transaksi}</td><td>${new Date(o.waktu_pemesanan).toLocaleString()}</td><td>${o.no_meja}</td><td>${o.nama_pelanggan}</td><td>${kasir}</td><td class="text-end fw-bold">${formatRupiah(o.total_pembayaran)}</td><td class="text-center"><span class="badge ${badge}">${o.status_pesanan.toUpperCase()}</span></td></tr>`;
            });
            tbody.innerHTML = html;
        } catch(e) { console.error(e); }
    }

    // --- TOKO (DENGAN LOGO BULAT) ---
    async function loadToko() {
        const res = await fetch(`${apiUrl}/admin/toko`, { headers: { 'Authorization': `Bearer ${token}` } });
        const data = await res.json();
        let html = '';
        data.forEach(t => {
            // LOGIKA LOGO
            const logoHtml = t.logo_url 
                ? `<img src="${t.logo_url}" class="rounded-circle border shadow-sm" width="45" height="45" style="object-fit:cover">`
                : `<div class="rounded-circle bg-light border d-flex align-items-center justify-content-center text-muted mx-auto" style="width:45px; height:45px;"><i class="fas fa-store"></i></div>`;

            html += `<tr>
                <td class="text-center fw-bold">${t.id_toko}</td>
                <td class="text-center">${logoHtml}</td>
                <td class="fw-bold text-primary">${t.nama_toko}</td>
                <td>${t.alamat}</td>
                <td>${t.no_telepon}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-warning me-1" onclick="editToko(${t.id_toko}, '${t.nama_toko}', '${t.alamat}', '${t.no_telepon}', '${t.logo_url}')"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="hapusToko(${t.id_toko})"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
        });
        document.getElementById('toko-list').innerHTML = html;
        document.getElementById('count-toko').innerText = data.length;
    }
    
    function resetFormToko() {
        document.getElementById('id-toko').value = '';
        document.getElementById('nama-toko').value = '';
        document.getElementById('alamat-toko').value = '';
        document.getElementById('telp-toko').value = '';
        document.getElementById('logo-toko').value = '';
        document.getElementById('preview-logo-toko').innerHTML = '';
    }
    
    function editToko(id, nama, alamat, telp, logoUrl) {
        resetFormToko();
        document.getElementById('id-toko').value = id;
        document.getElementById('nama-toko').value = nama;
        document.getElementById('alamat-toko').value = alamat;
        document.getElementById('telp-toko').value = telp;
        
        if(logoUrl && logoUrl !== 'null') {
            document.getElementById('preview-logo-toko').innerHTML = `<img src="${logoUrl}" width="80" height="80" class="rounded-circle border shadow-sm" style="object-fit:cover;">`;
        }
        
        tokoModal.show();
    }
    
    async function saveToko() {
        const id = document.getElementById('id-toko').value;
        const formData = new FormData();
        formData.append('nama_toko', document.getElementById('nama-toko').value);
        formData.append('alamat', document.getElementById('alamat-toko').value);
        formData.append('no_telepon', document.getElementById('telp-toko').value);
        
        const file = document.getElementById('logo-toko').files[0];
        if(file) formData.append('logo_toko', file);

        if(id) formData.append('_method', 'PUT');

        const url = id ? `${apiUrl}/admin/toko/${id}` : `${apiUrl}/admin/toko`;

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Authorization': `Bearer ${token}` },
                body: formData
            });
            if(!response.ok) {
                const err = await response.json();
                throw new Error(err.message || JSON.stringify(err));
            }
            tokoModal.hide();
            loadToko();
        } catch (error) {
            alert('Gagal menyimpan Toko: ' + error.message);
        }
    }
    
    async function hapusToko(id) {
        if(confirm('Hapus toko ini?')) { await fetch(`${apiUrl}/admin/toko/${id}`, { method: 'DELETE', headers: { 'Authorization': `Bearer ${token}` } }); loadToko(); }
    }

    // --- MENU ---
    async function loadTokoDropdown() {
        const res = await fetch(`${apiUrl}/admin/toko`, { headers: { 'Authorization': `Bearer ${token}` } });
        const data = await res.json();
        const filter = document.getElementById('toko-filter');
        const currentFilter = filter.value;
        filter.innerHTML = '<option value="">Semua Toko</option>';
        const select = document.getElementById('id-toko-menu');
        select.innerHTML = '';
        data.forEach(t => {
            filter.innerHTML += `<option value="${t.id_toko}">${t.nama_toko}</option>`;
            select.innerHTML += `<option value="${t.id_toko}">${t.nama_toko}</option>`;
        });
        filter.value = currentFilter;
    }

    async function loadMenu() {
        const filter = document.getElementById('toko-filter').value;
        const url = filter ? `${apiUrl}/admin/menu?id_toko=${filter}` : `${apiUrl}/admin/menu`;
        const res = await fetch(url, { headers: { 'Authorization': `Bearer ${token}` } });
        const data = await res.json();
        let html = data.length ? '' : '<tr><td colspan="6" class="text-center py-4 text-muted">Belum ada menu</td></tr>';
        data.forEach(m => {
             const foto = m.foto_url ? `<img src="${m.foto_url}" width="50" height="50" class="rounded border" style="object-fit:cover;">` : '<span class="text-muted small">No Img</span>';
             html += `<tr><td class="text-center">${m.id_menu}</td><td class="text-center">${foto}</td><td>${m.nama_menu}</td><td>${m.toko ? m.toko.nama_toko : '-'}</td><td class="text-end">${formatRupiah(m.harga_satuan)}</td><td class="text-center"><button class="btn btn-sm btn-warning me-1" onclick="editMenu(${m.id_menu})"><i class="fas fa-edit"></i></button><button class="btn btn-sm btn-danger" onclick="hapusMenu(${m.id_menu})"><i class="fas fa-trash"></i></button></td></tr>`;
        });
        document.getElementById('menu-list').innerHTML = html;
        document.getElementById('count-menu').innerText = data.length;
    }

    function resetFormMenu() {
        document.getElementById('id-menu').value = '';
        document.getElementById('nama-menu').value = '';
        document.getElementById('desc-menu').value = '';
        document.getElementById('harga-menu').value = '';
        document.getElementById('foto-menu').value = '';
        const existing = document.getElementById('existing-photos');
        if(existing) existing.innerHTML = '';
    }

    function openAddMenuModal() {
        resetFormMenu();
        document.getElementById('menu-modal-title').innerText = 'Tambah Menu';
        document.getElementById('container-foto-existing').style.display = 'none';
        menuModal.show();
    }

    async function editMenu(id) {
        resetFormMenu();
        try {
            const res = await fetch(`${apiUrl}/admin/menu/${id}`, { headers: { 'Authorization': `Bearer ${token}` } });
            if (!res.ok) throw new Error('Gagal mengambil data menu');
            const m = await res.json();
            
            document.getElementById('menu-modal-title').innerText = 'Edit Menu';
            document.getElementById('id-menu').value = m.id_menu;
            document.getElementById('id-toko-menu').value = m.id_toko;
            document.getElementById('nama-menu').value = m.nama_menu;
            document.getElementById('desc-menu').value = m.deskripsi || '';
            document.getElementById('harga-menu').value = m.harga_satuan;
            
            const containerExisting = document.getElementById('container-foto-existing');
            containerExisting.style.display = 'block'; 
            const photoContainer = document.getElementById('existing-photos');
            photoContainer.innerHTML = '';
            
            if (m.photos && m.photos.length > 0) {
                m.photos.forEach(p => {
                    const div = document.createElement('div');
                    div.className = 'position-relative';
                    div.style.width = '80px';
                    div.style.height = '80px';
                    div.innerHTML = `<img src="${p.url}" style="width:100%; height:100%; object-fit:cover; border-radius:5px; border:1px solid #ccc;"><button class="btn btn-sm btn-danger position-absolute top-0 end-0 p-0 d-flex align-items-center justify-content-center shadow-sm" style="width:20px; height:20px; border-radius:50%; transform:translate(30%, -30%);" onclick="deletePhoto(${p.id}, this)"><span style="font-size:12px; line-height:1;">&times;</span></button>`;
                    photoContainer.appendChild(div);
                });
            } else {
                photoContainer.innerHTML = '<span class="text-muted small">Tidak ada foto.</span>';
            }
            menuModal.show();
        } catch (error) { console.error(error); alert('Terjadi kesalahan: ' + error.message); }
    }

    async function deletePhoto(photoId, btnElement) {
        if(!confirm('Hapus foto ini?')) return;
        const parentDiv = btnElement.parentElement;
        try {
            const res = await fetch(`${apiUrl}/admin/menu/photo/${photoId}`, { method: 'DELETE', headers: { 'Authorization': `Bearer ${token}` } });
            if(res.ok) parentDiv.remove();
            else alert('Gagal menghapus foto di server');
        } catch(e) { alert('Error koneksi'); }
    }

    async function saveMenu() {
        const id = document.getElementById('id-menu').value;
        const formData = new FormData();
        const tokoVal = document.getElementById('id-toko-menu').value;
        const namaVal = document.getElementById('nama-menu').value;
        const hargaVal = document.getElementById('harga-menu').value;

        if (!tokoVal || !namaVal || !hargaVal) { alert("Mohon lengkapi Nama Menu, Toko, dan Harga!"); return; }

        formData.append('id_toko', tokoVal);
        formData.append('nama_menu', namaVal);
        formData.append('deskripsi', document.getElementById('desc-menu').value);
        formData.append('harga_satuan', hargaVal);
        
        const fileInput = document.getElementById('foto-menu');
        for (let i = 0; i < fileInput.files.length; i++) { formData.append('foto_menu[]', fileInput.files[i]); }
        
        if(id) formData.append('_method', 'PUT');
        const url = id ? `${apiUrl}/admin/menu/${id}` : `${apiUrl}/admin/menu`;
        
        try {
            const response = await fetch(url, { method: 'POST', headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }, body: formData });
            if(!response.ok) {
                const err = await response.json();
                let msg = err.message || 'Gagal menyimpan';
                if(err.errors) msg += '\n' + Object.values(err.errors).join('\n');
                throw new Error(msg);
            }
            menuModal.hide();
            loadMenu();
            alert("Berhasil menyimpan menu!");
        } catch (error) { alert('Gagal: ' + error.message); }
    }

    async function hapusMenu(id) {
        if(confirm('Hapus menu ini?')) { await fetch(`${apiUrl}/admin/menu/${id}`, { method: 'DELETE', headers: { 'Authorization': `Bearer ${token}` } }); loadMenu(); }
    }
    

    
// ================== LOGIKA KASIR (FULL UPDATE) ==================
async function loadKasir() {
        const container = document.getElementById('list-kasir');
        if(!container) return;
        
        // Tampilkan loading di dalam tabel
        container.innerHTML = '<tr><td colspan="4" class="text-center py-3">Memuat data...</td></tr>';

        try {
            const res = await fetch(`${apiUrl}/admin/manajemen-kasir`, { headers: { 'Authorization': `Bearer ${token}` } });
            const data = await res.json();
            
            if(data.length === 0) {
                container.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-muted">Belum ada akun kasir.</td></tr>';
                return;
            }

            let html = '';
            data.forEach(user => {
                const inisial = user.username.charAt(0).toUpperCase();
                
                // Style Avatar Bulat Kecil
                const avatarHtml = `<div class="avatar-circle mx-auto" style="width:40px; height:40px; font-size:1rem;">${inisial}</div>`;

                html += `
                <tr>
                    <td class="text-center fw-bold">${user.id}</td>
                    <td class="text-center">${avatarHtml}</td>
                    <td class="fw-bold text-primary">${user.username}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning me-1" onclick="editKasir(${user.id}, '${user.username}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="hapusKasir(${user.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
            });
            container.innerHTML = html;
        } catch(e) { 
            console.error(e);
            container.innerHTML = '<tr><td colspan="4" class="text-center text-danger py-3">Gagal memuat data.</td></tr>';
        }
    }

    // Buka Modal Tambah
    function openKasirModal() {
        document.getElementById('id-kasir').value = ''; // Reset ID
        document.getElementById('username-kasir').value = '';
        document.getElementById('password-kasir').value = '';
        document.getElementById('password-kasir').required = true; // Wajib password kalau tambah baru
        document.getElementById('modal-kasir-title').innerText = "Tambah Akun Kasir";
        document.getElementById('hint-password').style.display = 'none';
        kasirModal.show();
    }

    // Buka Modal Edit
    function editKasir(id, username) {
        document.getElementById('id-kasir').value = id;
        document.getElementById('username-kasir').value = username;
        document.getElementById('password-kasir').value = ''; // Password kosongin aja
        document.getElementById('password-kasir').required = false; // Gak wajib isi password kalau edit
        document.getElementById('modal-kasir-title').innerText = "Edit Akun Kasir";
        document.getElementById('hint-password').style.display = 'block';
        kasirModal.show();
    }

    // Simpan (Bisa Create atau Update)
    const formKasir = document.getElementById('formAddKasir');
    if(formKasir) {
        formKasir.addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('id-kasir').value;
            const username = document.getElementById('username-kasir').value;
            const password = document.getElementById('password-kasir').value;

            // Tentukan URL dan Method (POST = Baru, PUT = Edit)
            const url = id ? `${apiUrl}/admin/manajemen-kasir/${id}` : `${apiUrl}/admin/manajemen-kasir`;
            const method = id ? 'PUT' : 'POST';

            try {
                const res = await fetch(url, {
                    method: method,
                    headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` },
                    body: JSON.stringify({ username, password })
                });
                const data = await res.json();

                if(res.ok) {
                    alert('Data berhasil disimpan!');
                    kasirModal.hide();
                    loadKasir();
                } else {
                    alert('Gagal: ' + JSON.stringify(data.errors || data.message));
                }
            } catch (e) { alert('Error koneksi.'); }
        });
    }

    async function hapusKasir(id) {
        if(!confirm('Yakin ingin menghapus akun kasir ini?')) return;
        try {
            const res = await fetch(`${apiUrl}/admin/manajemen-kasir/${id}`, { method: 'DELETE', headers: { 'Authorization': `Bearer ${token}` } });
            if(res.ok) loadKasir();
            else alert('Gagal menghapus');
        } catch (e) { alert('Terjadi kesalahan'); }
    }

    async function loadCounts() { loadToko(); loadMenu(); }
    loadCounts();
</script>
@endsection