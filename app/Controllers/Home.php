<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JurnalModel;
use App\Models\TaskModel;
use App\Models\PresensiModel;
use App\Models\UsersModel;

class Home extends BaseController
{
    // 1. Halaman Utama (Landing Page - Tanpa Login)
    public function index()
    {
        return view('landing', ['title' => 'Tim466App - Landing Page']);
    }

    // 2. Halaman Dashboard (Setelah Login - Wajib Login)
    public function dashboard()
    {
        $role   = session()->get('role');
        $userId = session()->get('id');
        $nama   = session()->get('nama');

        $data = [
            'title' => 'Dashboard',
            'role'  => $role,
            'nama'  => $nama
        ];

        // ==========================================
        // JIKA YANG LOGIN ADALAH ADMIN / PETUGAS
        // ==========================================
        if ($role == 'admin' || $role == 'petugas') {
            $jurnalModel   = new JurnalModel();
            $presensiModel = new PresensiModel();
            $usersModel    = new UsersModel();
            $taskModel     = new TaskModel();

            $data['total_anggota'] = $usersModel->where('role', 'anggota')->countAllResults();

            $data['jurnal_review']    = $jurnalModel->where('status', 'Menunggu Review')->countAllResults();
            $data['jurnal_disetujui'] = $jurnalModel->where('status', 'Disetujui')->countAllResults();
            $data['jurnal_revisi']    = $jurnalModel->where('status', 'Perlu Revisi')->countAllResults();

            $tanggalHariIni = date('Y-m-d');
            
            $data['hadir_hari_ini']      = $presensiModel->where('tanggal', $tanggalHariIni)->where('status', 'Hadir')->countAllResults();
            $data['terlambat_hari_ini']  = $presensiModel->where('tanggal', $tanggalHariIni)->where('status', 'Terlambat')->countAllResults();
            $data['izin_sakit_hari_ini'] = $presensiModel->where('tanggal', $tanggalHariIni)->whereIn('status', ['Izin', 'Sakit'])->countAllResults();
            
            $sudahAbsen = $data['hadir_hari_ini'] + $data['terlambat_hari_ini'] + $data['izin_sakit_hari_ini'];
            $data['belum_absen'] = max(0, $data['total_anggota'] - $sudahAbsen);

            $data['total_tugas']    = $taskModel->countAllResults();
            $data['tugas_selesai'] = $taskModel->where('status', 'done')->countAllResults();

            return view('dashboard/admin', $data);
        } 
        
        // ==========================================
        // JIKA YANG LOGIN ADALAH ANGGOTA
        // ==========================================
        else {
            $taskModel     = new TaskModel();
            $presensiModel = new PresensiModel();
            $jurnalModel   = new JurnalModel();

            // Ambil data tugas
            $data['total_tugas']   = $taskModel->where('user_id', $userId)->countAllResults() ?? 0;
            $data['tugas_selesai'] = $taskModel->where('user_id', $userId)->where('status', 'done')->countAllResults() ?? 0;
            
            // Ambil data presensi hari ini
            $data['presensi_hari_ini'] = $presensiModel->where('user_id', $userId)->where('tanggal', date('Y-m-d'))->first();
            
            // Ambil data jurnal
            $data['jurnal_disetujui'] = $jurnalModel->where('user_id', $userId)->where('status', 'Disetujui')->countAllResults() ?? 0;
            $data['total_jurnal']     = $jurnalModel->where('user_id', $userId)->countAllResults() ?? 0;

            return view('dashboard/anggota', $data);
        }
    }
}