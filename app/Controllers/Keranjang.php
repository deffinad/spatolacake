<?php

namespace App\Controllers;

use App\Models\KeranjangModel;
use App\Models\KodePromoModel;
use App\Models\ProdukModel;

class Keranjang extends BaseController
{
    //variabel model
    protected $mKeranjang;
    protected $mProduk;
    protected $mKodePromo;
    //variabel session
    protected $session;

    public function __construct()
    {
        //inisialisai variabel
        $this->mKeranjang = new KeranjangModel();
        $this->mProduk = new ProdukModel();
        $this->mKodePromo = new KodePromoModel();
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    //menampilkan view keranjang dan proses
    public function keranjang()
    {
        unset($_SESSION['sukses']);
        unset($_SESSION['gagal']);
        $this->session->set('route', 'keranjang');
        $data['keranjang'] = $this->mKeranjang->getKeranjangByCustomer($_SESSION['LoggedUser']['id_user'])->getRowArray(); //mengambil data keranjang berdasarkan id customer
        $idKeranjang = $data['keranjang'] == NULL ? '' : $data['keranjang']['id_keranjang']; //mengambil id keranjang dari data keranjang
        $data['detailKeranjang'] = $this->mKeranjang->getDetailKeranjang($idKeranjang)->getResult(); //mengambil data detail keranjang berdasarkan id keranjang
        $data['dasarKue'] = $this->mProduk->getSemuaDasarKue()->getResult(); //mengambil semua data dasar kue
        $data['potongan'] = $data['keranjang'] == NULL ? '' : $data['keranjang']['diskon']; //mengambil potongan pada data keranjang
        $data['input'] = $this->request->getPost();

        if (isset($_POST['submitDiskon'])) { //jika tombol submit diskon ditekan pada view
            $cekKodePromo = $this->mKodePromo->cekKodePromo($_POST['diskon']); //mengecek kode promo apakah bisa digunakan atau tidak
            if ($cekKodePromo) { //jika kode promo dapat digunakan
                $data['potongan'] = $cekKodePromo['potongan']; //maka membuat variabel potongan dengan data potongan yang ada didatabase
                //menampoilkan pesan berhasil
                $this->session->setFlashdata('sukses', 'Anda Berhasil Mendapatkan Potongan Dengan Kode Promo <strong>' . $_POST['diskon'] . '</strong>');
            } else { //jika tidak
                //maka variabel potongan bernilai 0
                $data['potongan'] = 0;
                //menampilkan pesan gagal
                $this->session->setFlashdata('gagal', 'Maaf Kode Promo <strong>' . $_POST['diskon'] . ' </strong>Tidak Ditemukan');
            }
            $data['input'] = $this->request->getPost(); //mengambil input yang sudah digunakan
        }

        if (isset($_POST['submitSimpan'])) { //jika tombol submit simpan ditekan pada view
            if ($this->request->getPost('biayaPengiriman') == 0) { //cek jika biaya pengiriman tidak diisi
                $this->session->setFlashdata('gagal', 'Mohon Maaf Biaya Pengiriman Harus Diisi'); //maka menampilkan pesan gagal
            } else { //jika tidak
                $id = $this->request->getPost('idKeranjang'); //mengambil id keranjang pada view
                $dataKeranjang = [
                    'catatan' => $this->request->getPost('catatan'),
                    'diskon' => $this->request->getPost('potonganHarga'),
                    'biaya_pengiriman' => $this->request->getPost('biayaPengiriman'),
                ];

                $data['potongan'] = $this->request->getPost('potonganHarga');
                $this->mKeranjang->editKeranjang($dataKeranjang, ['id_keranjang' => $id]); //mengedit data keranjang dengan data yang dimasukan 
                $this->session->setFlashdata('sukses', 'Anda Berhasil Menyimpan Keranjang'); //menampilkan pesan berhasil
            }
        }

        if (isset($_POST['submitBayar'])) { //jika submit bayar ditekan pada view
            $tglPerkiraanSelesai = $this->request->getPost('tglPerkiraanSelesai'); //tanggal pengiriman mengambil dari view yang sudah dimasukan oleh customer
            $tglPemesanan = date('Y-m-d'); //tanggal pemesanan adalah tanggal sekarang
            $jarakTanggal = date('Y-m-d', strtotime($tglPemesanan . ' + 5 days')); //jarak tanggal yaitu tanggal pemesanan ditambah 5 hari

            if ($tglPerkiraanSelesai == '') { //jika tanggal pengiriman tidak diisi
                $data['input'] = $this->request->getPost();
                $data['potongan'] = $this->request->getPost('potonganHarga');
                //menampilkan pesan gagal
                $this->session->setFlashdata('gagal', 'Mohon Maaf Tanggal Pengiriman Harus Diisi');
            } else if ($this->request->getPost('biayaPengiriman') == 0) { //jika biaya pengiriman tidak diisi
                $data['input'] = $this->request->getPost();
                $data['potongan'] = $this->request->getPost('potonganHarga');
                //menampilkan pesan gagal
                $this->session->setFlashdata('gagal', 'Mohon Maaf Biaya Pengiriman Harus Diisi');
            } else if ($tglPerkiraanSelesai < $jarakTanggal) { //jika tanggal pengiriman dibawah dari jarak tanggal pemeesanan
                $data['input'] = $this->request->getPost();
                $data['potongan'] = $this->request->getPost('potonganHarga');
                //menampilkan pesan
                $this->session->setFlashdata('gagal', 'Mohon Maaf Pengiriman Kue Hanya Dapat Dikirim 4 Hari setelah Tanggal Pemesanan');
            } else { //jika data diisi semua
                $id = $this->request->getPost('idKeranjang');
                $dataKeranjang = [
                    'catatan' => $this->request->getPost('catatan'),
                    'diskon' => $this->request->getPost('potonganHarga'),
                    'biaya_pengiriman' => $this->request->getPost('biayaPengiriman'),
                ];

                $this->mKeranjang->editKeranjang($dataKeranjang, ['id_keranjang' => $id]); //mengeedit keranjang dengan data berdasarkan id keranjang
                return redirect()->to('formpemesanan/' . $id . '/' . $tglPerkiraanSelesai);
            }
        }
        return view('customer/keranjang', $data);
    }

    //proses tambah keranjang
    public function tambahKeranjang()
    {
        $this->session->set('route', 'keranjang');
        $id = $this->mKeranjang->getIdTerakhir(); //mengambil id keranjang dari data yang terakhir
        $nextId = $this->mKeranjang->getIdBerikutnya($id); //mengambil id berikutnya dari id keranjang yang terakhir
        $id_user = $_SESSION['LoggedUser']['id_user']; //id user mengambil dari id user pada session

        //mengambil data pada view
        $idKue = $this->request->getPost('idKue');
        $namaKue = $this->request->getPost('namaKue');
        $idDasarKue = $this->request->getPost('idDasarKue');
        $idUkuranKue = $this->request->getPost('idUkuranKue');
        $jumlah = $this->request->getPost('jumlah');
        $harga = $this->request->getPost('harga');
        $subTotal = $harga * $jumlah;

        $sudahCheckout = $this->mKeranjang->sudahCheckOut($id_user)->getLastRow(); //mengecek apakah data sebelumnya sudah cekout apa belum
        if ($sudahCheckout == NULL || $sudahCheckout->status_aktif == 1) { //jika sudah cekout
            $dataKeranjang = [
                'id_keranjang' => $nextId,
                'id_user' => $id_user,
                'total' => 0,
                'catatan' => '',
                'diskon' => 0,
                'biaya_pengiriman' => 0,
                'status_aktif' => 0,
            ];
            $this->mKeranjang->tambahKeranjang($dataKeranjang); //maka data keranjang ditambahkan
            $id = $nextId; //id keranjang sama dengan id keranjang yang berikutnya
        } else { //jika belum cekout
            //maka id keranjang nya tetap
            $id = $sudahCheckout->id_keranjang;
        }


        $totalKeranjang = 0; //total keranjang bernilai 0
        $dataKeranjang = $this->mKeranjang->getKeranjangById($id)->getResult(); //mengambil data keranjang berdasarkan id keranjang untuk mengambil total keranjang yang nantinya dijumlahkan oleh sub total
        foreach ($dataKeranjang as $val) {
            $totalKeranjang = $val->total + $subTotal;
        }

        //mengedit keranjang dengan data total berdasarkan id
        $this->mKeranjang->editKeranjang(['total' => $totalKeranjang], ['id_keranjang' => $id]);

        //KONDISI JIKA TAMBAH KERANJANG MEMILIKI ITEM YANG SAMA (UKURAN, LAPISAN), MAKA JUMLAH PADA DETAIL KERANJANG BERTAMBAH
        $cek = [
            'id_keranjang' => $id,
            'id_kue' => $idKue,
            'id_dasarkue' => $idDasarKue == NULL ? 0 : $idDasarKue,
            'id_ukurankue' => $idUkuranKue
        ];

        $cekDetail = $this->mKeranjang->cekDetailKeranjangSama($cek); //mengecek data detail keranjang apakah ada yang sama atau tidak
        if ($cekDetail) { //jika customer membeli item dengan nama kue, ukuran, dan dasar kue yang sama
            $dataDetailKeranjang = [
                'jumlah' => $jumlah + $cekDetail['jumlah'],
                'sub_total' => $subTotal + $cekDetail['sub_total'],
            ];

            //mengedit detail keranjang dengan data jumlah dan subtotal berdasarkan id
            $result = $this->mKeranjang->editDetailKeranjang($dataDetailKeranjang, $cek);
        } else { //jika tidak ada yang sama
            $dataDetailKeranjang = [
                'id_keranjang' => $id == '' ? $nextId : $id,
                'id_kue' => $idKue,
                'id_dasarkue' => $idDasarKue == NULL ? 0 : $idDasarKue,
                'id_ukurankue' => $idUkuranKue,
                'jumlah' => $jumlah,
                'sub_total' => $subTotal,
            ];
            //maka menambah detail keranjang dengan data keranjang
            $result = $this->mKeranjang->tambahDetailKeranjang($dataDetailKeranjang);
        }
        if ($result) { //jika berhasil
            //menampilkan pesan berhasil
            $this->session->setFlashdata('sukses', '<strong>' . $namaKue . ' </strong>Berhasil Ditambahkan Ke Keranjang');
        } else { //jika gagal
            //menampilkan pesan gagal
            $this->session->setFlashdata('gagal', '<strong>' . $namaKue . ' </strong>Gagal Ditambahkan Ke Keranjang');
        }
        return redirect()->to('keranjang');
    }

    //proses hapus detail keranjang dengan paramater id detail keranjang, nama kue, dan id keranjang
    public function hapusDetailKeranjang($idDetail, $namaKue, $idKeranjang)
    {
        $dataKeranjang = $this->mKeranjang->getKeranjangById($idKeranjang)->getResult(); //mengambil data keranjang berdasarkan id keranjang
        $cekDetail = $this->mKeranjang->cekDetailKeranjangSama(['id_detail' => $idDetail]); //mengambil detail keranjang berdasarkan id keranjang

        foreach ($dataKeranjang as $val) {
            $totalKeranjang = $val->total - $cekDetail['sub_total']; //mengurangi total keranjang pada data keranjang
        }
        //mengedit data keranjang dengan data total keranjang yang sudha dikurang dengan item yang akan dihapus
        $this->mKeranjang->editKeranjang(['total' => $totalKeranjang], ['id_keranjang' => $idKeranjang]);

        //menghapus detail keranjang berdasarkan id detail keranjang
        $result = $this->mKeranjang->hapusDetailKeranjang($idDetail);
        if ($result) { //jika berhasil
            //menampilkan pesan sukses
            $this->session->setFlashdata('sukses', '<strong>' . $namaKue . ' </strong>Berhasil Dihapus Dari Keranjang');
        } else { //jika gagal
            //menampilkan pesan gagal
            $this->session->setFlashdata('gagal', '<strong>' . $namaKue . ' </strong>Gagal Dihapus Dari Keranjang');
        }
        return redirect()->to('keranjang');
    }
}
