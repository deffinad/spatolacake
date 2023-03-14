<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>

<body>

    <?php
    $tgl_pemesanan = DateTime::createFromFormat('Y-m-d', $pemesanan['tgl_pemesanan']);
    $tgl_selesai = DateTime::createFromFormat('Y-m-d', $pemesanan['tgl_perkiraanselesai']);
    $hari = $tgl_pemesanan->format('l');
    $tanggal = $tgl_pemesanan->format('d F Y');
    $tgl_pemesanan = $hari . ', ' . $tanggal;

    $hari = $tgl_selesai->format('l');
    $tanggal = $tgl_selesai->format('d F Y');
    $tgl_selesai = $hari . ', ' . $tanggal;
    ?>

    <div style='width:100%;'>
        <h1>Silahkan Melakukan Pembayaran</h1>
        <div>
            <div>
                <p style='margin:0 !important;'>Atas Nama,</p>
                <p style='margin-top:10px; font-weight:600;'><?= $pemesanan['nama'] ?></p>
            </div>
            <div>
                <table style="color: black;">
                    <tr>
                        <td>ID Pemesanan</td>
                        <td>: <?= $pemesanan['id_pemesanan'] ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Pemesanan</td>
                        <td>: <?= $tgl_pemesanan ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Selesai</td>
                        <td>: <?= $tgl_selesai ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style='margin-top: 2rem;margin-bottom: 1rem;'>
            <table style='width:100%;background-color: #f7fdf3; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important; border-collapse: collapse; color:black;'>
                <thead>
                    <tr>
                        <th scope='col' style='font-weight: 600; padding: 0.5rem; color: black; background-color: #b7d7b2;'>
                            Deskripsi
                        </th>
                        <th scope='col' style='font-weight: 600; padding: 0.5rem; color: black; background-color: #b7d7b2;'>Harga</th>
                        <th scope='col' style='font-weight: 600; padding: 0.5rem; color: black; background-color: #b7d7b2;'>Jumlah</th>
                        <th scope='col' style='font-weight: 600; padding: 0.5rem; color: black; background-color: #b7d7b2;'>
                            Total
                        </th>
                    </tr>
                </thead>

                <tbody style='text-align: center;'>
                    <?php foreach ($keranjang as $dataKeranjang) { ?>
                        <tr>
                            <td style='padding:0.5rem; text-align: start;'>
                                <span> <?= $dataKeranjang->namaKue ?></span><br>
                                <span>
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
                                </span>
                            </td>
                            <td style='padding:0.5rem;'>Rp<?= number_format($dataKeranjang->harga, 0, ',', '.') ?></td>
                            <td style='padding:0.5rem;'><?= $dataKeranjang->jumlah ?></td>
                            <td style='padding:0.5rem;'>Rp<?= number_format($dataKeranjang->sub_total, 0, ',', '.') ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div style='margin-top:2rem; width:100%; display:flex;'>

            <div style='width:50%;'></div>
            <table style='width:50%;'>
                <tr>
                    <td>Sub Total</td>
                    <td>: Rp<?= number_format($pemesanan['total'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>Potongan Harga</td>
                    <td>: Rp<?= number_format($pemesanan['diskon'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>Biaya Pengiriman</td>
                    <td>: Rp<?= number_format($pemesanan['biaya_pengiriman'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">Total Pembayaran</td>
                    <td style="font-weight: 600;">: Rp<?= number_format($pemesanan['total_pembayaran'], 0, ',', '.') ?></td>
                </tr>
            </table>
        </div>

        <div style='margin-top:2rem; width:100%;'>
            <p style='margin:0 !important;'>Salam Hormat,</p>
            <p style='margin-top:10px; font-weight:600;'>Tim Spatola Cake</p>
        </div>
    </div>
</body>

</html>