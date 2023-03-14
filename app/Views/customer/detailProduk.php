<!DOCTYPE html>
<html lang="en">
<?= view('template/customer/head') ?>

<body>
    <?= view('template/customer/navbar') ?>

    <?php foreach ($detailProduk as $dt) { ?>
        <section id="detail-menu">
            <div class="d-flex">
                <a href="<?= base_url('/katalog') ?>" class="button button-green"><i class="fa fa-angle-left"></i><span class="mx-2">Kembali</span></a>
            </div>
            <div class="detail-header">
                <div class="menu shadow">
                    <div class="sub-menu d-flex flex-row justify-start gap-5">
                        <div class="image">
                            <img src="<?= base_url('gambarProduk/' . $dt->gambar) ?>" class="shadow">
                        </div>

                        <div class="d-flex flex-column justify-content-center mx-4 flex-grow-1">
                            <form action="<?= base_url('keranjang/tambahkeranjang') ?>" method="POST">
                                <div class="menu-content d-flex flex-row gap-3">
                                    <div class="menu-text flex-grow-1">
                                        <h1><?= $dt->namaKue ?></h1>
                                        <span id="hargaText">Rp<?= number_format($dt->harga, 0, ',', '.') ?></span><br>
                                        <p class="fs-6 fw-normal mt-3">Kategori <?= $dt->namaKategori ?></p>
                                    </div>
                                    <div class="menu-number flex-grow-1 d-flex justify-content-center align-items-center">
                                        <input type="number" min="1" value="1" name="jumlah" class="form-control number" required>
                                        <input type="hidden" name="idKue" value="<?= $dt->id_kue ?>" class="form-control" required>
                                        <input type="hidden" name="namaKue" value="<?= $dt->namaKue ?>" class="form-control" required>
                                    </div>
                                </div>

                                <div class="menu-select mt-4 d-flex flex-row gap-3">
                                    <?php if (count($ukuranKue)) { ?>
                                        <input type="hidden" name="idUkuranKue" value="<?= $dt->id_ukurankue ?>" id="idUkuranKue">
                                        <input type="hidden" name="harga" value="<?= $dt->harga ?>" id="hargaInput">
                                        <?php if ($dt->ukuran != '0cm') { ?>
                                            <select class="form-select flex-grow-1" id="selectUkuran" required>
                                                <option selected disabled value="">Pilih Ukuran Kue</option>
                                                <?php foreach ($ukuranKue as $dataUkuran) { ?>
                                                    <option value="<?= $dataUkuran->id_ukurankue ?>" <?php if ($dt->id_ukurankue == $dataUkuran->id_ukurankue) {
                                                                                                            echo 'selected';
                                                                                                        } ?>><?= $dataUkuran->ukuran ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if (count($dasarKue)) { ?>
                                        <input type="hidden" name="idDasarKue" id="idDasarKue">
                                        <select class="form-select flex-grow-1" id="selectDasar" required>
                                            <option selected disabled value="">Pilih Dasar Kue</option>
                                            <?php foreach ($dasarKue as $dataLapisan) { ?>
                                                <option value="<?= $dataLapisan->id_dasarkue ?>"><?= $dataLapisan->nama ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>

                                <div class="d-flex">
                                    <button type="submit" class="button button-black mt-5 flex-grow-1">Pesan Sekarang</button>
                                </div>
                        </div>
                    </div>

                    <div class="detail-informasi d-flex flex-row gap-5" style="margin-top: 4rem;">
                        <?php if ($dt->deskripsi !== '') { ?>
                            <div class="item flex-grow-1">
                                <h1>Detail</h1>
                                <p><?= $dt->deskripsi ?></p>
                            </div>
                        <?php } ?>
                        <?php if ($dt->informasi !== '') { ?>
                            <div class="item flex-grow-1">
                                <h1>Informasi</h1>
                                <p><?= $dt->informasi ?></p>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>

        </section>

        <?php if (count($pilihanLain) > 1) { ?>
            <section id="pilihan" style="padding-top: 5rem !important;">
                <div class="pilihan-content shadow">
                    <h3 class="pilihan-head">Pilihan Lainnya</h3>
                    <div class="owl-carousel owl-pilihan" id="owl-carousel">
                        <?php foreach ($pilihanLain as $dataPilihan) { ?>
                            <div class="item box my-5 shadow">
                                <div class="user d-flex flex-row align-items-center gap-4">
                                    <img src="<?= base_url('gambarProduk/' . $dataPilihan->gambar) ?>" alt="">
                                    <div class="user-info">
                                        <h3><?= $dataPilihan->namaKue ?></h3>
                                        <span>Rp<?= number_format($dataPilihan->harga, 0, ',', '.') ?></span>
                                    </div>
                                </div>
                                <div class="content d-flex flex-row justify-content-center align-items-center gap-3 mt-4">
                                    <a href="<?= base_url('detailproduk/' . $dataPilihan->id_kue) ?>" class="button flex-grow-1">Pesan Sekarang</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
        <?php } ?>

    <?php } ?>

    <script>
        $('#owl-carousel').owlCarousel({
            loop: false,
            margin: 20,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 2
                }
            }
        })

        $('#selectUkuran').on('change', function() {
            var value = this.value

            <?php foreach ($ukuranKue as $val) { ?>
                if (value === '<?= $val->id_ukurankue ?>') {
                    $('#hargaText').text('Rp<?= number_format($val->harga, 0, ',', '.') ?>')
                    $('#idUkuranKue').val('<?= $val->id_ukurankue ?>')
                    $('#hargaInput').val('<?= $val->harga ?>')
                }
            <?php } ?>
        })

        $('#selectDasar').on('change', function() {
            var value = this.value

            <?php foreach ($dasarKue as $val) { ?>
                if (value === '<?= $val->id_dasarkue ?>') {
                    $('#idDasarKue').val('<?= $val->id_dasarkue ?>')
                }
            <?php } ?>
        })
    </script>
    <?= view('template/customer/footer') ?>
</body>

</html>