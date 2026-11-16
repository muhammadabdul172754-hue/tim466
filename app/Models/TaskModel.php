<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table            = 'tasks';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'judul', 'deskripsi', 'deadline', 'kategori', 'status'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = ''; 

    // Fungsi untuk mengambil tugas (Bisa untuk Admin atau Anggota)
    public function getTasks($user_id, $role)
    {
        if ($role == 'admin') {
            // Admin melihat SEMUA tugas dari siapapun (di-join dengan tabel users biar tahu siapa pembuatnya)
            return $this->select('tasks.*, users.nama as pembuat')
                        ->join('users', 'users.id = tasks.user_id', 'left')
                        ->orderBy('tasks.created_at', 'DESC')
                        ->findAll();
        } else {
            // Anggota/Petugas hanya melihat tugas yang MEREKA buat sendiri
            return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->findAll();
        }
    }
}