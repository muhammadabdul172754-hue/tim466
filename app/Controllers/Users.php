<?php

// Namespace controller (menentukan lokasi file dalam struktur CI4)
namespace App\Controllers;

// Menggunakan model UsersModel untuk interaksi database
use App\Models\UsersModel;

// Class Users mewarisi BaseController (class utama di CI4)
class Users extends BaseController
{
    // Properti untuk menampung instance model
    protected $users;

    // Constructor: dijalankan saat controller dipanggil
    public function __construct()
    {
        // Inisialisasi model UsersModel
        $this->users = new UsersModel();
    }

    // Menampilkan halaman form tambah user
    public function create()
    {
        // Memanggil view users/create.php
        return view('users/index');
    }

    // Menyimpan data user baru
    public function store()
    {
        // ================= VALIDASI =================
        // Mengambil service validation dari CodeIgniter
        $validation = \Config\Services::validation();

        // Menentukan aturan validasi
        $validation->setRules([
            'nama'     => 'required', // wajib diisi
            'email'    => 'required|valid_email', // wajib & format email valid
            'username' => 'required|is_unique[users.username]', // unik di tabel users
            'password' => 'required|min_length[4]', // minimal 4 karakter
            'role'     => 'required', // wajib diisi
        ]);

        // Jika validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            // Kembali ke halaman sebelumnya + tampilkan error
            return redirect()->back()->with('error', implode('<br>', $validation->getErrors()));
        }

        // ================= UPLOAD FOTO =================
        // Mengambil file dari input name="foto"
        $foto = $this->request->getFile('foto');

        // Default nama foto null
        $namaFoto = null;

        // Jika ada file & valid & belum dipindahkan
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Generate nama random untuk menghindari konflik nama file
            $namaFoto = $foto->getRandomName();

