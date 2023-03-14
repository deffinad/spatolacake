<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>

<body>
    <div style='width:100%;'>
        <h1><?= $data['status'] ?></h1>

        <?php if($data['status'] == 'Pesanan Sedang Diproses'){ ?>
            <p>Hai <strong><?= $data['nama']?></strong>, terimakasih telah memesan produk Spatola Cake. Pesanan Anda sedang kami proses. Untuk informasi selanjutnya, akan kami beritahu kembali di web Spatola Cake😊</p>
        <?php }else{ ?>
            <p>Hai <strong><?= $data['nama']?></strong>, terimakasih telah memesan produk Spatola Cake. Kami tunggu pesanan Anda kembali di Spatola Cake😊</p>
        <?php } ?>
        
        <div style='margin-top:2rem; width:100%;'>
            <p style='margin:0 !important;'>Salam Hormat,</p>
            <p style='margin-top:10px; font-weight:600;'>Tim Spatola Cake</p>
        </div>


    </div>
</body>

</html>