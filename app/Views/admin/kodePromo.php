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
                        <h1 class="title">Kode Promo</h1>
                    </div>

                    <div class="search d-flex align-items-start">
                        <form class="flex-fill">
                            <div class="input-group">
                                <input type="text" class="form-control" id="filter" placeholder="Cari berdasarkan nama" name="keyword" />
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
                    <a data-bs-toggle="modal" href="#modalTambah" class="button button-green mb-5">Tambah Kode Promo</a>
                </div>

                <div id="data">
                    <div class="row mb-4">
                        <?php if (count($promo) == 0) { ?>
                            <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                                <h1>Data Tidak Ditemukan</h1>
                            </div>
                        <?php } else { ?>
                            <?php foreach ($promo as $dataPromo) {
                                $tgl_berakhir = DateTime::createFromFormat('Y-m-d', $dataPromo->tanggal_berakhir);
                                $tanggal = $tgl_berakhir->format('d F Y');
                                $tgl_berakhir = $tanggal;
                            ?>

                                <div class="col-4">
                                    <div class="content-box position-relative d-flex flex-column justify-content-center align-items-center " style="height: 250px">
                                        <span class="text-uppercase fw-bold fs-3"><?= $dataPromo->nama ?></span>
                                        <span class="text-center mb-3">Berakhir <?= $tgl_berakhir ?></span>
                                        <span class="fw-semibold fs-5 text-center">Potongan Harga</span>
                                        <span class="fw-semibold">Rp<?= number_format($dataPromo->potongan, 0, ',', '.') ?></span>

                                        <a data-bs-toggle="modal" href="#modalHapus" data-nama="<?= $dataPromo->nama ?>" data-id="<?= $dataPromo->id_diskon ?>" role="button" class="position-absolute" style="top: 10px; right: 20px">
                                            <i class="fas fa-times fs-4 text-secondary"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
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
                            Apakah anda yakin akan menghapus kode promo dengan nama <span class="fw-bold idKodePromo"></span> ini?
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

            <div class="modal fade p-3" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="border: none">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-2 px-4">
                            <h4 class="modal-title mb-3 text-center">Tambah Kode Promo</h4>
                            <form action="<?= base_url('kodepromo') ?>" method="POST">
                                <div class="mb-3">
                                    <label>Kode Promo</label>
                                    <input type="text" placeholder="Masukan kode promo" class="form-control py-3" name="nama" style="background-color: #eaeaea" required />
                                </div>
                                <div class="mb-3">
                                    <label>Potongan</label>
                                    <input type="number" placeholder="Masukan harga yang akan dipotong" class="form-control py-3" name="potongan" style="background-color: #eaeaea" required />
                                </div>
                                <div class="mb-3">
                                    <label>Periode</label>
                                    <input type="date" placeholder="Masukan harga yang akan dipotong" class="form-control py-3" name="periode" style="background-color: #eaeaea" required />
                                </div>
                                <button type="submit" name="submitSimpan" class="button button-green my-4 w-100 py-2">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    function load_data(query) {
                        $.ajax({
                            url: "<?= base_url('pencariankodepromo'); ?>",
                            method: "POST",
                            data: {
                                keyword: query,
                            },
                            success: function(data) {
                                $('#dataFilter').html(data);
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

                $('#modalHapus').on('show.bs.modal', function(event) {
                    var id = $(event.relatedTarget).data('id');
                    var nama = $(event.relatedTarget).data('nama');
                    $(this).find(".idKodePromo").text(nama);
                    $(this).find("a").attr("href", "<?= base_url('/kodepromo/hapus') ?>" + "/" + id + "/" + nama)
                });
            </script>

            <?= view('template/admin/footer') ?>
        </div>
    </div>
</body>

</html>