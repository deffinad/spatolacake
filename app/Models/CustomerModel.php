<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    //menambah kontak pesan dengan parameter data
    public function tambahKontak($data)
    {
        return $this->db->table('t_kontak')->set($data)->insert();
    }
    
    public function tambahPengembalian($data)
    {
        return $this->db->table('t_pengembalian')->set($data)->insert();
    }
}
