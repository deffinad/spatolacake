<!DOCTYPE html>
<html lang="en">
<?= view('template/customer/head') ?>

<body>
  <?= view('template/customer/navbar') ?>

  <section id="catalog2">
    <div class="catalog2-content d-flex flex-column justify-content-center align-items-center shadow">
      <h1>Katalog Spatola Cake</h1>
      <div class="catalog-body d-flex flex-row align-items-center justify-content-center gap-4 mt-5">
        <?php foreach ($kategori as $dataKategori) { ?>
          <a class="catalog-item d-flex flex-column justify-content-center align-items-center gap-3 shadow" onclick="filterKategori('<?= $dataKategori->namaKategori ?>')">
            <img src="<?= base_url('gambarProduk'), '/', $dataKategori->gambar ?>" class="rounded-circle" />
            <p><?= $dataKategori->namaKategori ?></p>
          </a>
        <?php } ?>
      </div>
  </section>

  <section id="catalog-body">
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
                  <a href="<?= base_url('detailproduk/' . $dataProduk->id_kue) ?>" class="button button-green my-3 flex-grow-1 ">Pesan Sekarang</a>
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
    function load_data(query) {
      $.ajax({
        url: "<?= base_url('filterkatalog/'); ?>",
        method: "POST",
        data: {
          keyword: query,
        },
        success: function(data) {
          $('.list-wrapper').html(data);
          $('html,body').animate({ //  fine in moz, still quicker in chrome. 
            scrollTop: $("#catalog-body").offset().top - 50
          }, 100);
        }
      })
    }

    function filterKategori(kategori) {
      load_data(kategori)
    }
  </script>

  <?= view('template/customer/footer') ?>
</body>

</html>