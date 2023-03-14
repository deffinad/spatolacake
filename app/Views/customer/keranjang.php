<!DOCTYPE html>
<html lang="en">
<?= view('template/customer/head') ?>

<body>
    <?= view('template/customer/navbar') ?>

    <section id="cart">

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

        <h1 class="fw-bold" style="font-family: 'Poppins', sans-serif ;">Keranjang Anda</h1>
        <?php
        $catatan = $keranjang == NULL ? '' : $keranjang['catatan'];
        $biayaPengiriman = $keranjang == NULL ? '' : $keranjang['biaya_pengiriman'];
        $potongan = $potongan;
        $subTotal = $keranjang == NULL ? 0 : $keranjang['total'];
        $pilihPengiriman = '';
        $total = (int) $subTotal - (int) $potongan + (int) $biayaPengiriman;
        $tglPerkiraanSelesai = '';

        if ($input) {
            if ($input['catatan']) {
                $catatan = $input['catatan'];
            }
            if ($input['tglPerkiraanSelesai']) {
                $tglPerkiraanSelesai = $input['tglPerkiraanSelesai'];
            }
            if (array_key_exists('pilihPengiriman', $input)) {
                $pilihPengiriman = $input['pilihPengiriman'];
                if ($pilihPengiriman == 'Bandung') {
                    $biayaPengiriman = 25000;
                } else {
                    $biayaPengiriman = 35000;
                }
                $total = (int) $subTotal - (int) $potongan + (int) $biayaPengiriman;
            }
        }
        ?>

        <?php if ($detailKeranjang) { ?>
            <div class="cart-mobile d-flex flex-row d-none py-3">
                <?php foreach ($detailKeranjang as $dk) { ?>
                    <div class="item d-flex flex-column gap-3">
                        <div class="d-flex flex-row gap-3">
                            <div class="image">
                                <img src="<?= base_url('gambarProduk/' . $dk->gambar) ?>" alt="" class="rounded">
                            </div>

                            <div class="text d-flex flex-column justify-content-center">
                                <span class="head"><?= $dk->namaKue ?></span>
                                <span class="desc">
                                    <?php if ($dk->id_ukurankue != 0) {
                                        echo $dk->ukuran . ' - ';
                                    } ?>
                                    <?php if ($dk->id_dasarkue == 0) {
                                        echo 'Tidak Memakai Dasar Kue';
                                    } else {
                                        foreach ($dasarKue as $dkue) {
                                            if ($dk->id_dasarkue == $dkue->id_dasarkue) {
                                                echo $dkue->nama;
                                            }
                                        }
                                    }
                                    ?>
                                </span>
                                <span class="price">Rp<?= number_format($dk->sub_total, 0, ',', '.') ?></span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mx-1 align-items-center gap-3">
                            <input type="number" min="1" value="<?= $dk->jumlah ?>" class="form-control number-mobile">
                            <a data-bs-toggle="modal" href="#modalHapus" data-keranjang="<?= $dk->id_keranjang ?>" data-nama="<?= $dk->namaKue ?>" data-id="<?= $dk->id_detail ?>" role="button">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <table class="table table-responsive align-middle my-5 text-center">
                <thead>
                    <tr class="tabel-1">
                        <th scope="col" class="preview text-center">Gambar</th>
                        <th scope="col" class="description text-center">Deskripsi</th>
                        <th scope="col" class="text-center">Harga</th>
                        <th scope="col" class="text-center">Jumlah</th>
                        <th scope="col" class="text-center" style="font-weight:bold">Total</th>
                        <th scope="col" class="text-center"></th>
                    </tr>
                </thead>

                <tbody class="table-group table-bordered">
                    <?php foreach ($detailKeranjang as $dk) { ?>
                        <tr class="table-text">
                            <td>
                                <img src="<?= base_url('gambarProduk/' . $dk->gambar) ?>" alt="" class="image-cart rounded">
                            </td>
                            <td style="word-wrap:break-word;text-align: left;" class="px-5">
                                <p class="font-cart" style="font-weight:500"><?= $dk->namaKue ?></p>
                                <p>
                                    <?php if ($dk->ukuran != '0cm') {
                                        echo $dk->ukuran;
                                    } ?>
                                    <?php if ($dk->id_dasarkue != 0) {
                                        foreach ($dasarKue as $dkue) {
                                            if ($dk->id_dasarkue == $dkue->id_dasarkue) {
                                                echo ' - ' . $dkue->nama;
                                            }
                                        }
                                    }
                                    ?>
                                </p>
                            </td>
                            <td class="text-center">Rp<?= number_format($dk->harga, 0, ',', '.') ?></td>
                            <td class="text-center">
                                <span><?= $dk->jumlah ?></span>
                            </td>
                            <td style="font-weight:bold" class="text-center">Rp<?= number_format($dk->sub_total, 0, ',', '.') ?></td>
                            <td>
                                <div class="action text-center">
                                    <a data-bs-toggle="modal" href="#modalHapus" data-keranjang="<?= $dk->id_keranjang ?>" data-nama="<?= $dk->namaKue ?>" data-id="<?= $dk->id_detail ?>" role="button">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="check-out">
                <form method="POST" action="<?= base_url('keranjang') ?>" class="d-flex flex-row align-items-stretch justify-content-center gap-4">
                    <div class="d-flex flex-column gap-4">

                        <div class="check-out1 d-flex flex-row gap-4">
                            <div class="notes flex-grow-1">
                                <p>Catatan</p>
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Silahkan isi catatan bila perlu" id="floatingTextarea2" name="catatan" style="height: 90px"><?= $catatan ?></textarea>
                                    <label for="floatingTextarea2" class="fw-normal">Silahkan isi catatan bila perlu</label>
                                </div>

                                <input type="hidden" class="form-control p-3" name="biayaPengiriman" id="biayaPengiriman" value="<?= $biayaPengiriman ?>" placeholder="Silahkan masukkan kode">
                                <input type="hidden" class="form-control p-3" name="potonganHarga" value="<?= $potongan ?>" placeholder="Silahkan masukkan kode">
                                <input type="hidden" class="form-control p-3" name="idKeranjang" value="<?= $keranjang['id_keranjang'] ?>" placeholder="Silahkan masukkan kode">
                            </div>

                            <div class="notes">
                                <p>Silahkan Pilih Tanggal Pengiriman</p>
                                <input type="date" class="form-control p-3 mt-4" name="tglPerkiraanSelesai" value="<?= $tglPerkiraanSelesai ?>">
                            </div>
                        </div>

                        <div class="check-out2 d-flex flex-row gap-4">
                            <div class="promo">
                                <div class="d-flex flex-row align-items-center gap-3">
                                    <p>Jika mempunyai kode promo, silahkan masukkan kode di bawah ini</p>
                                    <div>
                                        <div class="d-flex justify-content-center align-items-center text-center" style="background-color:black; width: 20px; height: 20px; padding: 13px; border-radius: 100%;" data-bs-toggle="tooltip" data-bs-placement="top" title="Kode promo bisa dilihat di halaman profil">
                                            <i class="fa fa-info text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row gap-3">
                                    <input type="text" class="form-control p-3" name="diskon" placeholder="Silahkan masukkan kode">
                                    <button type="submit" name="submitDiskon" class="button button-black" style="border: none;">Gunakan</button>
                                </div>
                            </div>

                            <div class="wilayah w-75 d-flex flex-column">
                                <p class="w-75">Pilih wilayah untuk pengiriman</p>
                                <div class="d-flex flex-grow-1 align-items-end flex-row gap-3">
                                    <select class="form-select p-3" name="pilihPengiriman" id="pilihPengiriman" required>
                                        <option selected disabled>Pilih Pengiriman</option>
                                        <option <?php if ($pilihPengiriman == 'Bandung') {
                                                    echo 'selected';
                                                } ?>>Bandung</option>
                                        <option <?php if ($pilihPengiriman == 'Luar Bandung') {
                                                    echo 'selected';
                                                } ?>>Luar Bandung</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="d-flex flex-column detail">
                        <span>Check Out</span>
                        <div class="flex-grow-1">
                            <table>
                                <tr>
                                    <td>Sub Total</td>
                                    <td>Rp<?= number_format($subTotal, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>Potongan Harga</td>
                                    <td>Rp<?= number_format($potongan, 0, ',', '.') ?></td>
                                </tr>
                                <tr class="border-b">
                                    <td>Biaya Pengiriman</td>
                                    <td class="biayaPengiriman">Rp<?= number_format($biayaPengiriman, 0, ',', '.') ?></td>
                                </tr>
                                <tr class="fw-bold">
                                    <td>Total Pembayaran</td>
                                    <td class="totalPembayaran">Rp<?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                        </div>
                        </table>
                    </div>

                    <div class="d-flex flex-row justify-content-center flex-grow-1 mt-5 align-items-end gap-3">
                        <button type="submit" name="submitSimpan" class="button button-black flex-grow-1" style="font-weight: bold;border: none;">Simpan</button>
                        <button type="submit" name="submitBayar" class="button button-black flex-grow-1" style="font-weight: bold;border:none;">Bayar</button>
                    </div>
                </form>

            </div>
        <?php } else { ?>
            <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
                <h2>Belum ada keranjang</h2>
            </div>
        <?php } ?>

    </section>

    <div class="modal fade p-3" id="modalHapus" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pemberitahuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    Apakah anda yakin akan menghapus item ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                    <a class="btn btn-primary">Ya</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#modalHapus').on('show.bs.modal', function(event) {
            var id = $(event.relatedTarget).data('id');
            var nama = $(event.relatedTarget).data('nama');
            var keranjang = $(event.relatedTarget).data('keranjang');
            $(this).find("a").attr("href", "<?= base_url('/keranjang/hapuskeranjang/') ?>" + "/" + id + '/' + nama + '/' + keranjang)
        });

        $('#pilihPengiriman').on('change', function() {
            var value = this.value
            if (value == 'Bandung') {
                <?php
                $total = (int) $subTotal - (int) $potongan + 25000;
                ?>
                $('td.biayaPengiriman').text('Rp<?= number_format(25000, 0, ',', '.') ?>')
                $('td.totalPembayaran').text('Rp<?= number_format($total, 0, ',', '.') ?>')
                $('#biayaPengiriman').val(25000)
            } else {
                <?php
                $total = (int) $subTotal - (int) $potongan + 35000;
                ?>
                $('td.biayaPengiriman').text('Rp<?= number_format(35000, 0, ',', '.') ?>')
                $('td.totalPembayaran').text('Rp<?= number_format($total, 0, ',', '.') ?>')
                $('#biayaPengiriman').val(35000)
            }
        })
    </script>

    <?= view('template/customer/footer') ?>
</body>

</html>