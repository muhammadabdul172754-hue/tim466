<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JurnalModel;

class Jurnal extends BaseController
{
    protected $jurnalModel;

    public function __construct()
    {
        $this->jurnalModel = new JurnalModel();
    }

    // 1. Halaman Utama
    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('id');
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $data = [
            'title'  => 'Jurnal Aktivitas',
            'jurnal' => $this->jurnalModel->getJurnal($userId, $role, $search, $status),
            'role'   => $role,
            'search' => $search,
            'status' => $status
        ];

        return view('jurnal/index', $data);
    }

    // 2. Form Tambah Jurnal
    public function create()
    {
        return view('jurnal/create', ['title' => 'Tulis Jurnal']);
    }

    // 3. Proses Simpan Jurnal
    public function store()
    {
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/jurnal', $namaFoto);
        }

        $this->jurnalModel->save([
            'user_id'        => session()->get('id'),
            'tanggal'        => $this->request->getPost('tanggal'),
            'waktu_mulai'    => $this->request->getPost('waktu_mulai'),
            'waktu_selesai'  => $this->request->getPost('waktu_selesai'),
            'judul_kegiatan' => $this->request->getPost('judul_kegiatan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'foto'           => $namaFoto,
            'status'         => 'Menunggu Review' 
        ]);

        return redirect()->to('/jurnal')->with('success', 'Jurnal berhasil dikirim ke Admin untuk direview.');
    }

    // 4. Halaman Detail Jurnal
    public function show($id) // Saya ubah namanya jadi 'show' agar sesuai standar routes
    {
        $jurnal = $this->jurnalModel->find($id);
        if (!$jurnal) return redirect()->to('/jurnal');

        return view('jurnal/detail', ['title' => 'Detail Jurnal', 'jurnal' => $jurnal]);
    }

    // 5. Form Edit Jurnal
    public function edit($id)
    {
        $jurnal = $this->jurnalModel->find($id);
        if (!$jurnal) return redirect()->to('/jurnal');

        if ($jurnal['user_id'] != session()->get('id') || $jurnal['status'] == 'Disetujui') {
            return redirect()->to('/jurnal')->with('error', 'Akses ditolak atau jurnal sudah disetujui.');
        }

        return view('jurnal/edit', ['title' => 'Edit Jurnal', 'jurnal' => $jurnal]);
    }

    // 6. Proses Update Jurnal
    public function update($id)
    {
        $jurnal = $this->jurnalModel->find($id);
        if (!$jurnal || $jurnal['user_id'] != session()->get('id') || $jurnal['status'] == 'Disetujui') {
            return redirect()->to('/jurnal')->with('error', 'Akses ditolak.');
        }

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $jurnal['foto']; 

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            if ($namaFoto && file_exists(FCPATH . 'uploads/jurnal/' . $namaFoto)) {
                unlink(FCPATH . 'uploads/jurnal/' . $namaFoto);
            }
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/jurnal', $namaFoto);
        }

        $this->jurnalModel->update($id, [
            'tanggal'        => $this->request->getPost('tanggal'),
            'waktu_mulai'    => $this->request->getPost('waktu_mulai'),
            'waktu_selesai'  => $this->request->getPost('waktu_selesai'),
            'judul_kegiatan' => $this->request->getPost('judul_kegiatan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'foto'           => $namaFoto,
            'status'         => 'Menunggu Review' 
        ]);

        return redirect()->to('/jurnal')->with('success', 'Jurnal berhasil diperbarui.');
    }

    // 7. Halaman Khusus Admin (Tabel Verifikasi)
    public function verifikasiIndex()
    {
        if (session()->get('role') != 'admin') return redirect()->to('/jurnal');

        $data = [
            'title'  => 'Verifikasi Jurnal',
            'jurnal' => $this->jurnalModel->getJurnal(null, 'admin') 
        ];

        return view('jurnal/verifikasi', $data);
    }

    // 8. Proses Simpan Verifikasi Admin
    public function verifikasiProses($id)
    {
        if (session()->get('role') != 'admin') return redirect()->to('/jurnal');

        $this->jurnalModel->update($id, [
            'status'        => $this->request->getPost('status'),
            'catatan_admin' => $this->request->getPost('catatan_admin')
        ]);

        return redirect()->to('/jurnal')->with('success', 'Jurnal berhasil diverifikasi!');
    }
}