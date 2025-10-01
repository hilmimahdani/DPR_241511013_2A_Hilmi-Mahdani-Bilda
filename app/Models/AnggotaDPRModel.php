<?php
namespace App\Models;
use CodeIgniter\Model;

class AnggotaDPRModel extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_pengguna', 'id_anggota'];
}
