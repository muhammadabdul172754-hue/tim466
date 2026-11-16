<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table            = 'messages';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['room_id', 'user_id', 'message'];
    protected $useTimestamps    = false;

    // Ambil semua ruangan milik user
    public function getMyRooms($userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('chat_rooms');
        $builder->select('chat_rooms.*');
        $builder->join('chat_participants', 'chat_participants.room_id = chat_rooms.id');
        $builder->where('chat_participants.user_id', $userId);
        $rooms = $builder->get()->getResultArray();

        foreach ($rooms as &$room) {
            if ($room['type'] == 'group') {
                $room['display_name'] = $room['name'];
                $room['avatar'] = 'https://ui-avatars.com/api/?name='.urlencode($room['name']).'&background=3b82f6&color=fff';
            } else {
                $otherUser = $db->table('chat_participants')
                                ->select('users.id, users.nama, users.foto')
                                ->join('users', 'users.id = chat_participants.user_id')
                                ->where('chat_participants.room_id', $room['id'])
                                ->where('chat_participants.user_id !=', $userId)
                                ->get()->getRowArray();
                                
                if ($otherUser) {
                    $room['display_name'] = $otherUser['nama'];
                    $room['target_id'] = $otherUser['id'];
                    $room['avatar'] = $otherUser['foto'] ? base_url('uploads/users/'.$otherUser['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($otherUser['nama']).'&background=random';
                } else {
                    $room['display_name'] = 'Unknown';
                    $room['avatar'] = 'https://ui-avatars.com/api/?name=Unknown';
                }
            }
        }
        return $rooms;
    }

    // Ambil pesan berdasarkan Room
    public function getMessagesByRoom($roomId)
    {
        return $this->select('messages.*, users.nama, users.foto')
                    ->join('users', 'users.id = messages.user_id', 'left')
                    ->where('room_id', $roomId)
                    ->orderBy('messages.created_at', 'ASC')
                    ->findAll();
    }

    // Buat chat pribadi
    public function getOrCreatePersonalRoom($myId, $targetId)
    {
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT r.id FROM chat_rooms r
            JOIN chat_participants p1 ON r.id = p1.room_id AND p1.user_id = ?
            JOIN chat_participants p2 ON r.id = p2.room_id AND p2.user_id = ?
            WHERE r.type = 'personal'
        ", [$myId, $targetId]);

        $existingRoom = $query->getRowArray();
        if ($existingRoom) return $existingRoom['id']; 

        $db->table('chat_rooms')->insert(['type' => 'personal', 'name' => null]);
        $newRoomId = $db->insertID();

        $db->table('chat_participants')->insertBatch([
            ['room_id' => $newRoomId, 'user_id' => $myId],
            ['room_id' => $newRoomId, 'user_id' => $targetId]
        ]);

        return $newRoomId;
    }

    // Buat Grup
    public function createGroup($name, $participants)
    {
        $db = \Config\Database::connect();
        $db->table('chat_rooms')->insert(['name' => $name, 'type' => 'group']);
        $roomId = $db->insertID();

        $dataPeserta = [];
        foreach ($participants as $userId) {
            $dataPeserta[] = ['room_id' => $roomId, 'user_id' => $userId];
        }
        $dataPeserta[] = ['room_id' => $roomId, 'user_id' => session()->get('id')];
        $db->table('chat_participants')->insertBatch($dataPeserta);

        return $roomId;
    }

    // Ambil daftar kontak
    public function getAllContacts($myId)
    {
        $db = \Config\Database::connect();
        return $db->table('users')->where('id !=', $myId)->get()->getResultArray();
    }
}