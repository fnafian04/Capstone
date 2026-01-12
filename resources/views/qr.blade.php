@extends('layout')

@section('title', 'Generator QR Code')

@section('styles')
<style>
    /* --- CSS KHUSUS CETAK (PRINT) --- */
    @media print {
        /* 1. Sembunyikan semua elemen body utama */
        body * {
            visibility: hidden;
        }

        /* 2. Tampilkan HANYA Container QR Code */
        #printable-area, #printable-area * {
            visibility: visible;
        }

        /* 3. Atur posisi area cetak ke tengah kertas sepenuhnya */
        #printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100vh; /* Pakai tinggi viewport penuh */
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;     /* Tengah Vertikal */
            justify-content: center; /* Tengah Horizontal */
            border: none !important;
            box-shadow: none !important;
            background: white !important;
        }

        /* 4. Perbesar Ukuran QR Code Maksimal */
        #qrcode img {
            width: 600px !important;  /* Ukuran Sangat Besar */
            height: 600px !important;
            margin: 0;                /* Hapus margin agar pas di tengah flex */
            display: block;
        }

        /* 5. Pastikan elemen non-print benar-benar hilang */
        .no-print, .card-body-content {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center min-vh-100">
    
    <div class="card card-custom p-4 text-center" style="max-width: 400px; width: 100%;" id="printable-area">
        
        <div class="card-body-content no-print">
            <h3 class="fw-bold text-primary mb-3">Scan QR Code</h3>
            <p class="text-muted mb-4">Arahkan kamera HP Anda untuk membuka Menu Makanan.</p>
        </div>
        
        <div id="qrcode" class="d-flex justify-content-center mb-4"></div>
        
        <div class="no-print">
            <div class="alert alert-light border">
                <small class="text-muted d-block mb-1">URL Target:</small>
                <strong id="url-display" class="text-break text-primary small">...</strong>
            </div>

            <button onclick="window.print()" class="btn btn-primary w-100 mt-2">
                <i class="fas fa-print me-2"></i> Cetak QR
            </button>
            
            <div class="mt-4 pt-3 border-top">
                <a href="/login" class="text-decoration-none text-muted small">Ke Halaman Login</a>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hostname = window.location.hostname;
        const port = window.location.port;
        const protocol = window.location.protocol;
        
        // URL target ke halaman menu
        const targetUrl = `${protocol}//${hostname}${port ? ':' + port : ''}/menu`;

        document.getElementById('url-display').innerText = targetUrl;

        const qrContainer = document.getElementById("qrcode");
        qrContainer.innerHTML = ""; 
        
        // Generate QR (Ukuran default untuk layar)
        new QRCode(qrContainer, {
            text: targetUrl,
            width: 250, 
            height: 250,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    });
</script>
@endsection