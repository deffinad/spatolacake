<nav id="sidebar">
    <div class="sidebar-header d-flex flex-column">
        <img src="<?= base_url('assets/images/sc1.png')?>">
        <!-- <h3>Spatola Cake</h3> -->
    </div>

    <ul class="list-unstyled">
        <li class="<?php if($_SESSION['route'] == 'dashboard') {echo 'active';}?>">
            <a href="<?= base_url('dashboard')?>" data-toggle="collapse" aria-expanded="false">
                <div class="d-flex gap-3 flex-row">
                    <div class="icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <span>Beranda</span>
                </div>
            </a>
        </li>

        <li class="<?php if($_SESSION['route'] == 'pesanan') {echo 'active';}?>">
            <a href="<?= base_url('pesanan')?>" data-toggle="collapse" aria-expanded="false">
                <div class="d-flex gap-3 flex-row">
                    <div class="icon">
                        <i class="fa fa-receipt"></i>
                    </div>
                    <span>Pesanan</span>
                </div>
            </a>
        </li>

        <li class="<?php if($_SESSION['route'] == 'kelolaproduk') {echo 'active';}?>">
            <a href="<?= base_url('kelolaproduk')?>" data-toggle="collapse" aria-expanded="false">
                <div class="d-flex gap-3 flex-row">
                    <div class="icon">
                        <i class="fa fa-archive"></i>
                    </div>
                    <span>Kelola Produk</span>
                </div>
            </a>
        </li>
        <li class="<?php if($_SESSION['route'] == 'kodepromo') {echo 'active';}?>">
            <a href="<?= base_url('kodepromo')?>" data-toggle="collapse" aria-expanded="false">
                <div class="d-flex gap-3 flex-row">
                    <div class="icon">
                        <i class="fa fa-credit-card"></i>
                    </div>
                    <span>Kode Promo</span>
                </div>
            </a>
        </li>
        <li class="<?php if($_SESSION['route'] == 'akunpelanggan') {echo 'active';}?>">
            <a href="<?= base_url('akunpelanggan')?>" data-toggle="collapse" aria-expanded="false">
                <div class="d-flex gap-3 flex-row">
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <span>Akun Pelanggan</span>
                </div>
            </a>
        </li>
        <li class="<?php if($_SESSION['route'] == 'akunadmin') {echo 'active';}?>">
            <a href="<?= base_url('akunadmin')?>" data-toggle="collapse" aria-expanded="false">
                <div class="d-flex gap-3 flex-row">
                    <div class="icon">
                        <i class="fa fa-user-lock"></i>
                    </div>
                    <span>Admin</span>
                </div>
            </a>
        </li>
        <li class="<?php if($_SESSION['route'] == 'pesan') {echo 'active';}?>">
            <a href="<?= base_url('pesan')?>" data-toggle="collapse" aria-expanded="false">
                <div class="d-flex gap-3 flex-row">
                    <div class="icon">
                        <i class="fa fa-comment-alt"></i>
                    </div>
                    <span>Pesan</span>
                </div>
            </a>
        </li>
        <li class="<?php if($_SESSION['route'] == 'pengembalian') {echo 'active';}?>">
            <a href="<?= base_url('pengembalian')?>" data-toggle="collapse" aria-expanded="false">
                <div class="d-flex gap-3 flex-row">
                    <div class="icon">
                        <i class="fa fa-list"></i>
                    </div>
                    <span>Pengembalian</span>
                </div>
            </a>
        </li>
        <li>
            <a href="<?= base_url('keluaradmin')?>" data-toggle="collapse" aria-expanded="false">
                <div class="d-flex gap-3 flex-row">
                    <div class="icon">
                        <i class="fa fa-sign-out-alt"></i>
                    </div>
                    <span>Keluar</span>
                </div>
            </a>
        </li>
    </ul>
</nav>