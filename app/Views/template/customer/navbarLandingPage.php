<?php
$active = '';
if ($_SESSION['route'] == "landingPage") {
}
?>
<nav class="navbar navbar-expand-lg fixed-top header-transparent" id="header">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a href="<?= base_url('/') ?>" class="navbar-brand d-flex align-items-center justify-content-center">
            <img src="<?= base_url('assets/images/sc1.png') ?>" alt="Logo Spatola Cake" width="100%" height="100%">
        </a>

        <div class="header-mobile icons">
            <a data-bs-toggle="modal" href="#modalSearch" role="button"><i class="fas fa-search"></i></a>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link scrollto <?php if ($_SESSION['route'] == 'landingPage') {
                                                    echo 'active';
                                                } ?> fw-bold" href="#hero">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link scrollto fw-bold" href="#about">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link scrollto fw-bold" href="#catalog">Katalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link scrollto fw-bold" href="<?= base_url('/riwayatpemesanan') ?>">Pesanan Saya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link scrollto fw-bold" href="<?= base_url('/kontak') ?>">Kontak Kami</a>
                </li>
            </ul>
            <div class="container icons d-flex justify-content-end ">
                <form action="<?= base_url('pencarian') ?>" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Pencarian" name="keyword">
                        <button class="btn" type="submit" name="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
                <a href="<?= base_url('/profil') ?>"><i class="fas fa-user"></i></a>
                <a href="<?= base_url('/keranjang') ?>"><i class="fas fa-shopping-cart"></i></a>
                <a href="<?= base_url('/keluar') ?>"><i class="fas fa-sign-in-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<nav class="navbar navbar-mobile fixed-bottom shadow-lg">
    <div class="container-fluid">
        <a href="<?= base_url('/keranjang') ?>" class="d-flex flex-column justify-content-center align-items-center">
            <i class="fas fa-shopping-cart"></i>
            <span>Keranjang</span>
        </a>
        <a href="<?= base_url('/profil') ?>" class="d-flex flex-column justify-content-center align-items-center">
            <i class="fas fa-user"></i>
            <span>Profil</span>
        </a>
        <a href="<?= base_url('/keluar') ?>" class="d-flex flex-column justify-content-center align-items-center">
            <i class="fas fa-sign-in-alt"></i>
            <span>Keluar</span>
        </a>
    </div>
</nav>