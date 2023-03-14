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
                        <h1 class="title">Pengembalian Produk</h1>
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

                <?php if (count($pengembalian) == 0) { ?>
                    <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                        <h1>Data Tidak Ditemukan</h1>
                    </div>
                <?php } else { ?>
                    <table class="table table-borderless">
                        <thead>
                            <tr class="tabel-1">
                                <th scope="col">No</th>
                                <th scope="col">Nama Pelanggan</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody class="table-group-divider table-bordered list-wrapper">
                            <?php foreach ($pengembalian as $dataPengembalian) { ?>
                                <tr class="list-item">
                                    <td><?= $dataPengembalian->id_pengembalian ?></td>
                                    <td><?= $dataPengembalian->nama ?></td>
                                    <td>
                                        <div class="d-flex flex-row gap-2 justify-content-center">
                                            <a data-bs-toggle="modal" href="#modalDetail" data-id="<?= $dataPengembalian->id_pengembalian ?>" data-nama="<?= $dataPengembalian->nama ?>" data-notelp="<?= $dataPengembalian->no_telp ?>" data-email="<?= $dataPengembalian->email ?>" data-alasan="<?= $dataPengembalian->alasan ?>" data-gambar="<?= $dataPengembalian->buktiGambar ?>" role="button" class="btn btn-warning">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                            <a data-bs-toggle="modal" href="#modalHapus" data-id="<?= $dataPengembalian->id_pengembalian ?>" role="button" class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                <?php } ?>
            </div>

            <div class="modal fade p-3" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="border: none">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-2 px-4 text-center">
                            <h4 class="modal-title mb-3">Pengembalian Produk</h4>
                            <div class="mb-3 text-start">
                                <label>Nama Lengkap</label>
                                <input type="hidden" class="form-control id py-2" style="background-color: #f4f4f4" />
                                <input type="text" class="form-control nama py-2" style="background-color: #f4f4f4" readonly />
                            </div>
                            <div class="mb-3 text-start">
                                <label>Email</label>
                                <input type="text" class="form-control email py-2" style="background-color: #f4f4f4" readonly />
                            </div>
                            <div class="mb-3 text-start">
                                <label>Nomor HP</label>
                                <input type="text" class="form-control noTelp py-2" style="background-color: #f4f4f4" readonly />
                            </div>
                            <div class="mb-4 text-start">
                                <label>Alasan Pengembalian</label>
                                <textarea type="text" class="form-control alasan" style="height: 100px; background-color: #f4f4f4;" readonly></textarea>
                            </div>
                            <div class="mb-4 text-start">
                                <label>Bukti Gambar Produk Yang Diterima</label>
                                <button class="gambar button button-black my-3 w-100 py-2">
                                    Lihat Bukti Gambar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade p-3" id="modalHapus" tabindex="-1" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pemberitahuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            Apakah anda yakin akan menghapus pengembalian produk ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Tidak
                            </button>
                            <a class="btn btn-primary">Ya</a>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $('#modalDetail').on('show.bs.modal', function(event) {
                    var id = $(event.relatedTarget).data('id');
                    var nama = $(event.relatedTarget).data('nama');
                    var noTelp = $(event.relatedTarget).data('notelp');
                    var email = $(event.relatedTarget).data('email');
                    var alasan = $(event.relatedTarget).data('alasan');
                    var gambar = $(event.relatedTarget).data('gambar');

                    $(this).find(".id").val(id);
                    $(this).find(".nama").val(nama);
                    $(this).find(".noTelp").val(noTelp);
                    $(this).find(".email").val(email);
                    $(this).find(".alasan").text(alasan);
                    $(this).find(".gambar").attr("onclick", "lihatBuktiGambar('" + gambar + "')");
                });

                $('#modalHapus').on('show.bs.modal', function(event) {
                    var id = $(event.relatedTarget).data('id');
                    $(this).find("a").attr("href", "<?= base_url('/pengembalian/hapus') ?>" + "/" + id)
                });

                function lihatBuktiGambar(gambar) {
                    window.open('<?= base_url('pengembalian/') ?>' + "/" + gambar)
                }
            </script>
            <?= view('template/admin/footer') ?>
        </div>
    </div>
</body>

</html>