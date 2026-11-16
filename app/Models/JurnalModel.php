<?php

namespace App\Models;

use CodeIgniter\Model;

class JurnalModel extends Model
{
    protected $table            = 'jurnal_pkl';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'judul_kegiatan', 'deskripsi', 'foto', 'status', 'catatan_admin'];
    protected $useTimestamps    = false;

    // Mengambil jurnal (Bisa untuk Anggota atau Admin)
    public function getJurnal($userId, $role, $search = null, $status = null)
    {
        $builder = $this->select('jurnal_pkl.*, users.nama as nama_anggota, users.foto as foto_profil')
                        ->join('users', 'users.id = jurnal_pkl.user_id', 'left');

        // Jika bukan admin, hanya tampilkan jurnal miliknya sendiri
        if ($role != 'admin' && $role != 'petugas') {
            $builder->where('jurnal_pkl.user_id', $userId);
        }

        if ($search) {
            $builder->like('jurnal_pkl.judul_kegiatan', $search);
        }

        if ($status) {
            $builder->where('jurnal_pkl.status', $status);
        }

        return $builder->orderBy('jurnal_pkl.tanggal', 'DESC')->findAll();
    }
}