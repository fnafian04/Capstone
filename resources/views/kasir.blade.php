@extends('layout')
@section('title', 'Dashboard Kasir')

@section('styles')
<style>
/* =========================
   HEADER
========================= */
.kasir-navbar {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 0 0 24px 24px;
}

.kasir-navbar .navbar-brand {
    font-size: 1.3rem;
    font-weight: 800;
}

/* =========================
   NAV PILLS
========================= */
.nav-pills .nav-link {
    border-radius: 14px;
    font-weight: 600;
    color: #667eea;
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

/* =========================
   ORDER CARD
========================= */
.order-card {
    border-radius: 20px;
    background: white;
    box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    transition: 0.25s;
    cursor: pointer;
}

.order-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 35px rgba(102,126,234,0.25);
}

.order-card .badge {
    font-size: 0.75rem;
}

/* =========================
   TABLE
========================= */
.table {
    border-radius: 20px;
    overflow: hidden;
}

.table thead {
    background: #f1f3ff;
    font-weight: 700;
}

.table tbody tr:hover {
    background: #eef1ff;
}

/* =========================
   MODAL
========================= */
.modal-content {
    border-radius: 24px;
}

.modal-header {
    background: #f8f9ff;
    border-bottom: none;
}

.modal-footer {
    border-top: none;
}

/* =========================
   TOTAL
========================= */
.total-text {
    font-size: 1.6rem;
    font-weight: 800;
    color: #667eea;
}
</style>
@endsection

@section('content')

<!-- ================= HEADER ================= -->
<nav class="navbar kasir-navbar mb-4 shadow-sm">
    <div class="container d-flex justify-content-between">
        <span class="navbar-brand text-white">
            <i class="fas fa-cash-register me-2"></i>Dashboard Kasir
        </span>
        <button class="btn btn-danger btn-sm" onclick="logout()">
            <i class="fas fa-sign-out-alt me-1"></i>Logout
        </button>
    </div>
</nav>

<div class="container mb-5">

    <!-- ================= TABS ================= -->
    <ul class="nav nav-pills mb-4 justify-content-center">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pending" onclick="loadPending()">
                <i class="fas fa-clock me-1"></i> Pending
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#riwayat" onclick="loadHistory()">
                <i class="fas fa-history me-1"></i> Riwayat
            </button>
        </li>
    </ul>

    <div class="tab-content">

        <!-- ================= PENDING ================= -->
        <div class="tab-pane fade show active" id="pending">
            <div id="pending-list" class="row g-4"></div>
        </div>

        <!-- ================= RIWAYAT ================= -->
        <div class="tab-pane fade" id="riwayat">
            <div class="card card-custom p-3">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Meja</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="history-list"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ================= DETAIL MODAL ================= -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    Detail Transaksi <span id="modal-id" class="text-primary"></span>
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Pelanggan</span>
                    <strong id="modal-nama"></strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Meja</span>
                    <strong id="modal-meja"></strong>
                </div>

                <table class="table table-sm">
                    <tbody id="modal-items"></tbody>
                </table>

                <div class="text-end total-text mt-3" id="modal-total"></div>
            </div>

            <div class="modal-footer" id="modal-actions"></div>

        </div>
    </div>
</div>

<iframe id="printFrame" style="position:absolute;width:0;height:0;border:0;"></iframe>

@endsection

