@extends('layout')

@section('title', 'Daftar Menu')

@section('styles')
<style>
    .container {
    max-width: 1200px;
}

.text-center h2 {
    letter-spacing: -0.5px;
}

.text-center {
    background: linear-gradient(180deg, #f4f7ff 0%, #ffffff 100%);
    padding-bottom: 12px;
}

/* ——————— RESET ——————— */
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: 'Inter', sans-serif;
    background: #f4f7ff;
    color: #1a1a1a;
}

/* ————————— PAGE TITLE ————————— */
.text-center h2 {
    font-size: 2.2rem;
    font-weight: 800;
    color: #3d6aff;
}

.text-center p {
    opacity: 0.7;
    font-size: 1rem;
    color: #4f4f4f;
}

/* ————————— SEARCH BAR ————————— */
.input-group {
    border-radius: 60px;
    overflow: hidden;
    background: white;
    box-shadow: 0 10px 30px rgba(61,106,255,0.18);
    transition: 0.3s ease;
}

.input-group-text {
    background: #3d6aff !important;
    border: none;
    padding-left: 20px;
    padding-right: 20px;
}

.input-group:focus-within {
    box-shadow: 0 14px 36px rgba(61,106,255,0.28);
    transform: translateY(-1px);
}

#search-input {
    border: none;
    padding: 14px 18px;
    font-size: 1rem;
    background: transparent;
    color: #000;
}

#search-input::placeholder {
    color: #8b8b8b;
}

#search-input:focus {
    outline: none;
}

/* ————————— TOKO HEADER ————————— */
.toko-header-container {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-top: 30px;
    margin-bottom: 18px;
    padding: 16px;
    border-radius: 18px;
    backdrop-filter: blur(6px);
    background: rgba(255,255,255,0.9);
    border-left: 6px solid #3d6aff;
    border: 1px solid #dde6ff;
    box-shadow: 0 6px 18px rgba(61, 106, 255, 0.08);
}

.toko-logo {
    width: 64px;
    height: 64px;
    border-radius: 14px;
    object-fit: cover;
}

.toko-nama {
    margin: 0;
    font-size: 1.35rem;
    font-weight: 700;
    color: #1f1f1f;
}

/* ————————— MENU CARD (LIGHT & MODERN) ————————— */
.card-custom {
    border-radius: 22px;
    overflow: hidden;
    background: white;
    transition: 0.3s ease;
    border: 1px solid #e4e8ff;
    box-shadow: 0 8px 28px rgba(0,0,0,0.05);
    position: relative;
}

.card-custom::after {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 22px;
    pointer-events: none;
    box-shadow: inset 0 0 0 1px rgba(61,106,255,0.08);
}

.card-custom:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 38px rgba(61, 106, 255, 0.18);
}

.card-img-wrapper {
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: #eef2ff;
}

.menu-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.35s ease;
}

.card-custom:hover .menu-img {
    transform: scale(1.1);
}

.card-body {
    padding: 16px 18px;
}

.card-body h6 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
}

.card-body p {
    font-size: 0.85rem;
    opacity: 0.6;
}

