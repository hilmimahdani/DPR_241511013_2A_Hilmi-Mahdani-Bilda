<?php

namespace App\Models;
use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    protected $allowedFields = ['gelar_depan', 'nama_depan', 'nama_belakang', 'gelar_belakang', 'jabatan', 'status_pernikahan', 'jumlah_anak'];
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    public function getAnggotaWithSearch($search = null)
    {
        $builder = $this->db->table($this->table);
        if ($search) {
            $builder->groupStart();
            $builder->like('nama_depan', $search);
            $builder->orLike('nama_belakang', $search);
            $builder->orLike('jabatan', $search);
            $builder->orLike('id_anggota', $search);
            $builder->groupEnd();
        }
        return $builder->get()->getResultArray();
    }

        public function delete($id = null, $purge = false)
    {
        if($id){
        $this->where($this->primaryKey, $id)->delete($this->table);
        return $this->db->affectedRows() > 0;
        }
        return false;
    }

}
