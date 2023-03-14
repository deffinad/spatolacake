<?php

namespace App\Models;

use CodeIgniter\Model;

class KodePromoModel extends Model
{
    //mengambil kode promo
    public function getKodePromo($keyword)
    {
        return $this->db->table('t_diskon')->like('nama', $keyword)->get();
    }
    //menambah kode promo
    public function tambahKodePromo($data)
    {
        return $this->db->table('t_diskon')->set($data)->insert();
    }
    //menghapus kode promo
    public function hapusKodePromo($idKodePromo)
    {
        return $this->db->table('t_diskon')->where('id_diskon', $idKodePromo)->delete();
    }
    //mengecek kode promo
    public function cekKodePromo($nama)
    {
        return $this->db->table('t_diskon')->where('nama', $nama)->get()->getRowArray();
    }
}
