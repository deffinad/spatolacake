<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Customer::index', ['filter' => 'authGuardUser']);
$routes->get('/masuk', 'Customer::masuk');
$routes->get('/masuk/loginWithGoogle', 'Customer::loginWithGoogle');
$routes->add('/pencarian', 'Customer::pencarian', ['filter' => 'authGuardUser']);
$routes->add('/filterpencarian', 'Customer::filterPencarian', ['filter' => 'authGuardUser']);
$routes->get('/tentang', 'Customer::tentang', ['filter' => 'authGuardUser']);
$routes->add('/kontak', 'Customer::kontak', ['filter' => 'authGuardUser']);
$routes->add('/profil', 'Customer::profil', ['filter' => 'authGuardUser']);
$routes->get('/katalog', 'Produk::katalog/', ['filter' => 'authGuardUser']);
$routes->get('/katalog/(:any)', 'Produk::katalog/$1', ['filter' => 'authGuardUser']);
$routes->post('/filterkatalog', 'Produk::dataKatalog', ['filter' => 'authGuardUser']);
$routes->get('/detailproduk/(:any)', 'Produk::detailProduk/$1', ['filter' => 'authGuardUser']);
$routes->add('/keranjang', 'Keranjang::keranjang', ['filter' => 'authGuardUser']);
$routes->post('/keranjang/tambahkeranjang', 'Keranjang::tambahKeranjang', ['filter' => 'authGuardUser']);
$routes->get('/keranjang/hapuskeranjang/(:any)/(:any)/(:any)', 'Keranjang::hapusDetailKeranjang/$1/$2/$3', ['filter' => 'authGuardUser']);
$routes->get('/riwayatpemesanan', 'Pemesanan::riwayatPemesanan', ['filter' => 'authGuardUser']);
$routes->post('/pencarianriwayatpemesanan', 'Pemesanan::pencarianRiwayatPemesanan', ['filter' => 'authGuardUser']);
$routes->get('/formpemesanan/(:any)/(:any)', 'Pemesanan::formPemesanan/$1/$2', ['filter' => 'authGuardUser']);
$routes->post('/kirimEmailPembayaran', 'Pemesanan::kirimEmailPembayaran', ['filter' => 'authGuardUser']);
$routes->add('/formpemesanan/pembayaran', 'Pembayaran::transaksiPembayaran', ['filter' => 'authGuardUser']);
$routes->add('/pembayaran/tambah', 'Pembayaran::tambahPembayaran', ['filter' => 'authGuardUser']);
$routes->get('/detailpemesanan/(:any)', 'Pemesanan::detailPemesanan/$1', ['filter' => 'authGuardUser']);
$routes->get('/keluar', 'Customer::keluar');
$routes->get('/faq', 'Customer::faq');
$routes->get('/carapemesanan', 'Customer::caraPemesanan');
$routes->get('/infopengiriman', 'Customer::infoPengiriman');
$routes->add('/refund', 'Customer::refund');

$routes->get('/dashboard', 'Admin::index', ['filter' => 'authGuardAdmin']);
$routes->get('/pesanan', 'Pemesanan::pesananAdmin', ['filter' => 'authGuardAdmin']);
$routes->add('/pencarianpesanan', 'Pemesanan::pencarianPesananAdmin', ['filter' => 'authGuardAdmin']);
$routes->get('/pesanan/hapus/(:any)', 'Pemesanan::hapusPesanan/$1', ['filter' => 'authGuardAdmin']);
$routes->get('/pesanan/detail/(:any)', 'Pemesanan::detailPesananAdmin/$1', ['filter' => 'authGuardAdmin']);
$routes->post('/pesanan/detail/edit/(:any)', 'Pemesanan::editPesanan/$1', ['filter' => 'authGuardAdmin']);
$routes->get('/kelolaproduk', 'Produk::kelolaProduk', ['filter' => 'authGuardAdmin']);
$routes->post('/pencarianproduk', 'Produk::pencarianProduk', ['filter' => 'authGuardAdmin']);
$routes->add('/kelolaproduk/tambah', 'Produk::tambahProduk', ['filter' => 'authGuardAdmin']);
$routes->add('/kelolaproduk/edit/(:any)', 'Produk::editProduk/$1', ['filter' => 'authGuardAdmin']);
$routes->get('/kelolaproduk/hapus/(:any)', 'Produk::hapusProduk/$1', ['filter' => 'authGuardAdmin']);
$routes->add('/kodepromo', 'KodePromo::index', ['filter' => 'authGuardAdmin']);
$routes->add('/pencariankodepromo', 'KodePromo::pencarianKodePromo', ['filter' => 'authGuardAdmin']);
$routes->get('/kodepromo/hapus/(:any)', 'KodePromo::hapusKodePromo/$1', ['filter' => 'authGuardAdmin']);
$routes->get('/akunpelanggan', 'Admin::akunPelanggan', ['filter' => 'authGuardAdmin']);
$routes->post('/pencarianakunpelanggan', 'Admin::pencarianAkunPelanggan', ['filter' => 'authGuardAdmin']);
$routes->get('/akunpelanggan/hapus/(:any)/(:any)', 'Admin::hapusPelanggan/$1/$2', ['filter' => 'authGuardAdmin']);
$routes->get('/akunadmin', 'Admin::akunAdmin', ['filter' => 'authGuardAdmin']);
$routes->post('/pencarianakunadmin', 'Admin::pencarianAkunAdmin', ['filter' => 'authGuardAdmin']);
$routes->get('/akunadmin/hapus/(:any)/(:any)', 'Admin::hapusAdmin/$1/$2', ['filter' => 'authGuardAdmin']);
$routes->post('/akunadmin/edit/(:any)/(:any)', 'Admin::editAdmin/$1/$2', ['filter' => 'authGuardAdmin']);
$routes->get('/pesan', 'Admin::pesan', ['filter' => 'authGuardAdmin']);
$routes->get('/pesan/hapus/(:any)', 'Admin::hapusPesan/$1', ['filter' => 'authGuardAdmin']);
$routes->get('/pengembalian', 'Admin::pengembalian', ['filter' => 'authGuardAdmin']);
$routes->get('/pengembalian/(:any)', 'Admin::buktiGambar/$1', ['filter' => 'authGuardAdmin']);
$routes->get('/pengembalian/hapus/(:any)', 'Admin::hapusPengembalian/$1', ['filter' => 'authGuardAdmin']);
$routes->add('/masukadmin', 'Admin::masuk');
$routes->add('/daftaradmin', 'Admin::daftar');
$routes->get('/keluaradmin', 'Admin::keluar');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
