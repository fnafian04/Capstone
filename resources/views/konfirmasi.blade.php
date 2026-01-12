@extends('layout')

@section('title', 'Pesanan Berhasil')

@section('styles')
<style>
/* ================= ROOT ================= */
:root {
    --primary: #667eea;
    --success: #16a34a;
    --border: #e5e7eb;
    --radius: 20px;
}

/* ================= PAGE ================= */
.confirm-wrapper {
    max-width: 520px;
    margin: auto;
    padding: 30px 16px;
}

/* ================= CARD ================= */
.confirm-card {
    background: #ffffff;
    padding: 34px;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    animation: fadeIn .4s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ================= ICON ================= */
.confirm-icon {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    background: #e8fbe8;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto auto 22px;
}

.confirm-icon i {
    color: var(--success);
    font-size: 3.2rem;
}

/* ================= TITLE ================= */
.confirm-title {
    font-size: 1.8rem;
    font-weight: 800;
    text-align: center;
    color: #1f2937;
}

.confirm-subtitle {
    text-align: center;
    color: #6b7280;
    font-size: 1rem;
    margin-bottom: 26px;
}

/* ================= INFO ================= */
.info-box {
    background: #f9fafb;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    padding: 18px 22px;
    margin-bottom: 26px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.info-row span:first-child {
    color: #6b7280;
}

.info-value {
    font-weight: 700;
    color: #111827;
}

/* ================= ITEMS ================= */
.item-title {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 12px;
    color: #111827;
}

.item {
    padding: 14px 0;
    border-bottom: 1px dashed #e5e7eb;
    display: flex;
    justify-content: space-between;
}

.item:last-child {
    border-bottom: none;
}

.item-name {
    font-weight: 600;
    color: #111827;
}

.item-sub {
    font-size: .9rem;
    color: #6b7280;
}

/* ================= TOTAL ================= */
.total-box {
    margin-top: 16px;
    padding-top: 14px;
    border-top: 2px solid #eef2ff;
    display: flex;
    justify-content: space-between;
    font-size: 1.45rem;
    font-weight: 800;
    color: var(--primary);
}

/* ================= STATUS ================= */
.status-tag {
    margin-top: 26px;
    padding: 14px 18px;
    background: #fff7ed;
    border-radius: var(--radius);
    color: #92400e;
    text-align: center;
    font-weight: 700;
    border: 1px solid #fed7aa;
}

/* ================= LINK ================= */
.back-link {
    display: block;
    margin-top: 22px;
    text-align: center;
    color: var(--primary);
    font-size: .95rem;
    text-decoration: none;
    font-weight: 600;
}

.back-link:hover {
    text-decoration: underline;
}

/* ================= PAYMENT INFO ================= */
.payment-info {
    margin-top: 24px;
    padding: 14px 18px;
    background: #eef2ff;
    border-radius: var(--radius);
    color: var(--primary);
    text-align: center;
    font-weight: 600;
    border: 1px solid #dbe4ff;
}

</style>
@endsection

@section('content')

<div class="confirm-wrapper">

    <div class="confirm-card">

        <!-- ICON -->
        <div class="confirm-icon">
            <i class="fas fa-check"></i>
        </div>

        <!-- TITLE -->
        <div class="confirm-title">Pesanan Berhasil 🎉</div>
        <div class="confirm-subtitle">
        Simpan halaman ini dan tunjukkan ke kasir untuk proses pembayaran

        </div>

        <!-- INFO -->
        <div class="info-box">
            <div class="info-row">
                <span>ID Transaksi</span>
                <span class="info-value" id="conf-id">-</span>
            </div>
            <div class="info-row">
                <span>Nama</span>
                <span class="info-value" id="conf-nama">-</span>
            </div>
            <div class="info-row mb-0">
                <span>Meja</span>
                <span class="info-value" id="conf-meja">-</span>
            </div>
        </div>

        <!-- ITEMS -->
        <div class="item-title">Rincian Pesanan</div>
        <div id="conf-items"></div>

        <!-- TOTAL -->
        <div class="total-box">
            <span>Total</span>
            <span id="conf-total">Rp 0</span>
        </div>

        <div class="payment-info">
    <i class="fas fa-info-circle me-1"></i>
    Silakan lakukan pembayaran di kasir sesuai total di atas
</div>


        <a class="back-link" href="/menu">
            ← Kembali ke Menu
        </a>

    </div>
</div>

@endsection

@section('scripts')
<script>

document.addEventListener("DOMContentLoaded", () => {
    const dataString = sessionStorage.getItem("orderData");

    if (!dataString) {
        document.querySelector(".confirm-card").innerHTML = `
            <div class="text-center p-5">
                <h3 class="text-danger fw-bold">Data Tidak Ditemukan</h3>
                <p class="text-muted">Silakan kembali memesan.</p>
                <a href="/menu" class="btn btn-primary mt-3">Ke Menu</a>
            </div>
        `;
        return;
    }

    const data = JSON.parse(dataString);
    function formatInvoice(id) {
    return '#PS' + id.toString().padStart(4, '0');
}


    document.getElementById("conf-id").innerText = formatInvoice(data.id_transaksi);
    document.getElementById("conf-nama").innerText = data.nama_pelanggan;
    document.getElementById("conf-meja").innerText = data.no_meja;
    document.getElementById("conf-total").innerText = formatRupiah(data.total_pembayaran);

    let html = "";
    data.detail_transaksi.forEach(item => {
        html += `
            <div class="item">
                <div>
                    <div class="item-name">${item.nama_menu_snapshot}</div>
                    <div class="item-sub">${item.jumlah} x ${formatRupiah(item.harga_snapshot)}</div>
                </div>
                <div class="fw-bold">${formatRupiah(item.subtotal)}</div>
            </div>
        `;
    });

    document.getElementById("conf-items").innerHTML = html;
});

function formatRupiah(num) {
    return "Rp " + new Intl.NumberFormat("id-ID").format(num);
}

</script>
@endsection
