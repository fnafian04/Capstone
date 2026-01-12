<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cetak Struk</title>

<style>
/* ================= GLOBAL ================= */
:root {
    --paper: 78mm;
    --font: 'JetBrains Mono', 'Courier New', monospace;

    /* ==== PALET WARNA MODERN PREMIUM ==== */
    --accent: #4C7DFF;                 /* Biru modern */
    --accent-light: #ECF1FF;           /* Biru lembut */
    --accent-gradient: linear-gradient(90deg,#4C7DFF,#6FA3FF);
    --border: #d7d9df;
    --text-main: #2d3340;
    --text-soft: #6b7280;
}

* {
    box-sizing: border-box;
    -webkit-print-color-adjust: exact;
}

body {
    margin: 0;
    padding: 25px 0;
    background: #eceef2; /* abu premium modern */
    font-family: var(--font);
    display: flex;
    justify-content: center;
}

/* ================= STRUK ================= */
.receipt {
    width: var(--paper);
    background: #ffffff;
    padding: 6mm;
    border-radius: 12px;

    /* bayangan modern */
    box-shadow: 0 8px 22px rgba(0,0,0,0.18);

    /* border lembut */
    border: 1px solid var(--border);
}

/* ================= TEXT ================= */
.text-center { text-align: center; }
.text-right { text-align: right; }
.bold { font-weight: bold; }

/* ================= HEADER MODERN ================= */
.header-title {
    font-size: 19px;
    font-weight: 800;
    letter-spacing: 0.5px;
    background: var(--accent-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.header-sub {
    font-size: 11px;
    color: var(--text-soft);
    margin-top: 2px;
}

/* ================= DIVIDER PREMIUM ================= */
.divider {
    width: 100%;
    border-bottom: 1px dashed var(--border);
    margin: 12px 0;
    opacity: 0.7;
}

/* ================= TABLE ================= */
.table-info,
.table-items,
.summary-table {
    width: 100%;
    font-size: 13px;
    color: var(--text-main);
}

.table-info td {
    padding: 2px 0;
}

.table-items td {
    padding: 3px 0;
    vertical-align: top;
    color: var(--text-main);
}

/* Kolom rapi */
.qty-col { width: 12%; }
.name-col { width: 58%; }
.price-col { width: 30%; text-align: right; }

/* item name modern */
.item-title {
    font-weight: 700;
    margin-bottom: 3px;
    color: #1a1f2b;

    /* aksen garis kiri biru gradient */
    border-left: 3px solid #4C7DFF;
    padding-left: 6px;
}

/* ================= TOTAL ================= */
.total-row {
    font-size: 16px;
    font-weight: 800;
    color: #1a1f2b;
}

/* ================= FOOTER ================= */
.footer {
    margin-top: 12px;
    text-align: center;
}

.footer .bold {
    font-size: 13px;
    background: var(--accent-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.footer small {
    font-size: 11px;
    color: var(--text-soft);
}

/* ================= PRINT MODE ================= */
@media print {
    body { background: white; padding: 0; }
    .receipt {
        box-shadow: none;
        border-radius: 0;
        width: 100%;
    }
}
</style>



</head>
<body>

<div class="receipt">
    
    <!-- HEADER -->
    <div class="text-center">
        <div class="header-title">FOOD COURT ITN</div>
        <div class="header-sub">Jl. Sigura-gura No. 2, Malang</div>
    </div>

    <div class="divider"></div>

    <!-- INFO -->
    <table class="table-info">
        <tr><td>No. Order</td><td class="text-right bold" id="id-trx">#...</td></tr>
        <tr><td>Tanggal</td><td class="text-right" id="tgl-trx">...</td></tr>
        <tr><td>Kasir</td><td class="text-right" id="kasir-name">...</td></tr>
        <tr><td>Meja</td><td class="text-right bold" id="meja">...</td></tr>
    </table>

    <div class="divider"></div>

    <!-- ITEM LIST -->
    <table class="table-items" id="items-container"></table>

    <div class="divider"></div>

    <!-- TOTAL -->
    <table class="summary-table">
        <tr class="total-row">
            <td>TOTAL</td>
            <td class="text-right" id="total-bayar">Rp 0</td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- FOOTER -->
    <div class="footer">
        <div class="bold">TERIMA KASIH</div>
        <div style="margin-top:3px;">Simpan struk ini sebagai bukti pembayaran</div>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const data = JSON.parse(sessionStorage.getItem("strukData"));
    
    if (!data) {
        document.body.innerHTML = "<h2>Data tidak ditemukan</h2>";
        return;
    }

    // Inject Data
    document.getElementById("id-trx").innerText = "#" + data.id_transaksi;
    document.getElementById("tgl-trx").innerText = new Date().toLocaleString("id-ID");
    document.getElementById("kasir-name").innerText = data.kasir?.username || data.id_kasir || "Kasir";
    document.getElementById("meja").innerText = `${data.no_meja} (${data.nama_pelanggan})`;
    document.getElementById("total-bayar").innerText = formatRupiah(data.total_pembayaran);

    let html = "";
    data.detail_transaksi.forEach(item => {
        html += `
        <tr><td colspan="3" class="item-title">${item.nama_menu_snapshot}</td></tr>
        <tr>
            <td class="qty-col">${item.jumlah}x</td>
            <td class="name-col">@ ${formatRupiah(item.harga_snapshot, false)}</td>
            <td class="price-col bold">${formatRupiah(item.subtotal, false)}</td>
        </tr>`;
    });

    document.getElementById("items-container").innerHTML = html;

    setTimeout(() => window.print(), 300);
});

function formatRupiah(num, prefix = true) {
    const f = new Intl.NumberFormat("id-ID").format(num);
    return prefix ? "Rp " + f : f;
}
</script>

</body>
</html>