/* HARGA */
.text-success {
    background: linear-gradient(135deg, #3d6aff, #5c8bff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}


/* ————————— BUTTONS ————————— */
.btn {
    border-radius: 14px !important;
    padding: 8px 14px !important;
    font-weight: 600;
}

.btn-primary {
    background: #3d6aff;
    border: none;
}

.btn-primary:hover {
    background: #2d54dd;
}

.btn-outline-success {
    border: 2px solid #3d6aff;
    color: #3d6aff;
}

.btn-outline-success:hover {
    background: #3d6aff;
    color: white;
}

/* ————————— FLOATING CART ————————— */
.cart-float {
    position: fixed;
    bottom: 26px;
    right: 26px;
    background: linear-gradient(135deg, #3d6aff, #5c8bff);
    padding: 14px 26px;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: white;
    font-weight: 600;
    box-shadow: 0 10px 28px rgba(61,106,255,0.35);
    cursor: pointer;
    transition: 0.25s ease;
    z-index: 1000;
}

.cart-float:hover {
    transform: scale(1.08);
}

.cart-badge {
    background: white;
    color: #3d6aff;
    padding: 4px 10px;
    font-weight: 800;
    border-radius: 12px;
}

/* ————————— PRODUCT MODAL ————————— */
.modal-content {
    border-radius: 24px;
    overflow: hidden;
    background: white;
    color: #1a1a1a;
    border: 1px solid #dde6ff;
    animation: fadeUp 0.35s ease;
}
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.carousel-inner img {
    height: 320px;
    object-fit: cover;
}

.modal-body h4 {
    font-weight: 800;
    color: #3d6aff;
}

#detail-harga {
    font-size: 1.4rem;
    color: #3d6aff;
}

#detail-qty {
    font-size: 1.1rem;
}

/* ————————— CART MODAL ————————— */
#cartModal .modal-header {
    background: #3d6aff;
    color: white;
}

#cartModal .modal-content {
    border-radius: 20px;
    background: white;
    color: #1a1a1a;
}

#cart-items li {
    border-radius: 12px;
    margin-bottom: 12px;
    padding: 12px;
    background: #f5f6ff;
}

#total-harga {
    font-size: 1.5rem;
    font-weight: 800;
    color: #3d6aff;
    animation: pulsePrice 1.8s infinite;
}
@keyframes pulsePrice {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* ————————— RESPONSIVE ————————— */
@media (max-width: 576px) {
    .card-img-wrapper { height: 150px; }

    .cart-float {
        right: 12px;
        bottom: 12px;
        padding: 10px 20px;
    }

    .toko-logo {
        width: 52px;
        height: 52px;
    }

    .toko-nama {
        font-size: 1.1rem;
    }
}

.btn:active {
    transform: scale(0.96);
}

@keyframes pulseSoft {
    0% { box-shadow: 0 0 0 0 rgba(61,106,255,0.6); }
    70% { box-shadow: 0 0 0 14px rgba(61,106,255,0); }
    100% { box-shadow: 0 0 0 0 rgba(61,106,255,0); }
}

.cart-float {
    animation: pulseSoft 2.8s infinite;
}

@media (max-width: 576px) {

.card-body {
    padding: 12px 12px;
}

.card-body h6 {
    font-size: 0.95rem;
    margin-bottom: 4px;
    line-height: 1.25;
}

.card-body p {
    font-size: 0.78rem;
    margin-bottom: 6px;
    line-height: 1.3;
}

.card-body .text-success {
    margin-bottom: 6px;
    font-size: 0.9rem;
}
}

@media (max-width: 576px) {

/* ukuran modal */
#productModal .modal-dialog {
    max-width: 92%;
    margin: 16px auto;
}

/* konten modal */
#productModal .modal-content {
    border-radius: 18px;
}
}

@media (max-width: 576px) {

/* carousel gambar */
#productModal .carousel-inner img {
    height: 220px;
    object-fit: cover;
}

/* padding isi */
#productModal .modal-body .p-4 {
    padding: 14px !important;
}

/* judul menu */
#productModal h4 {
    font-size: 1.05rem;
}

/* harga */
#detail-harga {
    font-size: 1.15rem;
}

/* deskripsi */
#detail-desc {
    font-size: 0.85rem;
    line-height: 1.35;
}
}

@media (max-width: 576px) {
    #productModal .modal-dialog {
        align-self: flex-end;
        margin-bottom: 0;
    }

    #productModal .modal-content {
        border-radius: 20px 20px 0 0;
    }
}



</style>
@endsection

@section('content')

