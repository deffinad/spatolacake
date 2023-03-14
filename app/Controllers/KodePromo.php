<?php

namespace App\Controllers;

use App\Models\KodePromoModel;
use DateTime;

class KodePromo extends BaseController
{
    protected $session;
    protected $mKodePromo;
    public function __construct()
    {
        $this->mKodePromo = new KodePromoModel();
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    public function index()
    {
        if (isset($_POST['submitSimpan'])) {
            if ($_POST['nama'] && $_POST['potongan']) {
                $data = [
                    'nama' => $this->request->getPost('nama'),
                    'potongan' => $this->request->getPost('potongan'),
                    'tanggal_dibuat' => date('Y-m-d'),
                    'tanggal_berakhir' => $this->request->getPost('periode'),
                ];

                $result = $this->mKodePromo->tambahKodePromo($data);
                if ($result) {
                    $this->session->setFlashdata('sukses', 'Data Kode Promo Dengan Nama <strong>' . $this->request->getPost('nama') . ' </strong>Berhasil Ditambahkan');
                } else {
                    $this->session->setFlashdata('gagal', 'Data Kode Promo Dengan Nama <strong>' . $this->request->getPost('nama') . ' </strong>Gagal Ditambahkan');
                }
            }
        }

        $data['promo'] = $this->mKodePromo->getKodePromo('')->getResult();
        $this->session->set('route', 'kodepromo');
        return view('admin/kodePromo', $data);
    }

    public function pencarianKodePromo()
    {
        $output = '';
        $keyword = '';

        if ($this->request->getPost('keyword')) {
            $keyword = $this->request->getPost('keyword');
        }

        $promo = $this->mKodePromo->getKodePromo($keyword)->getResult();

        $output .= '
            <div class="row mb-4">
        ';
        if (count($promo) == 0) {
            $output .= '
                <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                    <h1>Data Tidak Ditemukan</h1>
                </div>
            ';
        } else {
            foreach ($promo as $dataPromo) {
                $tgl_berakhir = DateTime::createFromFormat('Y-m-d', $dataPromo->tanggal_berakhir);
                $tanggal = $tgl_berakhir->format('d F Y');
                $tgl_berakhir = $tanggal;
                
                $output .= '
                    <div class="col-4">
                        <div class="content-box position-relative d-flex flex-column justify-content-center align-items-center" style="height: 250px">
                            <span class="text-uppercase fw-bold fs-3">' . $dataPromo->nama . '</span>
                            <span class="text-center mb-3">Berakhir  ' . $tgl_berakhir . '</span>
                            <span class="fw-semibold fs-5 text-center">Potongan Harga</span>
                            <span class="fw-semibold">Rp' . number_format($dataPromo->potongan, 0, ',', '.') . '</span>

                            <a data-bs-toggle="modal" href="#modalHapus" data-nama="' . $dataPromo->nama . '" data-id="' . $dataPromo->id_diskon . '" role="button" class="position-absolute" style="top: 10px; right: 20px">
                                <i class="fas fa-times fs-4 text-secondary"></i>
                            </a>
                        </div>
                    </div>
                ';
            }
        }

        $output .= '
            </div>
        ';

        echo $output;
    }

    public function hapusKodePromo($idKodePromo, $kodePromo)
    {
        $result = $this->mKodePromo->hapusKodePromo($idKodePromo);
        if ($result) {
            $this->session->setFlashdata('sukses', 'Data Kode Promo Dengan Nama <strong>' . $kodePromo . ' </strong>Berhasil Dihapus');
        } else {
            $this->session->setFlashdata('gagal', 'Data Kode Promo Dengan Nama <strong>' . $kodePromo . ' </strong>Gagal Dihapus');
        }

        return redirect()->to('kodepromo');
    }
}
