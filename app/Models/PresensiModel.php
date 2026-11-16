<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table            = 'presensi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'tanggal', 'jam_masuk', 'jam_pulang', 'mode', 'status', 'alasan'];
    protected $useTimestamps    = false;

    // Ambil data presensi user hari ini
    public function getPresensiHariIni($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('tanggal', date('Y-m-d'))
                    ->first();
    }

    // Ambil rekap presensi seluruh anggota untuk Admin berdasarkan bulan & tahun
        public function getRekapBulanan($bulan, $tahun)
    {
        $builder = $this->db->table('users');
        $builder->select('users.id as user_id, users.nama, users.role, 
                          presensi.tanggal, presensi.jam_masuk, presensi.jam_pulang, 
                          presensi.status, presensi.alasan');
        
        // Join tabel presensi (filter berdasarkan bulan & tahun)
        $builder->join('presensi', "presensi.user_id = users.id AND MONTH(presensi.tanggal) = '$bulan' AND YEAR(presensi.tanggal) = '$tahun'", 'left');
        
        // HAPUS ATAU KOMENTARI BARIS INI:
        // $builder->where('users.role', 'anggota'); 
        
        $builder->orderBy('presensi.tanggal', 'DESC');
        
        return $builder->get()->getResultArray();
    }
}