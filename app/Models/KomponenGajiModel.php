<?php

namespace App\Controllers;

use App\Models\KomponenGajiModel;


namespace App\Models;
use CodeIgniter\Model;


class KomponenGajiController extends BaseController
{
    protected $komponenGajiModel;

    public function __construct()
    {
        $this->komponenGajiModel = new KomponenGajiModel();
    }

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $search = $this->request->getGet('search');
        $data['komponen'] = $this->komponenGajiModel->getKomponenWithSearch($search);

        return view('komponen_gaji/index', $data);
    }

    public function create()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }
        return view('komponen_gaji/create');
    }

    public function store()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_komponen' => 'required',
            'kategori' => 'required',
            'jabatan' => 'required|in_list[Ketua,Wakil Ketua,Anggota,Semua]',
            'nominal' => 'required|decimal',
            'satuan' => 'required|in_list[Bulan,Periode]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->komponenGajiModel->save([
            'nama_komponen' => $this->request->getPost('nama_komponen'),
            'kategori' => $this->request->getPost('kategori'),
            'jabatan' => $this->request->getPost('jabatan'),
            'nominal' => $this->request->getPost('nominal'),
            'satuan' => $this->request->getPost('satuan')
        ]);

        return redirect()->to('/komponen_gaji')->with('success', 'Komponen gaji berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $data['komponen'] = $this->komponenGajiModel->find($id);
        if (!$data['komponen']) {
            return redirect()->to('/komponen_gaji')->with('error', 'Data tidak ditemukan!');
        }
        return view('komponen_gaji/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_komponen' => 'required',
            'kategori' => 'required',
            'jabatan' => 'required|in_list[Ketua,Wakil Ketua,Anggota,Semua]',
            'nominal' => 'required|decimal',
            'satuan' => 'required|in_list[Bulan,Periode]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->komponenGajiModel->update($id, [
            'nama_komponen' => $this->request->getPost('nama_komponen'),
            'kategori' => $this->request->getPost('kategori'),
            'jabatan' => $this->request->getPost('jabatan'),
            'nominal' => $this->request->getPost('nominal'),
            'satuan' => $this->request->getPost('satuan')
        ]);

        return redirect()->to('/komponen_gaji')->with('success', 'Komponen gaji berhasil diperbarui!');
    }

    public function delete($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $this->komponenGajiModel->delete($id);
        return redirect()->to('/komponen_gaji')->with('success', 'Komponen gaji berhasil dihapus!');
    }
}

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


class KomponenGajiModel extends Model
{
    protected $table = 'komponen_gaji';
    protected $primaryKey = 'id_komponen';
    protected $allowedFields = ['nama_komponen', 'kategori', 'jabatan', 'nominal', 'satuan'];

    public function getKomponenWithSearch($search = null)
    {
        $builder = $this->db->table($this->table);
        if ($search) {
            $builder->like('nama_komponen', $search);
            $builder->orLike('kategori', $search);
            $builder->orLike('jabatan', $search);
            $builder->orLike('nominal', $search);
            $builder->orLike('satuan', $search);
            $builder->orLike('id_komponen', $search);
        }
        return $builder->get()->getResultArray();
    }
}