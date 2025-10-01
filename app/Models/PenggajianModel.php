<?php

namespace App\Controllers;

use App\Models\PenggajianModel;

namespace App\Models;
use CodeIgniter\Model;



class PenggajianController extends BaseController

{
    protected $penggajianModel;
    protected $anggotaModel;
    protected $komponenGajiModel;

    public function __construct()
    {
        $this->penggajianModel = new PenggajianModel();
        $this->anggotaModel = new AnggotaModel();
        $this->komponenGajiModel = new KomponenGajiModel();
    }

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $search = $this->request->getGet('search');
        $data['penggajian'] = $this->penggajianModel->getPenggajianWithSearchAndTakeHomePay($search);

        return view('penggajian/index', $data);
    }

    public function create()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $data['anggota'] = $this->anggotaModel->findAll();
        return view('penggajian/create', $data);
    }

    public function store()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $id_anggota = $this->request->getPost('id_anggota');
        $id_komponen = $this->request->getPost('id_komponen');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'id_anggota' => 'required|integer',
            'id_komponen' => 'required|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Validasi jabatan
        $anggota = $this->anggotaModel->find($id_anggota);
        $komponen = $this->komponenGajiModel->find($id_komponen);
        if ($komponen['jabatan'] !== $anggota['jabatan'] && $komponen['jabatan'] !== 'Semua') {
            return redirect()->back()->with('error', 'Komponen tidak sesuai dengan jabatan anggota!');
        }

        // Cek duplikat
        $exists = $this->penggajianModel->where('id_anggota', $id_anggota)->where('id_komponen', $id_komponen)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'Komponen sudah ditambahkan untuk anggota ini!');
        }

        $this->penggajianModel->save([
            'id_anggota' => $id_anggota,
            'id_komponen' => $id_komponen
        ]);

        return redirect()->to('/penggajian')->with('success', 'Data penggajian berhasil ditambahkan!');
    }

    public function detail($id_anggota)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $data['anggota'] = $this->anggotaModel->find($id_anggota);
        $data['komponen'] = $this->penggajianModel->getKomponenByAnggota($id_anggota);
        $data['take_home_pay'] = $this->penggajianModel->calculateTakeHomePay($id_anggota);

        return view('penggajian/detail', $data);
    }

    public function edit($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $data['penggajian'] = $this->penggajianModel->find($id);
        $data['anggota'] = $this->anggotaModel->findAll();
        $data['komponen'] = $this->komponenGajiModel->findAll();

        return view('penggajian/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $id_anggota = $this->request->getPost('id_anggota');
        $id_komponen = $this->request->getPost('id_komponen');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'id_anggota' => 'required|integer',
            'id_komponen' => 'required|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Validasi jabatan
        $anggota = $this->anggotaModel->find($id_anggota);
        $komponen = $this->komponenGajiModel->find($id_komponen);
        if ($komponen['jabatan'] !== $anggota['jabatan'] && $komponen['jabatan'] !== 'Semua') {
            return redirect()->back()->with('error', 'Komponen tidak sesuai dengan jabatan anggota!');
        }

        // Cek duplikat selain dirinya sendiri
        $exists = $this->penggajianModel->where('id_anggota', $id_anggota)->where('id_komponen', $id_komponen)->where('id_penggajian !=', $id)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'Komponen sudah ditambahkan untuk anggota ini!');
        }

        $this->penggajianModel->update($id, [
            'id_anggota' => $id_anggota,
            'id_komponen' => $id_komponen
        ]);

        return redirect()->to('/penggajian')->with('success', 'Data penggajian berhasil diperbarui!');
    }

    public function delete($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $this->penggajianModel->delete($id);
        return redirect()->to('/penggajian')->with('success', 'Data penggajian berhasil dihapus!');
    }
}



