<!DOCTYPE html>
<html lang="en">
<?= view('template/customer/head') ?>

<body>
    <?= view('template/customer/navbar') ?>

    <section id="order">
        <div class="container">
            <h1 class="title" style="font-family: 'Poppins', sans-serif ;">Formulir Pemesanan</h1>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Selamat!</strong> <span id="text-success"></span>
            </div>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Whoops!</strong> <span id="text-danger">test</span>
            </div>

            <?php
            $nama = $formPemesanan == null ? $pemesanan['nama'] : $formPemesanan['nama'];
            $email = $formPemesanan == null ? $pemesanan['email'] : $formPemesanan['email'];
            $noTelp = $formPemesanan == null ? $pemesanan['no_telp'] : $formPemesanan['no_telp'];
            $alamat = $formPemesanan == null ? $pemesanan['alamat'] : $formPemesanan['alamat'];

            $idKeranjang = $pemesanan['id_keranjang'];
            $idPemesanan = $pemesanan['id_pemesanan'];
            $total = $pemesanan['total'];
            $diskon = $pemesanan['diskon'];
            $biayaPengiman = $pemesanan['biaya_pengiriman'];
            $totalPembayaran = ($total - $diskon) + $biayaPengiman;

            $tglPemesanan = $pemesanan['tgl_pemesanan'];
            $tglPengiriman = $pemesanan['tgl_perkiraanselesai'];
            ?>
            <form>
                <div class="d-flex flex-row gap-5 my-5">
                    <div class="col-md-6 form-pesan">
                        <h3 class="fw-semibold mb-4">Isi Data Pengiriman</h3>
                        <div class="mb-3">
                            <label for="inputName" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" value="<?= $nama ?>" id="nama" required>
                            <input type="hidden" class="form-control" name="idKeranjang" value="<?= $idKeranjang ?>" id="idKeranjang" required>
                            <input type="hidden" class="form-control" name="idPemesanan" value="<?= $idPemesanan ?>" id="idPemesanan" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputPhoneNumber" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="noTelp" value="<?= $noTelp ?>" id="noTelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= $email ?>" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputAddress" class="form-label">Alamat Lengkap</label>
                            <textarea type="text" class="form-control" name="alamat" id="alamat" required><?= $alamat ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex flex-column gap-4">
                        <div class="payment">
                            <h3 class="fw-semibold">Selesaikan Pembayaran</h3>
                            <table class="table-responsive mt-3 fs-6 ">
                                <tr>
                                    <td class="fw-semibold">Total Pembayaran</td>
                                    <td class="px-3">Rp<?= number_format($totalPembayaran, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Tanggal Pemesanan</td>
                                    <td class="px-3"><?= $tglPemesanan ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Tanggal Pengiriman</td>
                                    <td class="px-3"><?= $tglPengiriman ?></td>
                                </tr>
                            </table>
                        </div>


                        <?php if ($status == '') { ?>
                            <div class="payment-bukti d-flex flex-row justify-content-between align-items-center gap-3">
                                <label for="formFile" class="form-label" style="font-weight:bold;">Transaksi Pembayaran</label>
                                <button type="button" class="button button-black" id="pembayaran">Lakukan Pembayaran </button>
                            </div>
                            <?php } else {
                            if ($status->transaction_status == 'pending') {
                            ?>
                                <div class="payment-bukti d-flex flex-row justify-content-between align-items-center gap-3">
                                    <label for="formFile" class="form-label" style="font-weight:bold;">Transaksi Pembayaran</label>
                                    <button type="button" class="button button-black" style="border:none;" id="konfirmasiPembayaran">Konfirmasi Pembayaran </button>
                                </div>

                            <?php } else if ($status->transaction_status == 'expire' || $status->transaction_status == 'cancel') { ?>
                                <div class="payment-bukti d-flex flex-row justify-content-between align-items-center gap-3">
                                    <label for="formFile" class="form-label" style="font-weight:bold;">Transaksi Pembayaran</label>
                                    <button type="button" class="button button-black" style="border:none;" id="pembayaran">Lakukan Pembayaran </button>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        $(".alert-danger").hide();
        $(".alert-success").hide();

        $('#konfirmasiPembayaran').click(function() {
            window.open('<?= $pembayaran ? $pembayaran['status_file'] : '' ?>')
        })

        $('#pembayaran').click(function(e) {
            e.preventDefault()
            $.ajax({
                type: 'post',
                url: '/formpemesanan/pembayaran',
                data: {
                    nama: $('#nama').val(),
                    idKeranjang: $('#idKeranjang').val(),
                    noTelp: $('#noTelp').val(),
                    alamat: $('#alamat').val(),
                    email: $('#email').val(),
                    idPemesanan: $('#idPemesanan').val(),
                    totalPembayaran: '<?= $totalPembayaran ?>',
                    tglPerkiraanSelesai: '<?= $tglPengiriman ?>',
                },
                dataType: 'json',
                success: function(response) {
                    if (response.gagal) {
                        $(".alert-danger").fadeTo(2000, 500).slideUp(500, function() {
                            $(".alert-danger").slideUp(500);
                        });
                        $('#text-danger').text(response.gagal)
                    } else {
                        snap.pay(response.snapToken, {
                            language: 'id',
                            autoCloseDelay: 1,
                            // Optional
                            onSuccess: function(result) {
                                /* You may add your own js here, this is just example */
                                dataResult = JSON.stringify(result, null, 2)
                                dataObj = JSON.parse(dataResult)

                                $.ajax({
                                    type: 'post',
                                    url: '/pembayaran/tambah',
                                    data: {
                                        nama: $('#nama').val(),
                                        noTelp: $('#noTelp').val(),
                                        alamat: $('#alamat').val(),
                                        email: $('#email').val(),
                                        idPemesanan: $('#idPemesanan').val(),
                                        noPembayaran: dataObj.order_id,
                                        tanggal: dataObj.transaction_time,
                                        tipePembayaran: dataObj.payment_type,
                                        status: dataObj.transaction_status,
                                        statusFile: dataObj.pdf_url
                                    },
                                    dataType: 'json',
                                    success: function(result) {
                                        console.log('sukses')
                                    }
                                })
                                window.location.href = '<?= base_url('detailpemesanan/') ?>' + $('#idPemesanan').val()
                            },
                            // Optional
                            onPending: function(result) {
                                /* You may add your own js here, this is just example */
                                dataResult = JSON.stringify(result, null, 2)
                                dataObj = JSON.parse(dataResult)

                                $.ajax({
                                    type: 'post',
                                    url: '/pembayaran/tambah',
                                    data: {
                                        nama: $('#nama').val(),
                                        noTelp: $('#noTelp').val(),
                                        alamat: $('#alamat').val(),
                                        email: $('#email').val(),
                                        idPemesanan: $('#idPemesanan').val(),
                                        noPembayaran: dataObj.order_id,
                                        tanggal: dataObj.transaction_time,
                                        tipePembayaran: dataObj.payment_type,
                                        status: dataObj.transaction_status,
                                        statusFile: dataObj.pdf_url
                                    },
                                    dataType: 'json',
                                    success: function(result) {
                                        console.log('pending')
                                    }
                                })

                                $.ajax({
                                    type: 'post',
                                    url: '/kirimEmailPembayaran',
                                    data: {
                                        idPemesanan: $('#idPemesanan').val(),
                                        to: $('#email').val(),
                                        title: 'Selesaikan Pembayaran Dengan ID Pemesanan ' + $('#idPemesanan').val(),
                                    },
                                    dataType: 'json',
                                    success: function(result) {
                                        console.log(result)
                                    }
                                })
                                window.location.href = '<?= base_url('riwayatpemesanan') ?>'
                            },
                            // Optional
                            onError: function(result) {
                                /* You may add your own js here, this is just example */
                                dataResult = JSON.stringify(result, null, 2)
                                dataObj = JSON.parse(dataResult)

                                $.ajax({
                                    type: 'post',
                                    url: '/pembayaran/tambah',
                                    data: {
                                        nama: $('#nama').val(),
                                        noTelp: $('#noTelp').val(),
                                        alamat: $('#alamat').val(),
                                        email: $('#email').val(),
                                        idPemesanan: $('#idPemesanan').val(),
                                        noPembayaran: dataObj.order_id,
                                        tanggal: dataObj.transaction_time,
                                        tipePembayaran: dataObj.payment_type,
                                        status: dataObj.transaction_status,
                                        statusFile: dataObj.pdf_url
                                    },
                                    dataType: 'json',
                                    success: function(result) {
                                        console.log('error')
                                    }
                                })

                                $.ajax({
                                    type: 'post',
                                    url: '/kirimEmailPembayaran',
                                    data: {
                                        idPemesanan: $('#idPemesanan').val(),
                                        to: $('#email').val(),
                                        title: 'Selesaikan Pembayaran Dengan ID Pemesanan ' + $('#idPemesanan').val(),
                                    },
                                    dataType: 'json',
                                    success: function(result) {
                                        console.log(result)
                                    }
                                })
                                window.location.href = '<?= base_url('riwayatpemesanan') ?>'
                            },
                        });
                    }
                },
            })
        })
    </script>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-vhTVSq22NCgJlYiI"></script>
    <?= view('template/customer/footer') ?>
</body>

</html>