@section('scripts')
<script>
    const token = localStorage.getItem('authToken');
    if(!token) window.location.href = '/login';

    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
    let currentData = [];

    function logout() { localStorage.clear(); window.location.href = '/login'; }

    // --- FUNGSI CETAK LANGSUNG (INTI PERUBAHAN) ---
    function printReceipt(data) {
        const iframe = document.getElementById('printFrame');
        const doc = iframe.contentWindow.document;
        
        // Format Tanggal
        const tgl = new Date().toLocaleString('id-ID');
        const kasir = data.id_kasir || 'Kasir'; // Atau ambil nama user dari localStorage

        // Susun HTML Item
        let itemsHtml = '';
        data.detail_transaksi.forEach(item => {
            itemsHtml += `
                <tr>
                    <td colspan="3" style="padding-top:5px; font-weight:bold;">${item.nama_menu_snapshot}</td>
                </tr>
                <tr>
                    <td>${item.jumlah}x</td>
                    <td style="text-align:right;">@ ${formatRupiah(item.harga_snapshot, false)}</td>
                    <td style="text-align:right; font-weight:bold;">${formatRupiah(item.subtotal, false)}</td>
                </tr>
            `;
        });

        // Desain Struk HTML (Mirip struk.blade.php tapi versi string JS)
        const content = `
            <html>
            <head>
                <style>
                    @page { margin: 0; size: 58mm auto; }
                    body { margin: 0; padding: 5px; font-family: 'Courier New', monospace; font-size: 12px; width: 58mm; }
                    .text-center { text-align: center; }
                    .text-right { text-align: right; }
                    .bold { font-weight: bold; }
                    .line { border-bottom: 1px dashed #000; margin: 5px 0; }
                    table { width: 100%; font-size: 12px; }
                    td { vertical-align: top; }
                </style>
            </head>
            <body>
                <div class="text-center">
                    <div class="bold" style="font-size: 14px;">FOOD COURT ITN</div>
                    <div>Jl. Sigura-gura Malang</div>
                </div>
                
                <div class="line"></div>
                
                <table>
                    <tr><td>ID</td><td class="text-right">#${data.id_transaksi}</td></tr>
                    <tr><td>Tgl</td><td class="text-right">${tgl}</td></tr>
                    <tr><td>Kasir</td><td class="text-right">${kasir}</td></tr>
                    <tr><td>Meja</td><td class="text-right bold">${data.no_meja} (${data.nama_pelanggan})</td></tr>
                </table>

                <div class="line"></div>

                <table>${itemsHtml}</table>

                <div class="line"></div>

                <table>
                    <tr class="bold" style="font-size: 14px;">
                        <td>TOTAL</td>
                        <td class="text-right">${formatRupiah(data.total_pembayaran)}</td>
                    </tr>
                </table>
                
                <div class="text-center" style="margin-top: 10px;">
                    * Terima Kasih *
                </div>
            </body>
            </html>
        `;

        // Tulis ke Iframe dan Cetak
        doc.open();
        doc.write(content);
        doc.close();
        
        // Beri jeda sedikit agar browser selesai render, lalu print
        setTimeout(() => {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }, 500);
    }
    // ----------------------------------------------


    // --- LOAD DATA ---
    async function loadPending() {
        const container = document.getElementById('pending-list');
        container.innerHTML = '<div class="text-center w-100 py-5">Memuat...</div>';
        try {
            const res = await fetch(`${apiUrl}/kasir/pesanan-pending`, { headers: { 'Authorization': `Bearer ${token}` } });
            currentData = await res.json();
            
            if(currentData.length === 0) {
                container.innerHTML = '<div class="alert alert-info w-100">Tidak ada pesanan pending.</div>'; return;
            }

            let html = '';
            currentData.forEach(order => {
                html += `
                <div class="col-md-4 col-sm-6">
                    <div class="card card-custom h-100 border-start border-4 border-warning" onclick="showDetail(${order.id_transaksi}, 'pending')" style="cursor:pointer">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-warning text-dark">PENDING</span>
                                <small class="text-muted">#${order.id_transaksi}</small>
                            </div>
                            <h5 class="card-title mb-1">Meja ${order.no_meja}</h5>
                            <p class="text-muted mb-2">${order.nama_pelanggan}</p>
                            <h6 class="fw-bold text-primary text-end">${formatRupiah(order.total_pembayaran)}</h6>
                        </div>
                    </div>
                </div>`;
            });
            container.innerHTML = html;
        } catch(e) { console.error(e); }
    }

    async function loadHistory() {
        const tbody = document.getElementById('history-list');
        try {
            const res = await fetch(`${apiUrl}/kasir/riwayat`, { headers: { 'Authorization': `Bearer ${token}` } });
            currentData = await res.json();
            
            let html = '';
            currentData.forEach(order => {
                const badge = order.status_pesanan === 'selesai' ? 'bg-success' : 'bg-primary';
                html += `
                <tr>
                    <td>#${order.id_transaksi}</td>
                    <td>${order.no_meja}</td>
                    <td>${order.nama_pelanggan}</td>
                    <td>${formatRupiah(order.total_pembayaran)}</td>
                    <td><span class="badge ${badge}">${order.status_pesanan.toUpperCase()}</span></td>
                    <td><button class="btn btn-sm btn-outline-secondary" onclick="showDetail(${order.id_transaksi}, '${order.status_pesanan}')">Detail</button></td>
                </tr>`;
            });
            tbody.innerHTML = html || '<tr><td colspan="6" class="text-center">Kosong</td></tr>';
        } catch(e) { console.error(e); }
    }

