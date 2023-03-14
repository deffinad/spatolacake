<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>

<body>
    <div style='width:100%;'>
        <h1>Pengembalian</h1>
        <?php if ($pengembalian['alasan'] != '') { ?>
            <div>
                <div>
                    <p style='margin:0 !important;'>Atas Nama,</p>
                    <p style='margin-top:10px; font-weight:600;'><?= $pengembalian['nama'] ?></p>
                </div>
                <div>
                    <table style="color: black;">
                        <tr>
                            <td style='width:70px;'>No. Telp</td>
                            <td> : </td>
                            <td><?= $pengembalian['no_telp'] ?></td>
                        </tr>
                        <tr>
                            <td style='width:70px;'>Email</td>
                            <td> : </td>
                            <td><?= $pengembalian['email'] ?></td>
                        </tr>
                        <tr>
                            <td style='width:70px;'>Alasan Pengembalian</td>
                            <td> : </td>
                            <td><?= $pengembalian['alasan'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <p>Hai <strong><?= $pengembalian['nama'] ?></strong>, kami dengan tulus meminta maaf atas ketidaknyamanan yang Anda alami karena hal itu, kami sangat menghargai upaya anda dalam menyampaikan hal Pengembalian Produk ini. Terima kasih telah memperhatikan dan memberi tahu kami. Sekali lagi mohon maaf dan kami akan memberikan solusi untuk masalah Anda😊</p>
            
            <div style='margin-top:2rem; width:100%;'>
                <p style='margin:0 !important;'>Salam Hormat,</p>
                <p style='margin-top:10px; font-weight:600;'>Tim Spatola Cake</p>
            </div>
        <?php } ?>


    </div>
</body>

</html>