<div class="container py-4 pb-5 mb-5">

    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Daftar Menu</h2>
        <p class="text-muted">Pilih menu favoritmu dari tenant kami</p>
    </div>

    <!-- 🔍 SEARCH BAR -->
    <div class="container mb-4">
        <div class="input-group shadow-sm">
            <span class="input-group-text bg-primary text-white fw-bold">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" id="search-input" class="form-control"
                placeholder="Cari menu atau nama toko..." oninput="searchMenu()">
        </div>
    </div>

    <div id="menu-container" class="row g-4">
        <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary"></div>
            <p class="text-muted mt-2">Memuat menu...</p>
        </div>
    </div>
</div>

<!-- FLOATING CART -->
<div class="cart-float" onclick="openCartModal()">
    <i class="fas fa-shopping-basket fs-4"></i>
    <span class="fw-bold">Keranjang</span>
    <span class="cart-badge" id="cart-count">0</span>
</div>

<!-- =============================== -->
<!--      PRODUCT MODAL (DETAIL)     -->
<!-- =============================== -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg overflow-hidden">

            <div class="modal-body p-0">

                <button class="btn-close position-absolute top-0 end-0 m-3 bg-white shadow-sm"
                    data-bs-dismiss="modal"></button>

                <div id="productCarousel" class="carousel slide bg-dark">
                    <div class="carousel-inner" id="carousel-images"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

                <div class="p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="fw-bold" id="detail-nama">Nama Menu</h4>
                            <span class="badge bg-warning text-dark" id="detail-toko">Nama Toko</span>
                        </div>
                        <h4 class="text-success fw-bold" id="detail-harga">Rp 0</h4>
                    </div>

                    <p class="text-muted mt-3" id="detail-desc">Deskripsi...</p>

                    <div class="d-flex align-items-center bg-light p-2 rounded mb-3">
                        <span class="fw-bold text-muted me-2">Jumlah:</span>
                        <button class="btn btn-sm btn-light" onclick="changeDetailQty(-1)">-</button>
                        <span class="mx-3 fw-bold" id="detail-qty">1</span>
                        <button class="btn btn-sm btn-light" onclick="changeDetailQty(1)">+</button>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <button class="btn btn-outline-primary w-100" onclick="addDetailToCart()">+ Keranjang</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary w-100" onclick="orderDetailNow()">Pesan Sekarang</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- =============================== -->
<!--         CART MODAL              -->
<!-- =============================== -->
<div class="modal fade" id="cartModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content border-0">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-receipt me-2"></i>Pesanan Kamu</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light">
                <ul id="cart-items" class="list-group mb-3"></ul>

                <div class="bg-white p-3 rounded shadow-sm mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Bayar</span>
                        <h4 class="fw-bold text-primary" id="total-harga">Rp 0</h4>
                    </div>
                </div>

                <div class="bg-white p-3 rounded shadow-sm">
                    <h6 class="fw-bold mb-3 border-bottom pb-2">Informasi Pemesan</h6>

                    <label class="form-label small">Nama Anda</label>
                    <input type="text" class="form-control mb-3" id="nama-input">

                    <!-- <label class="form-label small">Nomor Telepon</label>
                    <input type="tel" class="form-control mb-3" id="telp-input"> -->

                    <label class="form-label small">Nomor Meja</label>
                    <select id="meja-input" class="form-select">
                        <option disabled selected>Pilih Meja</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary w-100 fw-bold" onclick="submitOrder()">Kirim Pesanan</button>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

let cart = {};
let currentMenuData = [];
let selectedItem = null;
let detailQty = 1;

const productModal = new bootstrap.Modal(document.getElementById('productModal'));
const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));

document.addEventListener('DOMContentLoaded', () => {
    fetchMenu();
    generateTableOptions();
});

