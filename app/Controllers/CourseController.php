<?php
namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class CourseController extends BaseController
{
    public function index()
    {
        $model = new CourseModel();
        $data['courses'] = $model->findAll();

        return view('courses/index', $data);
    }

    public function detail($id)
    {
        $model = new CourseModel();
        $data['course'] = $model->find($id);

        return view('courses/detail', $data);
    }

    public function enroll($course_id)
    {
        $session = session();
        $id_pengguna = $session->get('id_pengguna');

        if (!$id_pengguna) {
            return redirect()->to('/login');
        }

        $enrollModel = new EnrollmentModel();
        $exists = $enrollModel->where('id_pengguna', $id_pengguna)->where('course_id', $course_id)->first();

        if (!$exists) {
            $enrollModel->save([
                'id_pengguna' => $id_pengguna,
                'course_id' => $course_id
            ]);
            return redirect()->to('/courses')->with('success', 'Berhasil enroll course!');
        } else {
            return redirect()->to('/courses')->with('error', 'Sudah terdaftar di course ini!');
        }
    }

    public function myCourses()
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'anggota') {
            return redirect()->to('/login');
        }

        $userId = session()->get('id_pengguna');

        $db = \Config\Database::connect();
        $builder = $db->table('takes'); // kalau sudah rename ke takes, ganti di sini
        $builder->select('courses.id, courses.name, courses.description');
        $builder->join('courses', 'courses.id = takes.course_id');
        $builder->where('takes.id_anggota', $penggunaId);

        $query = $builder->get();
        $data['courses'] = $query->getResultArray();

        return view('courses/mycourses', $data);
    }


    //CRUD Course - Admin Only

        public function create()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/home');
        }
        return view('courses/create');
    }

    public function store()
    {
        $model = new CourseModel();
        $model->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/courses')->with('success', 'Course berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/home');
        }

        $model = new CourseModel();
        $data['course'] = $model->find($id);

        return view('courses/edit', $data);
    }

    public function update($id)
    {
        $model = new CourseModel();
        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/courses')->with('success', 'Course berhasil diperbarui!');
    }

    public function delete($id)
    {
        $model = new CourseModel();
        $model->delete($id);

        return redirect()->to('/courses')->with('success', 'Course berhasil dihapus!');
    }


}
