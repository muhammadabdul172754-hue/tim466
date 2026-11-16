<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ChatModel;

class Chat extends BaseController
{
    protected $chatModel;

    public function __construct()
    {
        $this->chatModel = new ChatModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $data = [
            'title' => 'Chat Tim',
            'rooms' => $this->chatModel->getMyRooms($userId),
            'contacts' => $this->chatModel->getAllContacts($userId),
            'active_room_id' => null
        ];
        return view('chat/index', $data);
    }

    public function room($roomId)
    {
        $userId = session()->get('id');
        $data = [
            'title' => 'Chat Tim',
            'rooms' => $this->chatModel->getMyRooms($userId),
            'contacts' => $this->chatModel->getAllContacts($userId),
            'active_room_id' => $roomId
        ];
        return view('chat/index', $data);
    }

    public function personal($targetId)
    {
        $myId = session()->get('id');
        $roomId = $this->chatModel->getOrCreatePersonalRoom($myId, $targetId);
        return redirect()->to('/chat/room/'.$roomId);
    }

    public function createGroup()
    {
        $name = $this->request->getPost('group_name');
        $participants = $this->request->getPost('participants');
        if (empty($name) || empty($participants)) return redirect()->to('/chat');
        $roomId = $this->chatModel->createGroup($name, $participants);
        return redirect()->to('/chat/room/'.$roomId);
    }

    // PROSES SIMPAN PESAN
        public function send()
    {
        $roomId = $this->request->getPost('room_id');
        $message = $this->request->getPost('message');
        $replyTo = $this->request->getPost('reply_to_id'); // Tangkap ID balasan
        $userId = session()->get('id');

        if (!$roomId || !$message || !$userId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap!']);
        }

        $data = [
            'room_id' => $roomId,
            'user_id' => $userId,
            'message' => $message,
            'reply_to_id' => empty($replyTo) ? null : $replyTo // Simpan
        ];

        if ($this->chatModel->save($data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal simpan.']);
        }
    }

    public function fetch($roomId)
    {
        $messages = $this->chatModel->getMessagesByRoom($roomId);
        $html = '';
        
        foreach($messages as $m) {
            $isMe = $m['user_id'] == session()->get('id');
            $align = $isMe ? 'flex-end' : 'flex-start';
            $flexDir = $isMe ? 'row-reverse' : 'row'; // Foto di kanan jika saya
            $bg = $isMe ? '#dbeafe' : '#ffffff'; 
            $textAlign = $isMe ? 'right' : 'left';

            // Ambil data balasan jika ada
            $quotedHtml = '';
            if (!empty($m['reply_to_id'])) {
                $quotedMsg = $this->chatModel->find($m['reply_to_id']);
                if ($quotedMsg) {
                    $quotedHtml = '<div style="background: rgba(0,0,0,0.05); border-left: 3px solid #3b82f6; padding: 5px 10px; border-radius: 4px; font-size: 12px; margin-bottom: 5px; color: #475569;">
                        <b>Membalas:</b> '.esc(substr($quotedMsg['message'], 0, 30)).'...
                    </div>';
                }
            }
            
            // Foto Profil & Nama
            $fotoUrl = $m['foto'] ? base_url('uploads/users/'.$m['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($m['nama']).'&background=random';
            
            $html .= '<div id="msg-'.$m['id'].'" style="display:flex; flex-direction:'.$flexDir.'; align-items:flex-end; gap:10px; margin-bottom:20px; width:100%;">';
            
            // Foto
            $html .= '<img src="'.$fotoUrl.'" style="width:35px; height:35px; border-radius:50%; object-fit:cover; border:1px solid #e2e8f0;">';
            
            // Bubble Chat
            $html .= '<div style="display:flex; flex-direction:column; align-items:'.$align.'; max-width:70%;">';
            $html .= '<span style="font-size:11px; color:#64748b; margin-bottom:3px;">'.esc($m['nama']).'</span>';
            $html .= '<div style="background:'.$bg.'; padding:10px 15px; border-radius:12px; box-shadow:0 1px 2px rgba(0,0,0,0.05); color: #1e293b; font-size:14px; position:relative;" class="chat-bubble">';
            $html .= $quotedHtml . esc($m['message']);
            $html .= '</div>';
            $html .= '</div>';

            // Tombol Opsi (Titik Tiga)
            $html .= '<div style="position:relative;">';
            $html .= '<button onclick="toggleMenu('.$m['id'].')" style="background:none; border:none; cursor:pointer; color:#94a3b8; padding:5px;"><i class="bi bi-three-dots-vertical"></i></button>';
            $html .= '<div id="menu-'.$m['id'].'" style="display:none; position:absolute; '.($isMe ? 'left:-80px;' : 'right:-80px;').' top:30px; background:white; border:1px solid #e2e8f0; border-radius:6px; box-shadow:0 2px 5px rgba(0,0,0,0.1); z-index:10; min-width:90px;">';
            $html .= '<button onclick="replyTo('.$m['id'].', \''.esc(addslashes($m['message'])).'\', \''.esc(addslashes($m['nama'])).'\')" style="display:block; width:100%; text-align:left; padding:8px 12px; border:none; background:none; font-size:13px; cursor:pointer;"><i class="bi bi-reply"></i> Balas</button>';
            if ($isMe || session()->get('role') == 'admin') {
                $html .= '<button onclick="hapusPesan('.$m['id'].')" style="display:block; width:100%; text-align:left; padding:8px 12px; border:none; background:none; font-size:13px; color:red; cursor:pointer;"><i class="bi bi-trash"></i> Hapus</button>';
            }
            $html .= '</div></div>';

            $html .= '</div>';
        }
        return $this->response->setJSON(['html' => $html]);
    }

        public function delete($id)
    {
        $pesan = $this->chatModel->find($id);
        if ($pesan && ($pesan['user_id'] == session()->get('id') || session()->get('role') == 'admin')) {
            $this->chatModel->delete($id);
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak berhak menghapus']);
    }
}