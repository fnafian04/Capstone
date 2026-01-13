@extends('layout')

@section('title', 'QR Menu')

@section('styles')
<style>
/* ================= ROOT ================= */
:root {
    --primary: #3d6aff;
    --primary-soft: #eef2ff;
    --radius: 22px;
}

/* ================= PRINT MODE ================= */
@media print {
    body * {
        visibility: hidden;
    }

    #printable-area, #printable-area * {
        visibility: visible;
    }

    #printable-area {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff !important;
        box-shadow: none !important;
        border: none !important;
    }

    #qrcode img {
        width: 600px !important;
        height: 600px !important;
    }

    .no-print {
        display: none !important;
    }
}

/* ================= PAGE ================= */
.qr-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #eef2ff, #f8faff);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
}

/* ================= CARD ================= */
.qr-card {
    width: 100%;
    max-width: 420px;
    background: #fff;
    border-radius: var(--radius);
    padding: 28px;
    text-align: center;
    box-shadow: 0 18px 40px rgba(61,106,255,0.18);
    border: 1px solid #e4e8ff;
}

/* ================= HEADER ================= */
.qr-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--primary);
    letter-spacing: 2px;
    
}

.qr-subtitle {
    font-size: .95rem;
    color: #6b7280;
    margin-bottom: 20px;
    opacity: 0.8;
}

/* ================= QR ================= */
.qr-box {
    background: var(--primary-soft);
    border-radius: 20px;
    padding: 18px;
    margin-bottom: 18px;
}

#qrcode {
    display: flex;
    justify-content: center;
}

/* ================= URL ================= */
.url-box {
    background: #f9fafb;
    border: 1px dashed #c7d2fe;
    border-radius: 14px;
    padding: 12px;
    margin-bottom: 18px;
}

.url-box small {
    color: #6b7280;
    display: block;
}

.url-box strong {
    color: var(--primary);
    font-size: .85rem;
    word-break: break-all;
}

/* ================= BUTTON ================= */
.btn-print {
    background: linear-gradient(135deg, #3d6aff, #5c8bff);
    border: none;
    border-radius: 14px;
    font-weight: 700;
    padding: 10px;
    box-shadow: 0 8px 20px rgba(61,106,255,.35);
}

.btn-print:hover {
    opacity: .95;
}

/* ================= FOOTER ================= */
.qr-footer {
    margin-top: 20px;
    padding-top: 14px;
    border-top: 1px solid #e5e7eb;
}

.qr-footer a {
    font-size: .85rem;
    color: #6b7280;
    text-decoration: none;
}

.qr-footer a:hover {
    color: var(--primary);
}

.scan-hint {
    line-height: 1;
}

.scan-icon {
    font-size: 1rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    position: relative;
    top:1px;
}

.scan-text {
    font-size: .95rem;
    color: #6b7280;
    line-height: 1.2;
}

</style>
@endsection

@section('content')
<div class="qr-page">
    <div class="qr-card" id="printable-area">

        <div class="no-print">
        <h3 class="qr-title mb-2">SCAN ME</h3>


        <div class="scan-hint d-flex justify-content-center align-items-center gap-2 mb-3">
    <i class="fas fa-camera scan-icon"></i>
    <span class="scan-text">
    Arahkan kamera HP atau Google Lens <br>untuk membuka menu
    </span>
</div>




        </div>

        <div class="qr-box">
            <div id="qrcode"></div>
        </div>

        <div class="no-print">
            <div class="url-box">
                <small>URL Menu</small>
                <strong id="url-display">...</strong>
            </div>

            <button onclick="window.print()" class="btn btn-print w-100 text-white">
                <i class="fas fa-print me-2"></i> Cetak QR
            </button>

            <div class="qr-footer">
                <a href="/login">Masuk ke Dashboard</a>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const protocol = window.location.protocol;
    const hostname = window.location.hostname;
    const port = window.location.port;

    const targetUrl = `${protocol}//${hostname}${port ? ':' + port : ''}/menu`;

    document.getElementById('url-display').innerText = targetUrl;

    const qrContainer = document.getElementById('qrcode');
    qrContainer.innerHTML = '';

    new QRCode(qrContainer, {
    text: targetUrl,
    width: 260,
    height: 260,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});

});
</script>
@endsection