function showDetail(id, status) {
    const order = currentData.find(o => o.id_transaksi == id);
    if(!order) return;

    document.getElementById('modal-id').innerText = '#' + order.id_transaksi;
    document.getElementById('modal-nama').innerText = order.nama_pelanggan;
    document.getElementById('modal-meja').innerText = order.no_meja;
    document.getElementById('modal-total').innerText = formatRupiah(order.total_pembayaran);

    let itemsHtml = '';
    order.detail_transaksi.forEach(item => {
        itemsHtml += `<tr>
            <td>${item.nama_menu_snapshot} <span class="text-muted">x${item.jumlah}</span></td>
            <td class="text-end">${formatRupiah(item.subtotal)}</td>
        </tr>`;
    });
    document.getElementById('modal-items').innerHTML = itemsHtml;

    let btns = '';
    if(status === 'pending') {
        btns = `
            <button class="btn btn-danger w-100 mb-2" onclick="hapusTransaksi(${id})">
                ❌ Hapus Pesanan
            </button>
            <button class="btn btn-success w-100" onclick="validasi(${id})">
                ✔ Validasi & Cetak
            </button>`;
    } else {
        btns = `
            <button class="btn btn-dark me-2" onclick="cetakUlang(${id})">
                🖨 Cetak
            </button>`;
        if(status === 'diproses') {
            btns += `
                <button class="btn btn-primary" onclick="selesai(${id})">
                    ✔ Selesai
                </button>`;
        }
    }

    document.getElementById('modal-actions').innerHTML = btns;
    detailModal.show();
}  //  <--- ❗ INI yang hilang



    async function validasi(id) {
        if(!confirm('Validasi dan Cetak Struk?')) return;
        showLoading();
        try {
            const res = await fetch(`${apiUrl}/kasir/validasi/${id}`, {
                method: 'POST', headers: { 'Authorization': `Bearer ${token}` }
            });
            const data = await res.json();
            if(res.ok) {
                detailModal.hide();
                loadPending();
                // Panggil Fungsi Cetak Langsung
                printReceipt(data.transaksi);
            }
        } catch(e) { alert('Error'); } finally { hideLoading(); }
    }

    async function selesai(id) {
        if(!confirm('Tandai pesanan selesai?')) return;
        try {
            await fetch(`${apiUrl}/kasir/selesai/${id}`, { method: 'POST', headers: { 'Authorization': `Bearer ${token}` } });
            detailModal.hide();
            loadHistory();
        } catch(e) { alert('Error'); }
    }

    async function hapusTransaksi(id) {
    if(!confirm('Yakin ingin menghapus pesanan ini?')) return;

    try {
        const res = await fetch(`${apiUrl}/kasir/transaksi/${id}`, {
            method: 'DELETE',
            headers: { 'Authorization': `Bearer ${token}` }
        });

        if(res.ok) {
            alert('Pesanan berhasil dihapus');
            detailModal.hide();
            loadPending(); // Refresh tampilan pending
        } else {
            alert('Gagal menghapus pesanan');
        }
    } catch(e) {
        alert('Terjadi kesalahan');
    }
}

    function cetakUlang(id) {
        const order = currentData.find(o => o.id_transaksi == id);
        if(order) {
            printReceipt(order); // Cetak langsung
        }
    }
    
    function formatRupiah(angka, prefix=true) {
        const num = new Intl.NumberFormat('id-ID').format(angka);
        return prefix ? 'Rp ' + num : num;
    }
</script>
@endsection