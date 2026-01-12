<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="api-base-url" content="{{ url('/api') }}">
    <title>@yield('title', 'Sistem Food Court')</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- =============================
         GLOBAL LIGHT THEME (UNIFIED)
    ============================== -->
    <style>
        :root {
            --bg-main: #f5f6fb;
            --bg-card: #ffffff;
            --primary: #667eea;
            --primary2: #764ba2;
            --text: #1f1f1f;
            --text-muted: #6b7280;
            --border-soft: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-main);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        main {
            min-height: 100vh;
        }

        /* DEFAULT CARD (ADMIN + MENU SAFE) */
        .card {
            background: var(--bg-card);
            border-radius: 20px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        }

        /* BUTTON BASE */
        .btn {
            border-radius: 14px;
            font-weight: 600;
        }

        /* FORM BASE */
        .form-control,
        .form-select {
            border-radius: 14px;
            border: 1px solid var(--border-soft);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.2);
        }

        /* TABLE BASE */
        table {
            border-radius: 18px;
            overflow: hidden;
        }

        /* LOADING OVERLAY */
        #loading-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(255,255,255,0.75);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        #loading-overlay .spinner-border {
            width: 3rem;
            height: 3rem;
            color: var(--primary);
        }
        /* ======================
   BADGE ID
====================== */
.badge-id {
    font-weight: 700;
    padding: 6px 10px;
    border-radius: 12px;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

/* Kasir */
.badge-kasir {
    background: rgba(102,126,234,0.15);
    color: #667eea;
}

/* Toko */
.badge-toko {
    background: rgba(72,187,120,0.15);
    color: #48bb78;
}

/* Menu */
.badge-menu {
    background: rgba(237,137,54,0.15);
    color: #ed8936;
}

/* Pesanan */
.badge-pesanan {
    background: rgba(59,130,246,0.15);
    color: #3b82f6;
}


        /* PAGE SPECIFIC STYLE */
        @yield('styles')
    </style>
</head>

<body>

    <!-- GLOBAL LOADING -->
    <div id="loading-overlay">
        <div class="spinner-border" role="status"></div>
    </div>

    <!-- PAGE CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- GLOBAL SCRIPT -->
    <script>
        const apiUrl = document.querySelector('meta[name="api-base-url"]').content;

        function showLoading() {
            document.getElementById('loading-overlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loading-overlay').style.display = 'none';
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }
        /* ======================
   FORMAT ID GLOBAL
====================== */
function formatKasir(id) {
    if (!id) return 'KS-';
    return 'KS' + id;
}

function formatToko(id) {
    if (!id) return 'TK-';
    return 'TK' + id;
}

function formatMenu(id) {
    if (!id) return 'MN-';
    return 'MN' + id;
}

function formatPesanan(id) {
    if (!id) return 'PS-';
    return 'PS' + id.toString().padStart(4, '0');
}
        
    </script>

    @yield('scripts')

</body>
</html>
