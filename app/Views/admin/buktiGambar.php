<!DOCTYPE html>
<html lang="en">
<?= view('template/admin/head') ?>

<body>
    <div class="wrapper d-flex justify-content-center align-items-center p-5">
        <img src="<?= base_url('buktiGambar/' . $gambar)?>">
    </div>

    <style>
        .wrapper{
            background-color: grey;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .wrapper img{
            border-radius: 20px;
            max-height: 600px;
        }
    </style>
</body>

</html>