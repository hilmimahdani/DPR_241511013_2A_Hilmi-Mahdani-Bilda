<?php

namespace App\Controllers;

namespace App\Models;
use CodeIgniter\Model;

use App\Models\PenggunaModel;


class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $session = session();
        $model = new PenggunaModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $session->set([
                    'id_pengguna' => $user['id_pengguna'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'logged_in' => true
                ]);
                return redirect()->to(base_url('home'));
            } else {
                $session->setFlashdata('error', 'Password salah!');
                return redirect()->to(base_url('login'));
            }
        } else {
            $session->setFlashdata('error', 'User tidak ditemukan!');
            return redirect()->to(base_url('login'));
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function doRegister()
    {
        $model = new PenggunaModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_depan' => $this->request->getPost('nama_depan'),
            'nama_belakang' => $this->request->getPost('nama_belakang'),
            'role' => $this->request->getPost('role') ?? 'Public'
        ];

        $model->save($data);
        return redirect()->to(base_url('login'))->with('success', 'Register berhasil, silakan login!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}

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

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $session = session();
        $model = new PenggunaModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $session->set([
                    'id_pengguna' => $user['id_pengguna'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'logged_in' => true
                ]);
                return redirect()->to(base_url('home'));
            } else {
                $session->setFlashdata('error', 'Password salah!');
                return redirect()->to(base_url('login'));
            }
        } else {
            $session->setFlashdata('error', 'User tidak ditemukan!');
            return redirect()->to(base_url('login'));
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function doRegister()
    {
        $model = new PenggunaModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_depan' => $this->request->getPost('nama_depan'),
            'nama_belakang' => $this->request->getPost('nama_belakang'),
            'role' => $this->request->getPost('role') ?? 'Public'
        ];

        $model->save($data);
        return redirect()->to(base_url('login'))->with('success', 'Register berhasil, silakan login!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}



class PenggunaModel extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    protected $allowedFields = ['username', 'password', 'email', 'nama_depan', 'nama_belakang', 'role'];
}