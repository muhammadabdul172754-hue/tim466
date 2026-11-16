<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TaskModel;

class Task extends BaseController
{
    protected $taskModel;

    public function __construct()
    {
        $this->taskModel = new TaskModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('id');

        $data = [
            'title' => 'Daftar Tugas',
            'tasks' => $this->taskModel->getTasks($userId, $role),
            'role'  => $role
        ];

        return view('task/index', $data);
    }

    public function create()
    {
        return view('task/create', ['title' => 'Tambah Tugas']);
    }

    public function store()
    {
        $this->taskModel->save([
            'user_id'   => session()->get('id'),
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'deadline'  => $this->request->getPost('deadline'),
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => 'todo'
        ]);

        return redirect()->to('/task')->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function detail($id)
    {
        $task = $this->taskModel->find($id);
        if (!$task) return redirect()->to('/task');

        return view('task/detail', [
            'title' => 'Detail Tugas',
            'task'  => $task
        ]);
    }

    public function edit($id)
    {
        $task = $this->taskModel->find($id);
        if (!$task) return redirect()->to('/task');

        return view('task/edit', [
            'title' => 'Edit Tugas',
            'task'  => $task
        ]);
    }

    // HANYA ADA SATU FUNGSI UPDATE DI SINI
    public function update($id)
    {
        $this->taskModel->update($id, [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'deadline'  => $this->request->getPost('deadline'),
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => $this->request->getPost('status')
        ]);

        return redirect()->to('/task/detail/'.$id)->with('success', 'Tugas berhasil diperbarui!');
    }

    public function toggle_status($id)
    {
        $task = $this->taskModel->find($id);
        if ($task) {
            $newStatus = ($task['status'] == 'done') ? 'todo' : 'done';
            $this->taskModel->update($id, ['status' => $newStatus]);
        }
        return redirect()->to('/task');
    }

    public function delete($id)
    {
        $this->taskModel->delete($id);
        return redirect()->to('/task')->with('success', 'Tugas dihapus!');
    }

    public function print()
    {
        $role = session()->get('role');
        $userId = session()->get('id');

        $data = [
            'title' => 'Print Daftar Tugas',
            'tasks' => $this->taskModel->getTasks($userId, $role)
        ];
        return view('task/print', $data);
    }
}