<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggajianModel extends Model
{
    protected $table = 'penggajian';
    protected $primaryKey = ['id_komponen_gaji', 'id_anggota'];
    protected $allowedFields = ['id_komponen_gaji', 'id_anggota'];
    protected $useAutoIncrement = false; // Tidak ada auto-increment karena PK digabung
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

        public function getPenggajianWithDetails($id_anggota = null)
    {
        $builder = $this->db->table($this->table)
            ->join('anggota', 'penggajian.id_anggota = anggota.id_anggota', 'left')
            ->join('komponen_gaji', 'penggajian.id_komponen_gaji = komponen_gaji.id_komponen_gaji', 'left')
            ->select('
                penggajian.id_komponen_gaji, 
                penggajian.id_anggota, 
                anggota.nama_depan, 
                anggota.nama_belakang, 
                komponen_gaji.nama_komponen,
                komponen_gaji.kategori,
                komponen_gaji.nominal,
                komponen_gaji.satuan
            ');

        if ($id_anggota) {
            $builder->where('penggajian.id_anggota', $id_anggota);
        }

        return $builder->get()->getResultArray();
    }

}