/* =====================
      FETCH MENU
===================== */
async function fetchMenu() {
    const container = document.getElementById('menu-container');

    try {
        const res = await fetch(`${apiUrl}/menu`);
        const data = await res.json();

        currentMenuData = [];

        let html = '';

        data.forEach(toko => {
            if (toko.menu.length > 0) {
                toko.menu.forEach(m => {
                    m.nama_toko = toko.nama_toko;
                    m.logo_url = toko.logo_url;
                    currentMenuData.push(m);
                });

                html += renderTokoHeader(toko.nama_toko, toko.logo_url);

                toko.menu.forEach(item => {
                    html += renderMenuCard(item);
                });
            }
        });

        container.innerHTML = html;

    } catch (e) {
        container.innerHTML = `<div class="text-danger text-center py-5">Gagal memuat menu.</div>`;
    }
}

/* =====================
      SEARCH MENU
===================== */
function searchMenu() {
    const keyword = document.getElementById('search-input').value.toLowerCase();
    const container = document.getElementById('menu-container');

    if (keyword.trim() === "") return fetchMenu();

    let grouped = {};

    currentMenuData.forEach(item => {
        const matchMenu = item.nama_menu.toLowerCase().includes(keyword);
        const matchToko = item.nama_toko.toLowerCase().includes(keyword);

        if (matchMenu || matchToko) {
            if (!grouped[item.nama_toko]) grouped[item.nama_toko] = [];
            grouped[item.nama_toko].push(item);
        }
    });

    if (Object.keys(grouped).length === 0) {
        container.innerHTML = `
            <div class="text-center py-5 text-muted">
                <i class="fas fa-search fs-1 mb-2"></i>
                <p>Tidak ada hasil.</p>
            </div>`;
        return;
    }

    let html = '';

    for (const [toko, menus] of Object.entries(grouped)) {
        html += renderTokoHeader(toko, menus[0].logo_url);

        menus.forEach(item => {
            html += renderMenuCard(item);
        });
    }

    container.innerHTML = html;
}

/* =====================
   RENDER COMPONENTS
===================== */
function renderTokoHeader(name, logo) {
    return `
    <div class="col-12">
        <div class="toko-header-container">
            <img src="${logo || 'https://via.placeholder.com/65?text=Toko'}" class="toko-logo">
            <h5 class="toko-nama">${name}</h5>
        </div>
    </div>`;
}

function renderMenuCard(item) {
    const foto =
        item.photos?.length > 0
            ? item.photos[0].url
            : item.foto_url || "https://via.placeholder.com/300x300?text=No+Image";

    return `
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card card-custom">
            <div class="card-img-wrapper" onclick="openProductDetail(${item.id_menu})">
                <img src="${foto}" class="menu-img">
            </div>
            <div class="card-body">
                <h6 class="fw-bold text-dark text-truncate">${item.nama_menu}</h6>
                <p class="text-muted small text-truncate">${item.deskripsi || ''}</p>
                <div class="text-success fw-bold mb-2">${formatRupiah(item.harga_satuan)}</div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-sm btn-primary" onclick="directOrderCard(${item.id_menu})">Pesan</button>
                    <button class="btn btn-sm btn-outline-success"
                        onclick="addToCart(${item.id_menu}, '${item.nama_menu}', ${item.harga_satuan})">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>`;
}

/* =====================
      DETAILS MODAL
===================== */
function openProductDetail(id) {
    selectedItem = currentMenuData.find(m => m.id_menu == id);

    document.getElementById('detail-nama').innerText = selectedItem.nama_menu;
    document.getElementById('detail-toko').innerText = selectedItem.nama_toko;
    document.getElementById('detail-harga').innerText = formatRupiah(selectedItem.harga_satuan);
    document.getElementById('detail-desc').innerText = selectedItem.deskripsi || '-';

    detailQty = 1;
    document.getElementById('detail-qty').innerText = detailQty;

    let carousel = '';

    if (selectedItem.photos?.length > 0) {
        selectedItem.photos.forEach((p, i) => {
            carousel += `<div class="carousel-item ${i === 0 ? 'active' : ''}">
                <img src="${p.url}" class="d-block w-100">
            </div>`;
        });
    } else {
        const foto = selectedItem.foto_url || 'https://via.placeholder.com/400?text=No+Image';
        carousel = `<div class="carousel-item active"><img src="${foto}" class="d-block w-100"></div>`;
    }

    document.getElementById('carousel-images').innerHTML = carousel;

    productModal.show();
}

