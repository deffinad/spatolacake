<div class="modal fade p-3" id="modalSearch" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pencarian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= base_url('pencarian') ?>" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Pencarian" name="keyword" style="background-color:#b7d7b26b;">
                        <button class="btn" type="submit" name="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="main-footer">
    <footer class="row flex-row">
        <div class="col d-flex justify-content-center align-items-center">
            <div class="logo-widget footer-widget">
                <a href="<?= base_url('/') ?>"><img src="<?= base_url('assets/images/sc-2.png') ?>" alt="" width="250px" height="250px"></a>
            </div>
        </div>
        <div class="col py-4">
            <h5>LAYANAN PELANGGAN</h5>
            <ul class="nav flex-column gap-1">
                <li class="nav-item mb-2">
                    <a href="<?= base_url('faq') ?>" class="nav-link p-0 text-black">FAQ</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="<?= base_url('carapemesanan') ?>" class="nav-link p-0 text-black">Cara Pemesanan</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="<?= base_url('infopengiriman') ?>" class="nav-link p-0 text-black">Informasi Pengiriman</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="<?= base_url('refund') ?>" class="nav-link p-0 text-black">Kebijakan Pengembalian</a>
                </li>
            </ul>
        </div>
        <div class="col py-4">
            <h5>KONTAK KAMI</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <div class="nav-content p-0 text-black">
                        <i class="fa fa-map-marker-alt"> </i>
                        <span> &nbsp; &nbsp; Melati No. 1 Bandung</span>
                    </div>
                </li>

                <li class="nav-item mb-2">
                    <div class="nav-content p-0 text-black">
                        <i class="fa fa-phone-alt"> </i>
                        <a href="https://wa.me/082166271806" style="text-decoration:none; color: #000">
                            <span> &nbsp; &nbsp;081212121212</span>
                        </a>

                    </div>
                </li>

                <li class="nav-item mb-2">
                    <div class="nav-content p-0 text-black">
                        <i class="fa fa-envelope"> </i>
                        <a href="mailto: spatola@gmail.com" style="text-decoration:none; color: #000">
                            <span>&nbsp; &nbsp;spatola@gmail.com</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col py-4">
            <h5>IKUTI KAMI</h5>
            <ul class="nav flex-row gap-2">
                <a href="https://www.instagram.com/spatola_cake/" class="nav-link p-0 text-black"><i class="fab fa-instagram"></i></a>
                <a href="https://web.facebook.com/spatolaid" class="nav-link p-0 text-black"><i class="fab fa-facebook"></i></a>
            </ul>
        </div>
    </footer>
</div>

<section id="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="copyright">Copyright</a> &copy; 2022 Spatola Cakes & Cookies</div>
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.js"></script>
<script src="<?= base_url('assets/js/main.js') ?>"></script>

<script>
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    $('.toogle').click(function() {
        var text = $(this).attr('data-copy');
        var el = $(this);
        var toogle = '.toogle-' + text
        navigator.clipboard.writeText(text);
        $(toogle).attr('title', 'Copied!').tooltip('dispose').tooltip('show');

        setTimeout(function() {
            $(toogle).attr('title', 'Copy to Clipboard!').tooltip('dispose').tooltip();
        }, 2000)
    });
</script>