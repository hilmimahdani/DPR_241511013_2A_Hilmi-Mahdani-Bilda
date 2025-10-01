<?php

namespace App\Controllers;
namespace App\Models;
use App\Models\AnggotaModel;
use CodeIgniter\Model;



class AnggotaController extends BaseController
{
    protected $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
    }

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $search = $this->request->getGet('search');
        $data['anggota'] = $this->anggotaModel->getAnggotaWithSearch($search);

        return view('anggota/index', $data);
    }

    public function create()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }
        return view('anggota/create');
    }

    public function store()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'jabatan' => 'required|in_list[Ketua,Wakil Ketua,Anggota]',
            'status_pernikahan' => 'required|in_list[Kawin,Belum Kawin]',
            'jumlah_anak' => 'required|integer|greater_than_equal_to[0]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->anggotaModel->save([
            'gelar_depan' => $this->request->getPost('gelar_depan'),
            'nama_depan' => $this->request->getPost('nama_depan'),
            'nama_belakang' => $this->request->getPost('nama_belakang'),
            'gelar_belakang' => $this->request->getPost('gelar_belakang'),
            'jabatan' => $this->request->getPost('jabatan'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'jumlah_anak' => $this->request->getPost('jumlah_anak')
        ]);

        return redirect()->to('/anggota')->with('success', 'Data anggota berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $data['anggota'] = $this->anggotaModel->find($id);
        if (!$data['anggota']) {
            return redirect()->to('/anggota')->with('error', 'Data tidak ditemukan!');
        }
        return view('anggota/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'jabatan' => 'required|in_list[Ketua,Wakil Ketua,Anggota]',
            'status_pernikahan' => 'required|in_list[Kawin,Belum Kawin]',
            'jumlah_anak' => 'required|integer|greater_than_equal_to[0]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->anggotaModel->update($id, [
            'gelar_depan' => $this->request->getPost('gelar_depan'),
            'nama_depan' => $this->request->getPost('nama_depan'),
            'nama_belakang' => $this->request->getPost('nama_belakang'),
            'gelar_belakang' => $this->request->getPost('gelar_belakang'),
            'jabatan' => $this->request->getPost('jabatan'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'jumlah_anak' => $this->request->getPost('jumlah_anak')
        ]);

        return redirect()->to('/anggota')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function delete($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $this->anggotaModel->delete($id);
        return redirect()->to('/anggota')->with('success', 'Data anggota berhasil dihapus!');
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



class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    protected $allowedFields = ['gelar_depan', 'nama_depan', 'nama_belakang', 'gelar_belakang', 'jabatan', 'status_pernikahan', 'jumlah_anak'];

    public function getAnggotaWithSearch($search = null)
    {
        $builder = $this->db->table($this->table);
        if ($search) {
            $builder->like('nama_depan', $search);
            $builder->orLike('nama_belakang', $search);
            $builder->orLike('jabatan', $search);
            $builder->orLike('id_anggota', $search);
        }
        return $builder->get()->getResultArray();
    }
}