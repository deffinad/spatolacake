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
                        <h1 class="title">Pesanan</h1>
                    </div>

                    <div class="search d-flex align-items-start">
                        <form class="flex-fill">
                            <div class="input-group">
                                <input type="text" class="form-control" id="filter" placeholder="Cari berdasarkan ID pesanan" name="keyword" />
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

                <div id="dataFilter"></div>

                <div id="data">
                    <?php if (count($pemesanan) == 0) { ?>
                        <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                            <h1>Data Tidak Ditemukan</h1>
                        </div>
                    <?php } else { ?>
                        <table class="table table-borderless">
                            <thead>
                                <tr class="tabel-1">
                                    <th scope="col">ID Order</th>
                                    <th scope="col">Tanggal Pemesanan</th>
                                    <th scope="col">Total Pembayaran</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>

                            <tbody class="table-group-divider table-bordered list-wrapper">
                                <?php foreach ($pemesanan as $dataPemesanan) { ?>
                                    <tr class="list-item">
                                        <td><?= $dataPemesanan->id_pemesanan ?></td>
                                        <td><?= $dataPemesanan->tgl_pemesanan ?></td>
                                        <td>Rp<?= number_format($dataPemesanan->total_pembayaran, 0, ',', '.') ?></td>
                                        <td>
                                            <div class="d-flex flex-row gap-2 justify-content-center">
                                                <a href="<?= base_url('pesanan/detail'), '/', $dataPemesanan->id_pemesanan ?>" class="btn btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a data-bs-toggle="modal" href="#modalHapus" role="button" data-id="<?= $dataPemesanan->id_pemesanan ?>" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div id="pagination-container"></div>
                    <?php } ?>
                </div>
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
                            Apakah anda yakin akan menghapus data pemesanan dengan id <span class="fw-bold idPemesanan"></span> ini?
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
                $(document).ready(function() {

                    function load_data(query) {
                        $.ajax({
                            url: "<?= base_url('pencarianpesanan'); ?>",
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
                        if(search != ''){
                            $('#dataFilter').css('display', 'block')
                            $('#data').css('display', 'none')
                        }else{
                            $('#dataFilter').css('display', 'none')
                            $('#data').css('display', 'block')
                        }
                        load_data(search)
                    });
                });

                $('#modalHapus').on('show.bs.modal', function(event) {
                    var id = $(event.relatedTarget).data('id');
                    $(this).find(".idPemesanan").text(id);
                    $(this).find("a").attr("href", "<?= base_url('/pesanan/hapus') ?>" + "/" + id)
                });
            </script>
            <?= view('template/admin/footer') ?>
        </div>
    </div>
</body>

</html>