<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman Depan (Publik)
$routes->get('/', 'Home::index');

// Halaman Dashboard (Wajib Login)
$routes->get('/dashboard', 'Home::dashboard', ['filter' => 'auth']);

// --- RUTE AUTENTIKASI ---
$routes->get('/login', 'Auth::login');
$routes->post('/login/process', 'Auth::process');
$routes->get('/logout', 'Auth::logout');
$routes->get('/register', 'Auth::register');
$routes->post('/register/process', 'Auth::store_register');

// --- RUTE BIODATA TIM ---
$routes->get('/tim/abdul', 'Biodata::abdul');
$routes->get('/tim/wildan', 'Biodata::wildan');
$routes->get('/tim/gumelar', 'Biodata::gumelar');
$routes->get('/tim/arya', 'Biodata::arya');
$routes->get('/tim/nandra', 'Biodata::nandra');

// ==========================================
// RUTE YANG WAJIB LOGIN (Dikunci Filter Auth)
// ==========================================

// --- RUTE CHATROOM ---
$routes->get('chat', 'Chat::index', ['filter' => 'auth']);
$routes->get('chat/room/(:num)', 'Chat::room/$1', ['filter' => 'auth']);
$routes->get('chat/personal/(:num)', 'Chat::personal/$1', ['filter' => 'auth']);
$routes->post('chat/send', 'Chat::send', ['filter' => 'auth']);
$routes->get('chat/fetch/(:num)', 'Chat::fetch/$1', ['filter' => 'auth']);
$routes->post('chat/create-group', 'Chat::createGroup', ['filter' => 'auth']);
$routes->get('chat/delete/(:num)', 'Chat::delete/$1', ['filter' => 'auth']);

// --- RUTE TASK PLANNER ---
$routes->get('task', 'Task::index', ['filter' => 'auth']);
$routes->get('task/create', 'Task::create', ['filter' => 'auth']);
$routes->post('task/store', 'Task::store', ['filter' => 'auth']);
$routes->get('task/detail/(:num)', 'Task::detail/$1', ['filter' => 'auth']);
$routes->get('task/edit/(:num)', 'Task::edit/$1', ['filter' => 'auth']);
$routes->post('task/update/(:num)', 'Task::update/$1', ['filter' => 'auth']);
$routes->get('task/toggle/(:num)', 'Task::toggle_status/$1', ['filter' => 'auth']);
$routes->get('task/delete/(:num)', 'Task::delete/$1', ['filter' => 'auth']);
$routes->get('task/print', 'Task::print', ['filter' => 'auth']);

// --- RUTE JURNAL PKL (Versi Baru & Simpel) ---
$routes->get('jurnal', 'Jurnal::index');
$routes->get('jurnal/create', 'Jurnal::create');
$routes->post('jurnal/store', 'Jurnal::store');
    
    // Halaman Detail (Memanggil fungsi show)
$routes->get('jurnal/detail/(:num)', 'Jurnal::show/$1'); 
    
    // Edit & Update
$routes->get('jurnal/edit/(:num)', 'Jurnal::edit/$1');
    $routes->post('jurnal/update/(:num)', 'Jurnal::update/$1');
    
    // Verifikasi Khusus Admin
$routes->get('jurnal/verifikasi', 'Jurnal::verifikasiIndex'); 
$routes->post('jurnal/verifikasi/(:num)', 'Jurnal::verifikasiProses/$1');


// --- RUTE USERS ---
$routes->get('/users', 'Users::index', ['filter' => 'auth']);
$routes->get('/users/create', 'Users::create', ['filter' => 'auth']); 
$routes->post('/users/store', 'Users::store', ['filter' => 'auth']); 
$routes->get('/users/edit/(:num)', 'Users::edit/$1', ['filter' => 'auth']);
$routes->post('/users/update/(:num)', 'Users::update/$1', ['filter' => 'auth']); 
$routes->get('/users/delete/(:num)', 'Users::delete/$1', ['filter' => 'auth']);
$routes->get('/users/detail/(:num)', 'Users::detail/$1', ['filter' => 'auth']); 
$routes->get('/users/print', 'Users::print', ['filter' => 'auth']); 

    // Rute Presensi
$routes->get('presensi', 'Presensi::index', ['filter' => 'auth']);
$routes->post('presensi/submit', 'Presensi::submit', ['filter' => 'auth']);
$routes->get('presensi/rekap', 'Presensi::rekap', ['filter' => 'auth']);
$routes->get('presensi/print', 'Presensi::print');
$routes->get('presensi/izin', 'Presensi::izin');
$routes->post('presensi/submit-izin', 'Presensi::submitIzin');