<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    //menambah kontak pesan dengan parameter data
    public function tambahPembayaran($data)
    {
        return $this->db->table('t_pembayaran')->set($data)->insert();
    }

    public function editPembayaran($data, $idPemesanan)
    {
        return $this->db->table('t_pembayaran')->set($data)->where('id_pemesanan', $idPemesanan)->update();
    }

    public function getPembayaranByIdPemesanan($idPemesanan)
    {
        return $this->db->table('t_pembayaran')->where('id_pemesanan', $idPemesanan)->get();
    }

    // public function getTransaksiIdBerikutnya($id)
    // {
    //     $huruf = substr($id, 0, 7);
    //     $tempNomor = (int) substr($id, 7, null);
    //     $nomor = $tempNomor + 1;

    //     $nomorString = sprintf('%03s', $nomor);
    //     $nomorBerikutnya = $huruf . $nomorString;
    //     return $nomorBerikutnya;
    // }
}
