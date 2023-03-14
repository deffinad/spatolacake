<!DOCTYPE html>
<html lang="en">
<?= view('template/customer/head') ?>

<body>
    <?= view('template/customer/navbar') ?>

    <section id="history">
        <div class="container">
            <div class="head d-flex flex-row">
                <div class="flex-grow-1">
                    <h1 class="fw-bold" style="font-family: 'Poppins', sans-serif ;">Histori Pemesanan Anda</h1>
                </div>

                <div class="search d-flex align-items-center">
                    <form class="flex-fill">
                        <div class="input-group">
                            <input type="text" class="form-control" id="pencarian" placeholder="Cari berdasarkan tanggal" name="keyword">
                            <button class="btn btn-primary" type="submit" name="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            function formatKonfirmasiStatus($konfirmasi)
            {
                $index = strpos($konfirmasi, '-');
                if ($konfirmasi == '') {
                    $status = '';
                } else if ($index == true) {
                    $status = substr($konfirmasi, 0, $index - 1);
                } else {
                    $status = $konfirmasi;
                }

                return $status;
            }
            ?>

            <div id="data">
                <?php if ($riwayatPemesanan) { ?>
                    <table class="table table-borderless my-5">
                        <thead>
                            <tr class="tabel-1">
                                <th scope="col">ID Order</th>
                                <th scope="col">Tanggal Pemesanan</th>
                                <th scope="col">Total</th>
                                <th scope="col" style="width: 24%;">Status</th>
                            </tr>
                        </thead>

                        <tbody class="table-group-divider table-bordered list-wrapper">

                            <?php foreach ($riwayatPemesanan as $histori) {
                                $tgl_pemesanan = DateTime::createFromFormat('Y-m-d', $histori->tgl_pemesanan);
                                $hari = $tgl_pemesanan->format('l');
                                $tanggal = $tgl_pemesanan->format('d F Y');
                                $tgl_pemesanan = $hari . ', ' . $tanggal;

                                $status = formatKonfirmasiStatus($histori->konfirmasi_status);
                            ?>
                                <tr class="list-item">
                                    <td><?= $histori->id_pemesanan ?></td>
                                    <td><?= $tgl_pemesanan ?></td>
                                    <td>Rp<?= number_format($histori->total_pembayaran, 0, ',', '.') ?></td>
                                    <td>
                                        <?php if ($status == 'Selesaikan Pembayaran' && $histori->status_aktif == 0) { ?>
                                            <a href="<?= base_url('formpemesanan/' . $histori->id_keranjang . '/' . $histori->tgl_perkiraanselesai) ?>" class="button button-success">Selesaikan Pembayaran</a>
                                        <?php } else if ($status == 'Pesanan Selesai') { ?>
                                            <a href="<?= base_url('detailpemesanan/' . $histori->id_pemesanan) ?>" class="button button-success">Pesanan Selesai</a>
                                        <?php } else if ($status == 'Pesanan Gagal') { ?>
                                            <a href="<?= base_url('detailpemesanan/' . $histori->id_pemesanan) ?>" class="button button-danger">Pesanan Gagal</a>
                                        <?php } else if ($status == 'Pesanan Sedang Diproses' || $histori->status_aktif == 1) { ?>
                                            <a href="<?= base_url('detailpemesanan/' . $histori->id_pemesanan) ?>" class="button button-success">Pesanan Sedang Diproses</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div id="pagination-container"></div>

                <?php } else { ?>
                    <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                        <h1>Data Tidak Ditemukan</h1>
                    </div>
                <?php } ?>
            </div>

            <div id="dataFilter"></div>


        </div>
    </section>

    <script>
        $(document).ready(function() {

            function load_data(query) {
                $.ajax({
                    url: "<?= base_url('pencarianriwayatpemesanan/'); ?>",
                    method: "POST",
                    data: {
                        keyword: query
                    },
                    success: function(data) {
                        $('#dataFilter').html(data);
                    }
                })
            }

            $('#pencarian').keyup(function() {
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
    <?= view('template/customer/footer') ?>
</body>

</html>