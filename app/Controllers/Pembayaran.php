<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\KeranjangModel;
use App\Models\PembayaranModel;
use App\Models\PemesananModel;

class Pembayaran extends BaseController
{

    protected $mPembayaran;
    protected $mPemesanan;
    protected $mAuth;
    protected $session;
    protected $email;
    protected $cPemesanan;
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
        //inisialisasi session
        $this->mPemesanan = new PemesananModel();
        $this->mPembayaran = new PembayaranModel();
        $this->cPemesanan = new Pemesanan();
        $this->mAuth = new AuthModel();
        $this->mKeranjang = new KeranjangModel();
        $this->session = \Config\Services::session();
        $this->session->start();

        //email
        $this->email = \Config\Services::email();
    }

    //proses tambah pemesanan
    public function transaksiPembayaran()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getPost('nama') == '' || $this->request->getPost('noTelp') == '' || $this->request->getPost('email') == '' || $this->request->getPost('alamat') == '') {
                $json = [
                    'gagal' => 'Mohon Masukan Data Dengan Benar'
                ];
            } else {
                $customer = $this->mAuth->getCustomerById($_SESSION['LoggedUser']['id_user'])->getRowArray();
                $keranjang = $this->mKeranjang->getDetailKeranjang($this->request->getPost('idKeranjang'))->getResult(); //mengambil data detial keranjang berdasarkan id keranjang
                $detailKeranjang = $this->mKeranjang->getKeranjangById($this->request->getPost('idKeranjang'))->getRowArray();

                $dataCustomer = [
                    'first_name'   => $customer['nama'],
                    'address'      => $customer['alamat'],
                    'phone'        => $customer['no_telp']
                ];

                $dataShipping = [
                    'first_name'   => $this->request->getPost('nama'),
                    'address'      => $this->request->getPost('alamat'),
                    'phone'        => $this->request->getPost('noTelp')
                ];

                $customerDetail = [
                    'first_name'       => $customer['nama'],
                    'email'            => $customer['email'],
                    'phone'            => $customer['no_telp'],
                    'billing_address'  => $dataCustomer,
                    'shipping_address' => $dataShipping
                ];
                $no = 1;
                $items = array();
                foreach ($keranjang as $dataKeranjang) {
                    $namaKue = $dataKeranjang->namaKue;
                    $harga = $dataKeranjang->harga;
                    $jumlah = $dataKeranjang->jumlah;
                    array_push($items, [
                        'id'       => $no,
                        'price'    => (int)$harga,
                        'quantity' => (int)$jumlah,
                        'name'     => $namaKue
                    ]);
                    $no++;
                }

                array_push($items, [
                    'id'       => $no + 1,
                    'price'    => -(int)$detailKeranjang['diskon'],
                    'quantity' => 1,
                    'name'     => 'Diskon'
                ]);

                array_push($items, [
                    'id'       => $no + 1,
                    'price'    => +(int)$detailKeranjang['biaya_pengiriman'],
                    'quantity' => 1,
                    'name'     => 'Biaya Pengiriman'
                ]);

                $transaksiId = $this->request->getPost('idPemesanan') . '-' . rand();

                $params = array(
                    'transaction_details' => array(
                        'order_id' => $transaksiId,
                        'gross_amount' => $this->request->getPost('totalPembayaran'),
                    ),
                    'item_details' => $items,
                    'customer_details' => $customerDetail
                );

                $json = [
                    'snapToken' => \Midtrans\Snap::getSnapToken($params),
                ];
            }
            echo json_encode($json);
        }
        // //jika nama, notelp, email, dan alamat tidak diisi
        // if ($this->request->getPost('nama') == '' || $this->request->getPost('noTelp') == '' || $this->request->getPost('email') == '' || $this->request->getPost('alamat') == '') {
        //     //maka menampilkan pesan gagal
        //     $this->session->setFlashdata('gagal', 'Mohon Masukan Data Dengan Benar');
        //     return redirect()->to('formpemesanan/' . $this->request->getPost('idKeranjang'));
        // } else { //jika diisi
        //     //jika validasi gambar gagal
        //     if (!$this->validation->run(['buktiPembayaran' => $file], 'buktiPembayaran')) {
        //         //menampilkan pesan gagal
        //         $this->session->setFlashdata('gagal', 'Mohon Maaf, ' . $this->validation->getError());
        //         return redirect()->to('formpemesanan/' . $this->request->getPost('idKeranjang'));
        //     } else { //jika validasi gambar berhasil
        //         $data = [
        //             'id_pemesanan' => $this->request->getPost('idPemesanan'),
        //             'nama' => $this->request->getPost('nama'),
        //             'no_telp' => $this->request->getPost('noTelp'),
        //             'email' => $this->request->getPost('email'),
        //             'alamat' => $this->request->getPost('alamat'),
        //         ];

        //         $dataKeranjang = [
        //             'bukti_pembayaran' => $namaFile,
        //             'status_aktif' => 1
        //         ];

        //         $result = $this->mPemesanan->editPemesanan($this->request->getPost('idPemesanan'), $dataKeranjang); //mengedit data pemesanan dengan data bukti pembayaran dan status menjadi 1 atau sudah berhasil melakukan pembayaran
        //         $result = $this->mKeranjang->editKeranjang(['status_aktif' => 1], ['id_keranjang' => $this->request->getPost('idKeranjang')]); //mengedit keranjang dengan data status aktif 1 atau sudah melakukan pembayaran berdasarkan id keranjang
        //         $result = $this->mPemesanan->tambahFormPemesanan($data); //menambah tambah form pemesanan

        //         if ($result) { //jika berhasil ditambahkan
        //             //maka gambar dipindahkan ke folder public/buktiPembayaran
        //             $file->move('buktiPembayaran/', $namaFile);
        //             //menampilkan pesan berhasil
        //             $this->session->setFlashdata('sukses', 'Pemesanan Dengan ID  <strong>' . $this->request->getPost('idPemesanan') . ' </strong>Sedang Diproses');
        //         }
        //         return redirect()->to('detailpemesanan/' . $this->request->getPost('idPemesanan'));
        //     }
        // }
    }

    public function tambahPembayaran()
    {
        if ($this->request->isAJAX()) {
            $idPemesanan = $this->request->getPost('idPemesanan');
            $noPembayaran = $this->request->getPost('noPembayaran');
            $tipePembayaran = $this->request->getPost('tipePembayaran');
            $tanggal = $this->request->getPost('tanggal');
            $status = $this->request->getPost('status');
            $statusFile = $this->request->getPost('statusFile');
            $nama = $this->request->getPost('nama');
            $noTelp = $this->request->getPost('noTelp');
            $email = $this->request->getPost('email');
            $alamat = $this->request->getPost('alamat');

            $cek = $this->mPembayaran->getPembayaranByIdPemesanan($idPemesanan)->getRowArray();
            if ($cek == NULL) {
                $data = [
                    'id_pemesanan' => $idPemesanan,
                    'nama' => $nama,
                    'no_telp' => $noTelp,
                    'email' => $email,
                    'alamat' => $alamat,
                ];

                $this->mPemesanan->tambahFormPemesanan($data);

                $data = [
                    'id_pemesanan' => $idPemesanan,
                    'no_pembayaran' => $noPembayaran,
                    'tanggal' => $tanggal,
                    'tipe_pembayaran' => $tipePembayaran,
                    'status' => $status,
                    'status_file' => $statusFile
                ];

                $this->mPembayaran->tambahPembayaran($data);
                // $this->cPemesanan->kirimEmailPembayaran($idPemesanan, $email, 'Selesaikan Pembayaran Dengan ID Pemesanan ' . $idPemesanan);
            } else {
                $data = [
                    'nama' => $nama,
                    'no_telp' => $noTelp,
                    'email' => $email,
                    'alamat' => $alamat,
                ];

                $this->mPemesanan->editFormPemesanan($idPemesanan, $data);

                $data = [
                    'no_pembayaran' => $noPembayaran,
                    'tanggal' => $tanggal,
                    'tipe_pembayaran' => $tipePembayaran,
                    'status' => $status,
                    'status_file' => $statusFile
                ];

                $this->mPembayaran->editPembayaran($data, $idPemesanan);
            }


            $json = [
                'gagal' => 'Silahkan Lakukan Pembayaran Dengan ID Pemesanan <strong>' . $idPemesanan . ' </strong>'
            ];

            echo $json;
        }
    }
}
