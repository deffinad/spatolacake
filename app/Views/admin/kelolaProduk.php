<!DOCTYPE html>
<html lang="en">
<?= view('template/admin/head') ?>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <?= view('template/admin/sidebar') ?>

        <div id="content">
            <div class="content-main">
                <?= view('template/admin/navbar') ?>

                <div class="d-flex flex-row mb-4">
                    <div class="flex-grow-1 d-flex align-items-start">
                        <h1 class="title">Kelola Produk</h1>
                    </div>

                    <div class="search d-flex align-items-start">
                        <form class="flex-fill">
                            <div class="input-group">
                                <input type="text" class="form-control" id="filter" placeholder="Cari berdasarkan nama" name="keyword">
                                <button class="btn" type="submit" name="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if (session()->getFlashdata('sukses')) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Selamat!</strong> <?= session()->getFlashdata('sukses') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } else if (session()->getFlashdata('gagal')) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Whoops!</strong> <?= session()->getFlashdata('gagal') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <div class="d-flex">
                    <a href="<?= base_url('kelolaproduk/tambah') ?>" class="button button-green mb-5">Tambah Produk</a>
                </div>

                <div id="data">
                    <div class="kategori d-flex flex-row gap-4 justify-content-center align-items-center">
                        <button class="tablinks active" data-kategori="semua">
                            Semua
                        </button>
                        <button class="tablinks" data-kategori="wholecake">
                            Whole Cake
                        </button>
                        <button class="tablinks" data-kategori="kueulangtahun">
                            Kue Ulang Tahun
                        </button>
                        <button class="tablinks" data-kategori="dessertbox">
                            Dessert Box
                        </button>
                        <button class="tablinks" data-kategori="kuekeringroti">
                            Kue Kering & Roti
                        </button>
                    </div>

                    <div class="catalog-body">
                        <div id="semua" class="tabContent active">
                            <div class="row list-wrapper">
                                <?php if (count($produk) > 0) { ?>
                                    <?php foreach ($produk as $dataProduk) { ?>
                                        <div class="col-md-6 list-item">
                                            <div class="box d-flex flex-column shadow">
                                                <div class="user">
                                                    <div class="image">
                                                        <img src="<?= base_url('gambarProduk/' . $dataProduk->gambar) ?>" alt="">
                                                    </div>
                                                    <div class="user-info">
                                                        <h3><?= $dataProduk->namaKue ?></h3>
                                                        <span>Rp<?= number_format($dataProduk->harga, 0, ',', '.') ?></span>
                                                    </div>
                                                </div>
                                                <div class="content d-flex flex-row justify-content-center align-items-center gap-3">
                                                    <a href="<?= base_url('kelolaproduk/edit/' .  $dataProduk->id_kue) ?>" class="button button-green flex-grow-1">Edit</a>
                                                    <a data-bs-toggle="modal" href="#modalHapus" data-id="<?= $dataProduk->id_kue ?>" role="button" class="button button-green flex-grow-1">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                                        <h1>Data Tidak Ditemukan</h1>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div id="wholecake" class="tabContent">
                            <div class="row list-wrapper">
                                <?php if (count($produkK1) > 0) { ?>
                                    <?php foreach ($produkK1 as $dataProduk) { ?>
                                        <div class="col-md-6">
                                            <div class="box d-flex flex-column shadow">
                                                <div class="user">
                                                    <div class="image">
                                                        <img src="<?= base_url('gambarProduk/' . $dataProduk->gambar) ?>" alt="">
                                                    </div>
                                                    <div class="user-info">
                                                        <h3><?= $dataProduk->namaKue ?></h3>
                                                        <span>Rp<?= number_format($dataProduk->harga, 0, ',', '.') ?></span>
                                                    </div>
                                                </div>
                                                <div class="content d-flex flex-row justify-content-center align-items-center gap-3">
                                                    <a href="<?= base_url('kelolaproduk/edit/' .  $dataProduk->id_kue) ?>" class="button button-green flex-grow-1">Edit</a>
                                                    <a data-bs-toggle="modal" href="#modalHapus" data-id="<?= $dataProduk->id_kue ?>" role="button" class="button button-green flex-grow-1">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                                        <h1>Data Tidak Ditemukan</h1>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div id="kueulangtahun" class="tabContent">
                            <div class="row list-wrapper">
                                <?php if (count($produkK2) > 0) { ?>
                                    <?php foreach ($produkK2 as $dataProduk) { ?>
                                        <div class="col-md-6">
                                            <div class="box d-flex flex-column shadow">
                                                <div class="user">
                                                    <div class="image">
                                                        <img src="<?= base_url('gambarProduk/' . $dataProduk->gambar) ?>" alt="">
                                                    </div>
                                                    <div class="user-info">
                                                        <h3><?= $dataProduk->namaKue ?></h3>
                                                        <span>Rp<?= number_format($dataProduk->harga, 0, ',', '.') ?></span>
                                                    </div>
                                                </div>
                                                <div class="content d-flex flex-row justify-content-center align-items-center gap-3">
                                                    <a href="<?= base_url('kelolaproduk/edit/' .  $dataProduk->id_kue) ?>" class="button button-green flex-grow-1">Edit</a>
                                                    <a data-bs-toggle="modal" href="#modalHapus" data-id="<?= $dataProduk->id_kue ?>" role="button" class="button button-green flex-grow-1">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                                        <h1>Data Tidak Ditemukan</h1>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div id="dessertbox" class="tabContent">
                            <div class="row list-wrapper">
                                <?php if (count($produkK3) > 0) { ?>
                                    <?php foreach ($produkK3 as $dataProduk) { ?>
                                        <div class="col-md-6">
                                            <div class="box d-flex flex-column shadow">
                                                <div class="user">
                                                    <div class="image">
                                                        <img src="<?= base_url('gambarProduk/' . $dataProduk->gambar) ?>" alt="">
                                                    </div>
                                                    <div class="user-info">
                                                        <h3><?= $dataProduk->namaKue ?></h3>
                                                        <span>Rp<?= number_format($dataProduk->harga, 0, ',', '.') ?></span>
                                                    </div>
                                                </div>
                                                <div class="content d-flex flex-row justify-content-center align-items-center gap-3">
                                                    <a href="<?= base_url('kelolaproduk/edit/' .  $dataProduk->id_kue) ?>" class="button button-green flex-grow-1">Edit</a>
                                                    <a data-bs-toggle="modal" href="#modalHapus" data-id="<?= $dataProduk->id_kue ?>" role="button" class="button button-green flex-grow-1">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                                        <h1>Data Tidak Ditemukan</h1>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div id="kuekeringroti" class="tabContent">
                            <div class="row list-wrapper">
                                <?php if (count($produkK4) > 0) { ?>
                                    <?php foreach ($produkK4 as $dataProduk) { ?>
                                        <div class="col-md-6">
                                            <div class="box d-flex flex-column shadow">
                                                <div class="user">
                                                    <div class="image">
                                                        <img src="<?= base_url('gambarProduk/' . $dataProduk->gambar) ?>" alt="">
                                                    </div>
                                                    <div class="user-info">
                                                        <h3><?= $dataProduk->namaKue ?></h3>
                                                        <span>Rp<?= number_format($dataProduk->harga, 0, ',', '.') ?></span>
                                                    </div>
                                                </div>
                                                <div class="content d-flex flex-row justify-content-center align-items-center gap-3">
                                                    <a href="<?= base_url('kelolaproduk/edit/' .  $dataProduk->id_kue) ?>" class="button button-green flex-grow-1">Edit</a>
                                                    <a data-bs-toggle="modal" href="#modalHapus" data-id="<?= $dataProduk->id_kue ?>" role="button" class="button button-green flex-grow-1">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                                        <h1>Data Tidak Ditemukan</h1>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div id="pagination-container"></div>
                    </div>
                </div>

                <div id="dataFilter"></div>
            </div>

            <div class="modal fade p-3" id="modalHapus" tabindex="-1" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Pemberitahuan
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            Apakah anda yakin akan menghapus data produk dengan id <span class="fw-bold idProduk"></span> ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Tidak
                            </button>
                            <a type="button" class="btn btn-primary">Ya</a>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                $('#modalHapus').on('show.bs.modal', function(event) {
                    var id = $(event.relatedTarget).data('id');
                    $(this).find(".idProduk").text(id);
                    $(this).find("a").attr("href", "<?= base_url('/kelolaproduk/hapus') ?>" + "/" + id)
                });

                var tabLinks = document.querySelectorAll(".tablinks");
                var tabContent = document.querySelectorAll(".tabContent");
                var listWrapper = document.querySelectorAll('.list-wrapper')
                var listItem = document.querySelectorAll('.list-item')
                tabLinks.forEach(function(el) {
                    el.addEventListener("click", openTabs);
                });

                function openTabs(el) {
                    var btnTarget = el.currentTarget;
                    var kategori = btnTarget.dataset.kategori;

                    tabContent.forEach(function(el) {
                        el.classList.remove("active");
                    });

                    tabLinks.forEach(function(el) {
                        el.classList.remove("active");
                    });

                    listWrapper.forEach(function(el) {
                        el.classList.remove("list-wrapper");
                    });

                    listItem.forEach(function(el) {
                        el.classList.remove("list-item");
                    });

                    document.querySelector("#" + kategori).classList.add("active");
                    btnTarget.classList.add("active");


                    document.querySelector("#" + kategori + ' .row').classList.add("list-wrapper");

                    var item = document.querySelectorAll('#' + kategori + '> .row .col-md-6')
                    item.forEach(function(el) {
                        el.classList.add('list-item')
                    })

                    updatePagination()
                }

                function updatePagination() {
                    var items = $(".list-wrapper .list-item");
                    var numItems = items.length;
                    var perPage = 6;
                    $("#pagination-container").pagination({
                        items: numItems,
                        itemsOnPage: perPage,
                        prevText: "&laquo;",
                        nextText: "&raquo;",
                        onPageClick: function(pageNumber) {
                            var showFrom = perPage * (pageNumber - 1);
                            var showTo = showFrom + perPage;
                            items.hide().slice(showFrom, showTo).show();
                        },
                    });

                }

                $(document).ready(function() {
                    function load_data(query) {
                        $.ajax({
                            url: "<?= base_url('pencarianproduk'); ?>",
                            method: "POST",
                            data: {
                                keyword: query,
                            },
                            success: function(data) {
                                $('#dataFilter').html(data);
                                console.log(data)
                            }
                        })
                    }

                    $('#filter').keyup(function() {
                        var search = $(this).val();
                        if (search != '') {
                            $('#dataFilter').css('display', 'block')
                            $('#data').css('display', 'none')
                        } else {
                            $('#dataFilter').css('display', 'none')
                            $('#data').css('display', 'block')
                        }
                        load_data(search)
                    });
                });
            </script>

            <?= view('template/admin/footer') ?>
        </div>
    </div>
</body>

</html>