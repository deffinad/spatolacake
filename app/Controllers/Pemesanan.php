<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\KeranjangModel;
use App\Models\PembayaranModel;
use App\Models\PemesananModel;
use App\Models\ProdukModel;
use DateTime;

class Pemesanan extends BaseController
{
    //variabel 
    protected $session;
    protected $validation;
    protected $email;
    protected $mPemesanan;
    protected $mKeranjang;
    protected $mPembayaran;
    protected $mProduk;
    protected $mAuth;

    public function __construct()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-Pt3WivnSObk9DFBlaUqu1Flj';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        //inisiasi variabel
        $this->mPemesanan = new PemesananModel();
        $this->mPembayaran = new PembayaranModel();
        $this->mKeranjang = new KeranjangModel();
        $this->mProduk = new ProdukModel();
        $this->mAuth = new AuthModel();
        $this->email = \Config\Services::email();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->session->start();
    }

    //menampilkan view riwayat pemesanan
    public function riwayatPemesanan()
    {
        $this->session->set('route', 'riwayatPemesanan');
        $data['riwayatPemesanan'] = $this->mPemesanan->getHistoriPemesanan($_SESSION['LoggedUser']['id_user'], '')->getResult(); //mengambil data riwayat pemesanan berdasarkan id user

        foreach ($data['riwayatPemesanan'] as $item) {
            $konfirm_status = $this->formatKonfirmasiStatus($item->konfirmasi_status);
            $pembayaran = $this->mPembayaran->getPembayaranByIdPemesanan($item->id_pemesanan)->getResult();
            foreach ($pembayaran as $pmb) {
                $status = \Midtrans\Transaction::status($pmb->no_pembayaran);
                if ($status->transaction_status == 'settlement' && $konfirm_status == 'Selesaikan Pembayaran' && $item->id_user == $_SESSION['LoggedUser']['id_user']) {
                    $dataPembayaran = [
                        'tanggal' => $status->settlement_time,
                        'status' => $status->transaction_status
                    ];
                    $this->mPemesanan->editPemesanan($pmb->id_pemesanan, ['status_aktif' => 1, 'konfirmasi_status' => 'Pesanan Sedang Diproses']); //mengedit data pemesanan dengan data bukti pembayaran dan status menjadi 1 atau sudah berhasil melakukan pembayaran
                    $this->mKeranjang->editKeranjang(['status_aktif' => 1], ['id_keranjang' => $item->id_keranjang]); //mengedit keranjang dengan data status aktif 1 atau sudah melakukan pembayaran berdasarkan id keranjang
                } else if ($status->transaction_status == 'cancel' || $status->transaction_status == 'expire' && $item->id_user == $_SESSION['LoggedUser']['id_user']) {
                    $dataPembayaran = [
                        'status' => $status->transaction_status
                    ];

                    $this->mPemesanan->editPemesanan($pmb->id_pemesanan, ['status_aktif' => 1, 'konfirmasi_status' => $status->transaction_status == 'expire' ? 'Pesanan Gagal - Pemesanan Kadaluarsa' : 'Pesanan Gagal - Transaksi Ditolak']); //mengedit data pemesanan dengan data bukti pembayaran dan status menjadi 1 atau sudah berhasil melakukan pembayaran
                    $this->mKeranjang->editKeranjang(['status_aktif' => 1], ['id_keranjang' => $item->id_keranjang]); //mengedit keranjang dengan data status aktif 1 atau sudah melakukan pembayaran berdasarkan id keranjang
                } else {
                    $dataPembayaran = [
                        'status' => $status->transaction_status
                    ];
                }

                $this->mPembayaran->editPembayaran($dataPembayaran, $pmb->id_pemesanan);
            }
        }
        $data['riwayatPemesanan'] = $this->mPemesanan->getHistoriPemesanan($_SESSION['LoggedUser']['id_user'], '')->getResult(); //mengambil data riwayat pemesanan berdasarkan id user
        return view('customer/riwayatPemesanan', $data);
    }

    //proses pencarian riwayat pemesanan
    public function pencarianRiwayatPemesanan()
    {
        $output = '';
        $keyword = '';

        if ($this->request->getPost('keyword')) { //jika keyword diisi
            $keyword = $this->request->getPost('keyword'); //mengambil data keyword yang ada di view
        }
        $riwayatPemesanan = $this->mPemesanan->getHistoriPemesanan($_SESSION['LoggedUser']['id_user'], $keyword)->getResult(); //mengambil data riwayat pemesanan berdasarkan keyword yang akan dicari
        if ($riwayatPemesanan) { //jika data ditemukan
            //menampilkan data riwayat pemesanan
            $output .= '
            <table class="table table-borderless my-5">
                <thead>
                    <tr class="tabel-1">
                        <th scope="col">ID Order</th>
                        <th scope="col">Tanggal Pemesanan</th>
                        <th scope="col">Total</th>
                        <th scope="col" style="width: 24%;">Status</th>
                    </tr>
                </thead>

                <tbody class="table-group-divider table-bordered list-wrapper">
            ';

            foreach ($riwayatPemesanan as $histori) {
                $tgl_pemesanan = DateTime::createFromFormat('Y-m-d', $histori->tgl_pemesanan);
                $hari = $tgl_pemesanan->format('l');
                $tanggal = $tgl_pemesanan->format('d F Y');
                $tgl_pemesanan = $hari . ', ' . $tanggal;

                $status = $this->formatKonfirmasiStatus($histori->konfirmasi_status);

                $output .= '
                    <tr class="list-item">
                        <td>' . $histori->id_pemesanan . '</td>
                        <td>' . $tgl_pemesanan . '</td>
                        <td>Rp' . number_format($histori->total_pembayaran, 0, ',', '.') . '</td>
                        <td>';
                if ($status == 'Selesaikan Pembayaran' && $histori->status_aktif == 0) {
                    $output .= '<a href="' . base_url('formpemesanan/' . $histori->id_keranjang . '/' . $histori->tgl_pemesanan) . '" class="button button-success">Selesaikan Pembayaran</a>';
                } else if ($status == 'Pesanan Selesai') {
                    $output .= '<a href="' . base_url('detailpemesanan/' . $histori->id_pemesanan) . '" class="button button-success">Pesanan Selesai</a>';
                } else if ($status == 'Pesanan Gagal') {
                    $output .= '<a href="' . base_url('detailpemesanan/' . $histori->id_pemesanan) . '" class="button button-danger">Pesanan Gagal</a>';
                } else if ($status == 'Pesanan Sedang Diproses' || $histori->status_aktif == 1) {
                    $output .= '<a href="' . base_url('detailpemesanan/' . $histori->id_pemesanan) . '" class="button button-success">Pesanan Sedang Diproses</a>';
                }
                $output .= '
                        </td>
                    </tr>
                 ';
            }

            $output .= '
                    </tbody>
                </table>
            ';
        } else {
            //menampilkan view tidak ditemukan
            $output .= '
                <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                    <h1>Data Tidak Ditemukan</h1>
                </div>
            ';
        }

        //mengembalikan variabel output
        echo $output;
    }

    //menampilkan form pemesanan dengan parameter id keranjang dan tanggal perkiraan selesai
    public function formPemesanan($idKeranjang, $tglPerkiraanSelesai)
    {
        $this->session->set('route', 'riwayatPemesanan');
        $id = $this->mPemesanan->getIdTerakhir(); //mengambil id terakhir dari pemesanan
        $nextId = $this->mPemesanan->getIdBerikutnya($id); //mengambil id berikutnya dari pemesanan
        $id_user = $_SESSION['LoggedUser']['id_user']; //mengambil id user

        $detailKeranjang = $this->mKeranjang->getKeranjangById($idKeranjang)->getRowArray(); //mengambil detail keranjang berdasarkan id keranjang untuk mengambil total, diskon, dan biaya pengiriman
        $totalPembayaran = $detailKeranjang['total'] - $detailKeranjang['diskon'] + $detailKeranjang['biaya_pengiriman'];

        $sudahBayar = $this->mPemesanan->sudahBayar($id_user)->getLastRow(); //memanggil database untuk mengecek apakah sudah bayar atau belum
        if ($sudahBayar == NULL || $sudahBayar->status_aktif == 1) { //jika sudah bayar
            $id = $nextId; //id pemesanan sama dengan id berikutnya
            $dataPemesanan = [
                'id_pemesanan' => $id,
                'id_user' => $_SESSION['LoggedUser']['id_user'],
                'id_keranjang' => $idKeranjang,
                'tgl_pemesanan' => date('Y-m-d'),
                'tgl_perkiraanselesai' => $tglPerkiraanSelesai,
                'konfirmasi_status' => 'Selesaikan Pembayaran',
                'total_pembayaran' => $totalPembayaran,
                'status_aktif' => 0,
            ];
            $this->mPemesanan->tambahPemesanan($dataPemesanan); //menambah data pemesanan dengan memanggil model
        } else { //jika belum bayar
            //maka id sama dengan id sebelumnya
            $id = $sudahBayar->id_pemesanan;

            $dataPemesanan = [
                'tgl_perkiraanselesai' => $tglPerkiraanSelesai,
                'total_pembayaran' => $totalPembayaran,
            ];
            $this->mPemesanan->editPemesanan($id, $dataPemesanan); //menambah data pemesanan dengan memanggil model
        }

        $cek = $this->mPembayaran->getPembayaranByIdPemesanan($id)->getRowArray();
        if ($cek == null) {
            $data['status'] = '';
            $data['pembayaran'] = '';
        } else {
            $data['pembayaran'] = $cek;

            $data['status'] = \Midtrans\Transaction::status($cek['no_pembayaran']);
        }

        $data['pemesanan'] = $this->mPemesanan->getDetailPemesanan($id)->getRowArray(); //mengambil data pemesanan berdasasrkan id pemesanan
        $data['formPemesanan'] = $this->mPemesanan->getDetailPemesananForm($id)->getRowArray(); //mengambil data pemesanan berdasasrkan id pemesanan
        return view('customer/formPemesanan', $data);
    }

    //proses menambah form pemensanan
    public function tambahPemesanan($data)
    {
        $cek = $this->mPemesanan->getDetailPemesananForm($data['id_pemesanan'])->getResult();
        if ($cek != null) {
            $data = [
                'nama' => $data['nama'],
                'no_telp' => $data['no_telp'],
                'email' => $data['email'],
                'alamat' => $data['alamat'],
            ];

            $this->mPemesanan->editFormPemesanan($data['id_pemesanan'], $data); //menambah tambah form pemesanan
        } else {
            $data = [
                'id_pemesanan' => $data['id_pemesanan'],
                'nama' => $data['nama'],
                'no_telp' => $data['no_telp'],
                'email' => $data['email'],
                'alamat' => $data['alamat'],
            ];

            $this->mPemesanan->tambahFormPemesanan($data); //menambah tambah form pemesanan
        }
    }

    //menampilkan view detail pemesanan dengan parameter id pemesanan
    public function detailPemesanan($idPemesanan)
    {
        $this->session->set('route', 'riwayatPemesanan');
        $data['detailPemesanan'] = $this->mPemesanan->getDetailPemesananForm($idPemesanan)->getResult(); //mengambil data detail pemesanan berdasarkan id pemesanan
        $id_keranjang = $data['detailPemesanan'][0]->id_keranjang; //mengambil id keranjang dari data detail pemesanan
        $data['keranjang'] = $this->mKeranjang->getDetailKeranjang($id_keranjang)->getResult(); //mengambil data detail keranjang berdasarkan id keranjang
        $data['dasarKue'] = $this->mProduk->getSemuaDasarKue()->getResult(); //menampilkan semmua dasar kue
        return view('customer/detailPemesanan', $data);
    }

    //menampilkan view pesanan admin
    public function pesananAdmin()
    {
        $this->session->set('route', 'pesanan');
        $data['pemesanan'] = $this->mPemesanan->getPemesanan('')->getResult(); //mengambil semua data pemesanan
        return view('admin/pesanan', $data);
    }

    //proses pencarian pesanan admin
    public function pencarianPesananAdmin()
    {
        $output = '';
        $keyword = '';

        if ($this->request->getPost('keyword')) { //jika keyword yang dimasukan diisi
            $keyword = $this->request->getPost('keyword'); //mengambil data keyword dari view
        }

        $pemesanan = $this->mPemesanan->getPemesanan($keyword)->getResult(); //mengambil data pemesanan berdasarkan keyword yang digunakan

        if (count($pemesanan) == 0) { //jika pemesanan kososng
            //menampilkan view data tidak ditemukan
            $output .= '
                <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                    <h1>Data Tidak Ditemukan</h1>
                </div>
            ';
        } else { //jika data pemesanan tidak kososng atau ada
            //menampilkan data pemesanan
            $output .= '
                <table class="table table-borderless">
                    <thead>
                        <tr class="tabel-1">
                            <th scope="col">ID Order</th>
                            <th scope="col">Tanggal Pemesanan</th>
                            <th scope="col">Total Pembayaran</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>

                    <tbody class="table-group-divider table-bordered list-wrapper">
            ';
            foreach ($pemesanan as $dataPemesanan) {
                $output .= '
                <tr class="list-item">
                    <td>' . $dataPemesanan->id_pemesanan . '</td>
                    <td>' . $dataPemesanan->tgl_pemesanan . '</td>
                    <td>Rp' . number_format($dataPemesanan->total_pembayaran, 0, ',', '.') . '</td>
                    <td>
                        <div class="d-flex flex-row gap-2 justify-content-center">
                            <a href="' . base_url('pesanan/detail/' . $dataPemesanan->id_pemesanan) . '" class="btn btn-warning">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a data-bs-toggle="modal" href="#modalHapus" role="button" data-id="<?= $dataPemesanan->id_pemesanan ?>" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
               ';
            }
            $output .= '
                </tbody>
            </table> 
              
            ';
        }
        //mengembalikan variabel output
        echo $output;
    }

    //menampilkan view detail pesanan admin dengan parameter id pemesanan
    public function detailPesananAdmin($idPemesanan)
    {
        $data['detailPemesanan'] = $this->mPemesanan->getDetailPemesananForm($idPemesanan)->getResult(); //mengambil data detail pemesanan berdasarkan id pemesanan
        $id_keranjang = $data['detailPemesanan'][0]->id_keranjang; //mengambil data id keranjang dari data detail pemesanan
        $data['keranjang'] = $this->mKeranjang->getDetailKeranjang($id_keranjang)->getResult(); //mengambil data detail keranjang berdasarkan id keranjang
        $data['dasarKue'] = $this->mProduk->getSemuaDasarKue()->getResult(); //mengambil semua data dasar kue 

        $this->session->set('route', 'pesanan');
        return view('admin/detailPesanan', $data);
    }

    //proses edit pemesanan dengan parameter id pemesanan
    public function editPesanan($idPemesanan)
    {
        //mengambil data dari view form
        $email = $this->request->getPost('email');
        $nama = $this->request->getPost('nama');
        $konfirmasi = $this->request->getPost('konfirmasi');
        $status = $this->request->getPost('status');
        $tglPerkiraanSelesai = $this->request->getPost('tglPerkiraanSelesai');

        $data = [
            'tgl_perkiraanselesai' => $tglPerkiraanSelesai,
            'konfirmasi_status' => $konfirmasi
        ];
        //mengedit pemesanan dengan data tanggal perkiraan selesai konfirmasi status
        $result = $this->mPemesanan->editPemesanan($idPemesanan, $data);
        if ($result) { //jika berhasil diedit
            //menampilkan pesan sukses
            $this->session->setFlashdata('sukses', 'Data Pemesanan Dengan ID <strong>' . $idPemesanan . '</strong> Berhasil Diedit');
            //format konfirmasi status
            $status = $this->formatKonfirmasiStatus($konfirmasi);
            //jika status nya tidak kosong
            if ($status != '') {
                $data['data'] = [
                    'status' => $status,
                    'nama' => $nama
                ];
                //mengirim email ke customer 
                $this->kirimEmailStatus($data, $email, 'Pemesanan Dengan ID ' . $idPemesanan);
            }
        } else { //jika gagal
            //menampilkan pesan gagal
            $this->session->setFlashdata('gagal', 'Data Pemesanan Dengan ID <strong>' . $idPemesanan . '</strong> Gagal Diedit');
        }

        return redirect()->to('pesanan/detail/' . $idPemesanan);
    }

    //proses menghapus pesnanan dengan parameter id pemesanan
    public function hapusPesanan($idPemesanan)
    {
        $this->session->set('route', 'pesanan');
        $result = $this->mPemesanan->hapusPemesanan($idPemesanan); //menghapus pemesanan dengan id parameter id pemesanan
        if ($result) { //jika berhasil mengahpus
            //menampilkan pesan sukses
            $this->session->setFlashdata('sukses', 'Data Pemesanan Dengan ID <strong>' . $idPemesanan . ' </strong>Berhasil Dihapus');
        } else { //jika gagal
            //menampilkan pesan gagal
            $this->session->setFlashdata('gagal', 'Data Pemesanan Dengan ID <strong>' . $idPemesanan . ' </strong>Gagal Dihapus');
        }

        return redirect()->to('/pesanan');
    }

    //proses kirim email pembayaran
    public function kirimEmailPembayaran()
    {
        $idPemesanan = $this->request->getPost('idPemesanan');
        $to = $this->request->getPost('to');
        $title = $this->request->getPost('title');

        $data['pemesanan'] = $this->mPemesanan->getDetailPemesanan($idPemesanan)->getRowArray(); //mengambil data detail pemesanan dengan id pemesanan
        $id_keranjang = $data['pemesanan']['id_keranjang']; //mengambil data id keranjang dari data pemesanan
        $data['keranjang'] = $this->mKeranjang->getDetailKeranjang($id_keranjang)->getResult(); //mengambil data detial keranjang berdasarkan id keranjang
        $data['dasarKue'] = $this->mProduk->getSemuaDasarKue()->getResult(); //mengambil semua data dasar kue
        //menampilkan view pembayaran untuk tampilan di email
        $pesan = view('email/pembayaran', $data);

        $this->email->setFrom('andinira@upi.edu', 'Spatola Cake'); //from buat email
        $this->email->setTo($to); //set untuk siapa 

        $this->email->setSubject($title); //subjectnya apaa
        $this->email->setMessage($pesan); //pesannya

        if (!$this->email->send()) { //jika gagal dikirm
            $json = [
                'gagal' => 'Kirim Email Pembayaran Gagal'
            ];
        } else { //jika berhasil
            $json = [
                'sukses' => 'Kirim Email Pembayaran Berhasil'
            ];
        }

        return $json;
    }

    //proses kirim email status
    public function kirimEmailStatus($data, $to, $title)
    {
        //menampilkan view status untuk tempilan di email
        $pesan = view('email/status', $data);

        $this->email->setFrom($_SESSION['LoggedAdmin']['email'], 'Spatola Cake'); //from buat email
        $this->email->setTo($to); //set untuk siapa

        $this->email->setSubject($title); //subject apa
        $this->email->setMessage($pesan); //pesannya

        if (!$this->email->send()) { //jika gagal dikirim 
            return false; //mengembalikan nilai false
        } else { //jika berhasil
            return true; //mengembalika nilai true
        }
    }

    //proses konfirmasi status
    public function formatKonfirmasiStatus($konfirmasi)
    {
        $index = strpos($konfirmasi, '-'); //mengambil index dan mencari sampai simbol '-' 
        if ($konfirmasi == '') { //jika konfirmasi kososng
            $status = ''; //statusnya kosong
        } else if ($index == true) { //jika '-' ditemukan
            $status = substr($konfirmasi, 0, $index - 1); //maka memformat konfirmasi
        } else { //jika '-' tidak ditemukan
            $status = $konfirmasi;  //status sama dengan konfirmasi
        }
        //mengembalikan status
        return $status;
    }
}
