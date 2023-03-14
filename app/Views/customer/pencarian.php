<!DOCTYPE html>
<html lang="en">
<?= view('template/customer/head') ?>

<body>
    <?= view('template/customer/navbar') ?>

    <section id="catalog-body" style="padding-top: 10rem !important;">
        <div class="head d-flex flex-row mb-5">
            <div class="flex-grow-1 d-flex align-items-center fs-4 fw-semibold">
                <?php if ($keyword != '') { ?>
                    Pencarian Untuk "<?= $keyword ?>"
                <?php } else { ?>
                    Semua Produk
                <?php } ?>
            </div>
            <div class="select">
                <select class="form-select flex-fill fw-semibold fs-6" id="filter">
                    <option selected disabled>Urut Berdasarkan</option>
                    <option value="Harga Termurah">Harga Termurah</option>
                    <option value="Harga Termahal">Harga Termahal</option>
                </select>
            </div>
        </div>
        <div class="container">
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
                                    <a href="<?= base_url('detailproduk/' . $dataProduk->id_kue) ?>" class="button button-green flex-grow-1 ">Pesan Sekarang</a>
                                    <!-- <form action="<?= base_url('keranjang/tambahkeranjang') ?>" method="POST" class="d-flex flex-row justify-content-center flex-grow-1">
                                        <input type="hidden" name="idKue" value="<?= $dataProduk->id_kue ?>" class="form-control" required>
                                        <input type="hidden" name="namaKue" value="<?= $dataProduk->namaKue ?>" class="form-control" required>
                                        <input type="hidden" name="idDasarKue" value="0" class="form-control" required>
                                        <input type="hidden" name="idUkuranKue" value="<?= $dataProduk->id_ukurankue ?>" class="form-control" required>
                                        <input type="hidden" name="jumlah" value="1" class="form-control" required>
                                        <input type="hidden" name="harga" value="<?= $dataProduk->harga ?>" class="form-control" required>
                                        <button type="submit" class="button flex-grow-1 border-0">Pesan</button>
                                    </form> -->
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
    </section>

    <script>
        $(document).ready(function() {
            function load_data(query) {
                $.ajax({
                    url: "<?= base_url('filterpencarian/'); ?>",
                    method: "POST",
                    data: {
                        keyword: query,
                        namaKue: '<?= $keyword ?>'
                    },
                    success: function(data) {
                        $('.list-wrapper').html(data);
                    }
                })
            }

            $('#filter').on('change', function() {
                var search = $(this).val();
                load_data(search)
            });
        });
    </script>

    <?= view('template/customer/footer') ?>
</body>

</html>