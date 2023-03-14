<!DOCTYPE html>
<html lang="en">
<?= view('template/admin/head') ?>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <?= view('template/admin/sidebar')?>
        
        <div id="content">
            <div class="content-main">
                <?= view('template/admin/navbar')?>
                <h1 class="title mb-4">Selamat datang di Admin Spatola Cake</h1>
                <span>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                    eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                    minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in
                    reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                    pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                    culpa qui officia deserunt mollit anim id est laborum.</span>

                <div class="box-container row">
                    <div class="py-3 col-md-4">
                        <a href="<?= base_url('kelolaproduk')?>" class="box shadow d-flex flex-column align-items-center justify-content-center">
                            <h5 class="fw-normal text-center">Banyak Produk</h5>
                            <span class="count fw-semibold"><?= $banyakProduk ?></span>
                        </a>
                    </div>
                    <div class="py-3 col-md-4">
                        <a href="<?= base_url('pesanan')?>" class="box shadow d-flex flex-column align-items-center justify-content-center">
                            <h5 class="fw-normal text-center">Total Pesanan</h5>
                            <span class="count fw-semibold"><?= $banyakPesanan ?></span>
                        </a>
                    </div>
                    <div class="py-3 col-md-4">
                        <a href="<?= base_url('pesanan')?>" class="box shadow d-flex flex-column align-items-center justify-content-center">
                            <h5 class="fw-normal text-center">Konfirmasi Pembayaran</h5>
                            <span class="count fw-semibold"><?= $banyakPembayaran ?></span>
                        </a>
                    </div>
                    <div class="py-3 col-md-4">
                        <a href="<?= base_url('akunpelanggan')?>" class="box shadow d-flex flex-column align-items-center justify-content-center">
                            <h5 class="fw-normal text-center">Jumlah Akun User</h5>
                            <span class="count fw-semibold"><?= $banyakUser ?></span>
                        </a>
                    </div>
                    <div class="py-3 col-md-4">
                        <a href="<?= base_url('akunadmin')?>" class="box shadow d-flex flex-column align-items-center justify-content-center">
                            <h5 class="fw-normal text-center">Jumlah Akun Admin</h5>
                            <span class="count fw-semibold"><?= $banyakAdmin ?></span>
                        </a>
                    </div>
                    <div class="py-3 col-md-4">
                        <a href="<?= base_url('pesan')?>" class="box shadow d-flex flex-column align-items-center justify-content-center">
                            <h5 class="fw-normal text-center">Pesan Baru Yang Masuk</h5>
                            <span class="count fw-semibold"><?= $banyakPesan ?></span>
                        </a>
                    </div>
                </div>
            </div>

            <?= view('template/admin/footer')?>
        </div>
    </div>
</body>

</html>