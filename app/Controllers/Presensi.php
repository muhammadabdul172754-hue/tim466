<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PresensiModel;

class Presensi extends BaseController
{
    protected $presensiModel;

    public function __construct()
    {
        $this->presensiModel = new PresensiModel();
    }

        public function index()
    {
        $userId = session()->get('id'); 
        $presensiModel = $this->presensiModel;

        // Ambil data hari ini
        $presensiHariIni = $presensiModel->getPresensiHariIni($userId);

        // Hitung statistik bulan ini
        $bulanIni = date('m');
        $tahunIni = date('Y');
        
        $stats = [
            'hadir' => $presensiModel->where('user_id', $userId)->where('MONTH(tanggal)', $bulanIni)->where('YEAR(tanggal)', $tahunIni)->where('status', 'Hadir')->countAllResults(),
            'terlambat' => $presensiModel->where('user_id', $userId)->where('MONTH(tanggal)', $bulanIni)->where('YEAR(tanggal)', $tahunIni)->where('status', 'Terlambat')->countAllResults(),
            'izin' => $presensiModel->where('user_id', $userId)->where('MONTH(tanggal)', $bulanIni)->where('YEAR(tanggal)', $tahunIni)->where('status', 'Izin')->countAllResults(),
            'sakit' => $presensiModel->where('user_id', $userId)->where('MONTH(tanggal)', $bulanIni)->where('YEAR(tanggal)', $tahunIni)->where('status', 'Sakit')->countAllResults(),
        ];
        $stats['total'] = array_sum($stats);

        // Ambil riwayat presensi bulan ini
        $riwayat = $presensiModel->where('user_id', $userId)
                                 ->where('MONTH(tanggal)', $bulanIni)
                                 ->where('YEAR(tanggal)', $tahunIni)
                                 ->orderBy('tanggal', 'DESC')
                                 ->findAll();

        $data = [
            'title'    => 'Presensi',
            'presensi' => $presensiHariIni,
            'stats'    => $stats,
            'riwayat'  => $riwayat
        ];

        return view('presensi/index', $data);
    }

    public function submit()
    {
        $userId = session()->get('id'); 
        $mode = $this->request->getPost('mode') ?? 'WFO';
        $today = date('Y-m-d');
        $nowTime = date('H:i:s');
        $aksi = $this->request->getPost('aksi'); // 'masuk', 'pulang', 'izin'

        $presensi = $this->presensiModel->getPresensiHariIni($userId);

        // Jika user mengajukan Izin/Sakit
        if ($aksi == 'izin' && !$presensi) {
            $this->presensiModel->save([
                'user_id'   => $userId,
                'tanggal'   => $today,
                'status'    => $this->request->getPost('status_izin'), // Izin atau Sakit
                'alasan'    => $this->request->getPost('alasan'),
            ]);
            return redirect()->to('/presensi')->with('success', 'Pengajuan ' . $this->request->getPost('status_izin') . ' berhasil dicatat.');
        }

        // Jika Absen Masuk
        if (!$presensi) {
            $jamBatas = '08:00:00'; 
            $status = ($nowTime > $jamBatas) ? 'Terlambat' : 'Hadir';

            $this->presensiModel->save([
                'user_id'   => $userId,
                'tanggal'   => $today,
                'jam_masuk' => $nowTime,
                'mode'      => $mode,
                'status'    => $status
            ]);
            return redirect()->to('/presensi')->with('success', 'Berhasil Absen Masuk!');
        } 
        // Jika Absen Pulang
        else if (!$presensi['jam_pulang'] && $presensi['status'] != 'Izin' && $presensi['status'] != 'Sakit') {
            $this->presensiModel->update($presensi['id'], [
                'jam_pulang' => $nowTime
            ]);
            return redirect()->to('/presensi')->with('success', 'Berhasil Absen Pulang!');
        }

        return redirect()->to('/presensi')->with('error', 'Presensi hari ini sudah selesai.');
    }

        // Halaman Form Pengajuan Izin/Sakit
    public function izin()
    {
        return view('presensi/izin', ['title' => 'Ajukan Izin / Sakit']);
    }

    // Proses simpan pengajuan izin
    public function submitIzin()
    {
        $userId = session()->get('id');
        $today = date('Y-m-d');

        // Cek apakah hari ini sudah ada data presensi
        $presensiHariIni = $this->presensiModel->getPresensiHariIni($userId);
        if ($presensiHariIni) {
            return redirect()->to('/presensi')->with('error', 'Anda sudah melakukan presensi hari ini.');
        }

        $this->presensiModel->save([
            'user_id' => $userId,
            'tanggal' => $today,
            'status'  => $this->request->getPost('status_izin'),
            'alasan'  => $this->request->getPost('alasan'),
        ]);

        return redirect()->to('/presensi')->with('success', 'Pengajuan berhasil dicatat.');
    }

    // Halaman Rekap Khusus Admin
    public function rekap()
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $data = [
            'title'   => 'Rekap Presensi',
            'presensi'=> $this->presensiModel->getRekapBulanan($bulan, $tahun),
            'bulan'   => $bulan,
            'tahun'   => $tahun
        ];
        return view('presensi/rekap', $data);
    }

        public function print()
    {
        if (session()->get('role') != 'admin' && session()->get('role') != 'petugas') {
            return redirect()->to('/dashboard');
        }

        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $data = [
            'presensi' => $this->presensiModel->getRekapBulanan($bulan, $tahun),
            'bulan'    => $bulan,
            'tahun'    => $tahun
        ];

        return view('presensi/print', $data);
    }
}