function changeDetailQty(val) {
    detailQty += val;
    if (detailQty < 1) detailQty = 1;
    document.getElementById('detail-qty').innerText = detailQty;
}

function addDetailToCart() {
    addToCart(selectedItem.id_menu, selectedItem.nama_menu, selectedItem.harga_satuan, detailQty);
    productModal.hide();
}

function orderDetailNow() {
    processDirectOrder(selectedItem.id_menu, detailQty);
    productModal.hide();
}

/* =====================
      CART LOGIC
===================== */
function openCartModal() {
    cartModal.show();
}

function addToCart(id, name, price, qty = 1) {
    if (cart[id]) cart[id].qty += qty;
    else cart[id] = { name, price, qty };

    updateCartUI();
}

function directOrderCard(id) {
    processDirectOrder(id, 1);
}

function processDirectOrder(id, qty) {
    const item = currentMenuData.find(m => m.id_menu == id);
    cart = {};
    cart[id] = { name: item.nama_menu, price: item.harga_satuan, qty };
    updateCartUI();
    cartModal.show();
}

function updateCartUI() {
    const list = document.getElementById('cart-items');
    let html = '';
    let total = 0;
    let qtyTotal = 0;

    for (let [id, item] of Object.entries(cart)) {
        total += item.price * item.qty;
        qtyTotal += item.qty;

        html += `
        <li class="list-group-item">
            <div class="d-flex justify-content-between">
                <strong>${item.name}</strong>
                <button class="btn btn-sm text-danger" onclick="removeFromCart(${id})">X</button>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">${formatRupiah(item.price)}</span>
                <div>
                    <button class="btn btn-sm btn-light" onclick="updateItemQty(${id}, -1)">-</button>
                    <span class="mx-2">${item.qty}</span>
                    <button class="btn btn-sm btn-light" onclick="updateItemQty(${id}, 1)">+</button>
                </div>
            </div>
        </li>`;
    }

    list.innerHTML = html || `<div class="text-center py-4 text-muted">Keranjang kosong</div>`;
    document.getElementById('total-harga').innerText = formatRupiah(total);
    document.getElementById('cart-count').innerText = qtyTotal;
}

function updateItemQty(id, change) {
    cart[id].qty += change;
    if (cart[id].qty <= 0) delete cart[id];
    updateCartUI();
}

function removeFromCart(id) {
    delete cart[id];
    updateCartUI();
}

/* =====================
     ORDER SUBMISSION
===================== */
async function submitOrder() {
    const nama = document.getElementById('nama-input').value;
    // const telp = document.getElementById('telp-input').value;
    const meja = document.getElementById('meja-input').value;

    const items = Object.entries(cart).map(([id, item]) => ({
        id_menu: id,
        jumlah: item.qty
    }));

    if (!nama || !meja) {
        alert("Mohon lengkapi semua data!");
        return;
    }

    if (items.length === 0) {
        alert("Keranjang masih kosong!");
        return;
    }

    try {
        const res = await fetch(`${apiUrl}/order`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                nama_pelanggan: nama,
               // no_telepon_pelanggan: telp,
                no_meja: meja,
                items
            })
        });

        const data = await res.json();

        if (res.ok) {
            sessionStorage.setItem("orderData", JSON.stringify(data.transaksi));
            window.location.href = "/konfirmasi";
        } else {
            alert(data.message || "Gagal membuat pesanan");
        }

    } catch (e) {
        alert("Terjadi kesalahan koneksi");
    }
}

function generateTableOptions() {
    const meja = document.getElementById('meja-input');
    for (let i = 1; i <= 20; i++) {
        meja.innerHTML += `<option value="${i}">Meja ${i}</option>`;
    }
}

function formatRupiah(angka) {
    return "Rp " + angka.toLocaleString("id-ID");
}

</script>
@endsection
