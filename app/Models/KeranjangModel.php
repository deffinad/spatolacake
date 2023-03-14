<?php

namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    //mengambil keranjang berdasarkan id keranjang
    public function getKeranjangById($idKeranjang)
    {
        return $this->db->table('t_keranjang')->where('id_keranjang', $idKeranjang)->get();
    }
    //mengambil keranjang berdasarkan customer
    public function getKeranjangByCustomer($idUser)
    {
        return $this->db->table('t_keranjang')->where(['id_user' => $idUser, 'status_aktif' => 0])->get();
    }
    //mengambil data detail keranjang berdasarkan id keranjang
    public function getDetailKeranjang($idKeranjang)
    {
        return $this->db->table('t_detailkeranjang as dt')
            ->select('dt.id_detail, dt.id_keranjang, dt.id_kue, dt.id_dasarkue, dt.id_ukurankue, dt.jumlah, dt.sub_total, k.nama as namaKue, k.gambar, u.ukuran, u.harga')
            ->join('t_kue as k', 'k.id_kue = dt.id_kue')
            // ->join('t_dasarkue as dk', 'dk.id_dasarkue = dt.id_dasarkue')
            ->join('t_ukurankue as u', 'u.id_ukurankue = dt.id_ukurankue')
            ->where('dt.id_keranjang', $idKeranjang)
            ->get();
    }
    //mengecek customer sudah cekout apa belum
    public function sudahCheckOut($idUser)
    {
        return $this->db->table('t_keranjang')->where('id_user', $idUser)->get();
    }
    //mengecek detail keranjang jika customer pesan yang sama
    public function cekDetailKeranjangSama($data)
    {
        return $this->db->table('t_detailkeranjang')->where($data)->get()->getRowArray();
    }
    //mengambil id terakhir dari keranjang
    public function getIdTerakhir()
    {
        return $this->db->table('t_keranjang')->selectMax('id_keranjang')->get()->getRow('id_keranjang');
    }
    //mengambil id berikutnya dari keranjang
    public function getIdBerikutnya($id)
    {
        if ($id == '') {
            $nomorBerikutnya = 'SHPCRT001';
        } else {
            $huruf = substr($id, 0, 6);
            $tempNomor = (int) substr($id, 6, null);
            $nomor = $tempNomor + 1;

            $nomorString = sprintf('%03s', $nomor);
            $nomorBerikutnya = $huruf . $nomorString;
        }
        return $nomorBerikutnya;
    }
    //menambah data keranjang
    public function tambahKeranjang($data)
    {
        return $this->db->table('t_keranjang')->set($data)->insert();
    }
    //menambah detail keranjang 
    public function tambahDetailKeranjang($data)
    {
        return $this->db->table('t_detailkeranjang')->set($data)->insert();
    }
    //mengedit keranjang
    public function editKeranjang($data, $where)
    {
        return $this->db->table('t_keranjang')->set($data)->where($where)->update();
    }
    //mengedit detail keranjang
    public function editDetailKeranjang($data, $where)
    {
        return $this->db->table('t_detailkeranjang')->set($data)->where($where)->update();
    }
    //menghapus detail keranjang
    public function hapusDetailKeranjang($idDetail)
    {
        return $this->db->table('t_detailkeranjang')->where('id_detail', $idDetail)->delete();
    }
}