            // Pindahkan file ke folder public/uploads/users
            $foto->move(FCPATH . 'uploads/users', $namaFoto);
        }

        // ================= SIMPAN DATA =================
        $this->users->save([
            'nama'     => $this->request->getPost('nama'), // ambil dari form
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            // Password di-hash untuk keamanan
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
            'foto'     => $namaFoto // simpan nama file foto
        ]);

        // Redirect ke halaman login + pesan sukses
        return redirect()->to('/login')->with('success', 'User berhasil ditambahkan!');
    }

    // Menampilkan daftar user (dengan filter & pagination)
    public function index()
    {
        // Ambil parameter GET (search & filter)
        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');

        // Builder awal dari model
        $builder = $this->users;

        // Jika ada keyword → filter berdasarkan nama
        if ($keyword) {
            $builder = $builder->like('nama', $keyword);
        }

        // Jika ada filter role
        if ($role) {
            $builder = $builder->where('role', $role);
        }

        // Ambil data dengan pagination (10 data per halaman)
        $data['users'] = $builder->paginate(10);

        // Pager untuk navigasi halaman
        $data['pager'] = $this->users->pager;

        // Kirim data ke view
        return view('users/index', $data);
    }

    // Menampilkan form edit user
    public function edit($id)
    {
        // Ambil data user berdasarkan id
        $data['user'] = $this->users->find($id);

        // Tampilkan view edit
        return view('users/edit', $data);
    }

    // Update data user
            public function update($id)
    {
        $usersModel = new \App\Models\UsersModel();
        
        $userLama = $usersModel->find($id);
        if (!$userLama) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        // Siapkan data dasar yang akan diupdate
        $dataUpdate = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
        ];

        // Cek apakah admin mengubah role
        $roleInput = $this->request->getPost('role');
        if ($roleInput) {
            $dataUpdate['role'] = $roleInput;
        }

        // --- LOGIKA GANTI PASSWORD ---
        $passLama = $this->request->getPost('password_lama');
        $passBaru = $this->request->getPost('password_baru');
        $konfirmasi = $this->request->getPost('konfirmasi_password');

        // Jika user mengisi form password
        if (!empty($passLama) || !empty($passBaru) || !empty($konfirmasi)) {
            
            // 1. Cek apakah password lama cocok dengan yang ada di database
            if (!password_verify($passLama, $userLama['password'])) {
                return redirect()->back()->withInput()->with('error', 'Password lama Anda salah!');
            }

            // 2. Cek apakah password baru dan konfirmasi sama
            if ($passBaru !== $konfirmasi) {
                return redirect()->back()->withInput()->with('error', 'Konfirmasi password baru tidak cocok!');
            }

            // 3. Cek panjang password baru (opsional)
            if (strlen($passBaru) < 6) {
                return redirect()->back()->withInput()->with('error', 'Password baru minimal 6 karakter!');
            }

            // 4. Jika semua validasi lolos, hash password baru
            $dataUpdate['password'] = password_hash($passBaru, PASSWORD_DEFAULT);
        }
        // Jika form password kosong semua, password tidak akan diubah.

        // --- LOGIKA UPLOAD FOTO ---
        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            if ($userLama['foto'] && file_exists(FCPATH . 'uploads/users/' . $userLama['foto'])) {
                unlink(FCPATH . 'uploads/users/' . $userLama['foto']);
            }
            $namaFotoBaru = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/users', $namaFotoBaru);
            $dataUpdate['foto'] = $namaFotoBaru;
        }

        // Simpan ke database
        $usersModel->update($id, $dataUpdate);

        // Update session (jika yang diedit adalah diri sendiri)
        if ($id == session()->get('id')) {
            session()->set([
                'nama' => $dataUpdate['nama'],
                'foto' => $dataUpdate['foto'] ?? $userLama['foto']
            ]);
        }

        return redirect()->to('/users/edit/' . $id)->with('success', 'Profil dan Password berhasil diperbarui!');
    }

    // Menghapus user
    public function delete($id)
    {
        // Ambil data user
        $user = $this->users->find($id);

        // Hapus foto jika ada
        if ($user['foto'] && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
            unlink(FCPATH . 'uploads/users/' . $user['foto']);
        }

        // Hapus data user di database
        $this->users->delete($id);

        // Redirect dengan pesan sukses
        return redirect()->to('/users')->with('success', 'User berhasil dihapus!');
    }

    // ================= DETAIL USER =================
    public function detail($id)
    {
        // Ambil data user
        $user = $this->users->find($id);

        // Jika tidak ditemukan
        if (!$user) {
            return redirect()->to('/users')->with('error', 'Data tidak ditemukan');
        }

        // Tampilkan detail
        return view('users/detail', ['user' => $user]);
    }

    // ================= PRINT DATA =================
    public function print()
    {
        // Ambil filter
        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');

        // Builder query
        $builder = $this->users;

        // Filter keyword
        if ($keyword) {
            $builder = $builder->like('nama', $keyword);
        }

        // Filter role
        if ($role) {
            $builder = $builder->where('role', $role);
        }

        // Ambil semua data (tanpa pagination)
        $data['users'] = $builder->findAll();

        // Tampilkan view print
        return view('users/print', $data);
    }

    // ================= KIRIM WHATSAPP =================
    public function wa($id)
    {
        // Ambil data user
        $user = $this->users->find($id);

        // Jika tidak ada
        if (!$user) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // ================= FORMAT PESAN =================
        $pesan = "DATA USER\n\n";
        $pesan .= "ID: " . $user['id'] . "\n";
        $pesan .= "Nama: " . $user['nama'] . "\n";
        $pesan .= "Email: " . $user['email'] . "\n";
        $pesan .= "Username: " . $user['username'] . "\n";
        $pesan .= "Role: " . ucfirst($user['role']) . "\n";

        // Encode agar aman di URL
        $url = "https://wa.me/6285175017991?text=" . urlencode($pesan);

        // Redirect ke WhatsApp
        return redirect()->to($url);
    }

    public function serveImage($filename)
{
    // Lokasi folder uploads di root aplikasi
    $path = ROOTPATH . 'uploads/users/' . $filename;
    
    if (file_exists($path)) {
        // Tampilkan file gambar
        return $this->response->download($path, null)->setFileName($filename);
    } else {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
}
}