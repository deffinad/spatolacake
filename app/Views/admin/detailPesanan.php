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
                    <div class="flex-grow-1 d-flex gap-3 flex-row align-items-center">
                        <a href="<?= base_url('pesanan') ?>">
                            <i class="fas fa-arrow-left fs-3"></i>
                        </a>
                        <h1 class="title" style="font-family: 'Poppins', sans-serif ;">Detail Pesanan</h1>
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

                <div class="content-box">
                    <?php foreach ($detailPemesanan as $dataDP) { ?>
                        <form action="<?= base_url('pesanan/detail/edit/' . $dataDP->id_pemesanan) ?>" method="POST">
                            <div class="row detail mb-3">
                                <div class="col-4">
                                    <label for="inputId" class="form-label">ID Pemesanan</label>
                                    <input type="text" class="form-control" name="idPemesanan" value="<?= $dataDP->id_pemesanan ?>" readonly />
                                </div>
                                <div class="col-4">
                                    <label for="inputName" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" value="<?= $dataDP->nama ?>" readonly />
                                </div>
                                <div class="col-4">
                                    <label for="inputName" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="<?= $dataDP->email ?>" readonly />
                                </div>
                            </div>
                            <div class="row detail mb-3">
                                <div class="col-4">
                                    <label for="inputPhoneNumber" class="form-label">Nomor HP</label>
                                    <input type="text" class="form-control" value="<?= $dataDP->no_telp ?>" readonly />
                                </div>
                                <div class="col-4">
                                    <label for="inputDate" class="form-label">Tanggal Pemesanan</label>
                                    <input type="date" class="form-control" value="<?= $dataDP->tgl_pemesanan ?>" id="inputDate" readonly />
                                </div>
                                <div class="col-4">
                                    <label for="inputDate2" class="form-label">Tanggal Perkiraan Selesai</label>
                                    <input type="date" class="form-control" name="tglPerkiraanSelesai" value="<?= $dataDP->tgl_perkiraanselesai ?>" <?php if (formatKonfirmasiStatus($dataDP->konfirmasi_status) == "Pesanan Selesai") {
                                                                                                                                                        echo 'readonly';
                                                                                                                                                    } ?> />
                                </div>
                            </div>
                            <div class="row detail mb-3">
                                <div class="col-12">
                                    <label for="inputAddress" class="form-label">Alamat Lengkap</label>
                                    <textarea type="text" class="form-control" id="inputAddress" readonly><?= $dataDP->alamat ?></textarea>
                                </div>
                            </div>
                            <div class="row detail mb-3">
                                <div class="col-12">
                                    <label for="inputItems" class="form-label">Rincian Item</label>
                                    <table class="table table-responsive align-middle text-center">
                                        <thead>
                                            <tr class="tabel-1">
                                                <th scope="col" class="text-center">Gambar</th>
                                                <th scope="col" class="description text-center">
                                                    Deskripsi
                                                </th>
                                                <th scope="col" class="text-center">Harga</th>
                                                <th scope="col" class="text-center">Jumlah</th>
                                                <th scope="col" class="text-center" style="font-weight: bold">
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-group table-bordered">
                                            <?php foreach ($keranjang as $dataKeranjang) { ?>
                                                <tr class="table-text">
                                                    <td>
                                                        <img src="<?= base_url('gambarProduk/' . $dataKeranjang->gambar) ?>" style="width: 100px; height: 100px;border-radius: 20px;">
                                                    </td>
                                                    <td style="
                                                    word-wrap: break-word;
                                                    text-align: left;
                                                    width: 40%;
                                                " class="px-5">
                                                        <p class="font-cart" style="font-weight: 500">
                                                            <?= $dataKeranjang->namaKue ?>
                                                        </p>
                                                        <p>
                                                            <?php if ($dataKeranjang->ukuran != '0cm') {
                                                                echo $dataKeranjang->ukuran;
                                                            } ?>
                                                            <?php if ($dataKeranjang->id_dasarkue != 0) {
                                                                foreach ($dasarKue as $dkue) {
                                                                    if ($dataKeranjang->id_dasarkue == $dkue->id_dasarkue) {
                                                                        echo ' - ' . $dkue->nama;
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </p>
                                                    </td>
                                                    <td class="text-center">Rp<?= number_format($dataKeranjang->harga, 0, ',', '.') ?></td>
                                                    <td>
                                                        <?= $dataKeranjang->jumlah ?>
                                                    </td>
                                                    <td style="font-weight: bold" class="text-center">
                                                        Rp<?= number_format($dataKeranjang->sub_total, 0, ',', '.') ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                    <div class="row mx-2 mb-3 mt-4">
                                        <div class="detail-payment col-md-7">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <p>Sub Total</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Rp<?= number_format($dataDP->total, 0, ',', '.') ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <p>Potongan Harga</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Rp<?= number_format($dataDP->diskon, 0, ',', '.') ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <p>Biaya Pengiriman</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Rp<?= number_format($dataDP->biaya_pengiriman, 0, ',', '.') ?></p>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <p class="fw-bold">Total Pembayaran</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="fw-bold">Rp<?= number_format($dataDP->total_pembayaran, 0, ',', '.') ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 mx-2 d-flex flex-row gap-4">
                                <div class="flex-grow-1 d-flex flex-column align-items-stretch">
                                    <label for="inputNotes" class="form-label">Catatan</label>
                                    <textarea type="text" class="form-control flex-grow-1" id="inputNotes"><?= $dataDP->catatan ?></textarea>
                                </div>
                                <div class="flex-grow-1">
                                    <label for="inputStatus" class="form-label">Konfirmasi Status</label>
                                    <select class="form-select mb-3" id="selectKonfirmasiStatus" name="status" onchange="konfirmasiStatus();">
                                        <option selected disabled>Pilih Status Konfirmasi</option>
                                        <option value="Pesanan Sedang Diproses">Pesanan Sedang Diproses</option>
                                        <option value="Pesanan Gagal">Pesanan Gagal</option>
                                        <option value="Pesanan Selesai">Pesanan Selesai</option>
                                    </select>

                                    <textarea type="text" class="form-control" name="konfirmasi" id="textKonfirmasiStatus" style="height: 80px;"><?= $dataDP->konfirmasi_status ?></textarea>
                                </div>
                            </div>

                            <div class="d-flex mt-4 justify-content-end">
                                <?php if (formatKonfirmasiStatus($dataDP->konfirmasi_status) != "Pesanan Selesai") { ?>
                                    <button class="button button-green px-5 py-2" type="submit">Kirim</button>
                                <?php } ?>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>

            <script>
                function konfirmasiStatus() {
                    let valSelect = document.getElementById('selectKonfirmasiStatus').value;
                    document.getElementById('textKonfirmasiStatus').value = valSelect + ' - detail konfirmasi.....';
                }

                function lihatBuktiPembayaran(linkImage) {
                    newWindow = window.open('<?= base_url('pesanan/buktipembayaran') ?>' + '/' + linkImage);
                    // newWindow.print();
                }
            </script>

            <?= view('template/admin/footer') ?>
        </div>
    </div>
</body>

</html>