class PublicController extends BaseController
{
    protected $anggotaModel;
    protected $penggajianModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
        $this->penggajianModel = new PenggajianModel();
    }

    public function anggota()
    {
        $data['anggota'] = $this->anggotaModel->findAll();
        return view('public/anggota', $data);
    }

    public function penggajian()
    {
        $data['penggajian'] = $this->penggajianModel->getPenggajianWithTakeHomePay();
        return view('public/penggajian', $data);
    }

    public function penggajianDetail($id_anggota)
    {
        $data['anggota'] = $this->anggotaModel->find($id_anggota);
        $data['komponen'] = $this->penggajianModel->getKomponenByAnggota($id_anggota);
        $data['take_home_pay'] = $this->penggajianModel->calculateTakeHomePay($id_anggota);

        return view('public/penggajian_detail', $data);
    }
}


class PenggajianModel extends Model
{
    protected $table = 'penggajian';
    protected $primaryKey = 'id_penggajian';
    protected $allowedFields = ['id_anggota', 'id_komponen'];

    public function getPenggajianWithSearchAndTakeHomePay($search = null)
    {
        $builder = $this->db->table('anggota');
        $builder->select('anggota.id_anggota, anggota.gelar_depan, anggota.nama_depan, anggota.nama_belakang, anggota.gelar_belakang, anggota.jabatan');
        if ($search) {
            $builder->groupStart();
            $builder->like('anggota.nama_depan', $search);
            $builder->orLike('anggota.nama_belakang', $search);
            $builder->orLike('anggota.jabatan', $search);
            $builder->orLike('anggota.id_anggota', $search);
            $builder->groupEnd();
        }

        $results = $builder->get()->getResultArray();
        foreach ($results as &$row) {
            $row['take_home_pay'] = $this->calculateTakeHomePay($row['id_anggota']);
        }

        return $results;
    }

    public function getPenggajianWithTakeHomePay()
    {
        $builder = $this->db->table('anggota');
        $builder->select('anggota.id_anggota, anggota.gelar_depan, anggota.nama_depan, anggota.nama_belakang, anggota.gelar_belakang, anggota.jabatan');

        $results = $builder->get()->getResultArray();
        foreach ($results as &$row) {
            $row['take_home_pay'] = $this->calculateTakeHomePay($row['id_anggota']);
        }

        return $results;
    }

    public function getKomponenByAnggota($id_anggota)
    {
        $builder = $this->db->table($this->table);
        $builder->select('komponen_gaji.*');
        $builder->join('komponen_gaji', 'komponen_gaji.id_komponen = penggajian.id_komponen');
        $builder->where('penggajian.id_anggota', $id_anggota);
        return $builder->get()->getResultArray();
    }

    public function calculateTakeHomePay($id_anggota)
    {
        $builder = $this->db->table($this->table);
        $builder->select('SUM(komponen_gaji.nominal) as total');
        $builder->join('komponen_gaji', 'komponen_gaji.id_komponen = penggajian.id_komponen');
        $builder->join('anggota', 'anggota.id_anggota = penggajian.id_anggota');
        $builder->where('penggajian.id_anggota', $id_anggota);
        $builder->where('komponen_gaji.satuan', 'Bulan');
        $total = $builder->get()->getRow()->total ?? 0;

        // Tambah tunjangan istri/suami jika kawin
        $anggota = $this->db->table('anggota')->where('id_anggota', $id_anggota)->get()->getRowArray();
        if ($anggota['status_pernikahan'] === 'Kawin') {
            $tunjangan_istri = $this->db->table('komponen_gaji')
                ->where('nama_komponen', 'Tunjangan Istri/Suami')
                ->get()->getRow()->nominal ?? 0;
            $total += $tunjangan_istri;
        }

        // Tambah tunjangan anak, max 2
        $jumlah_anak = min($anggota['jumlah_anak'], 2);
        if ($jumlah_anak > 0) {
            $tunjangan_anak = $this->db->table('komponen_gaji')
                ->where('nama_komponen', 'Tunjangan Anak')
                ->get()->getRow()->nominal ?? 0;
            $total += $tunjangan_anak * $jumlah_anak;
        }

        return $total;
    }
}