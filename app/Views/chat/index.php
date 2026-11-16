<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* CSS Dasar untuk Chat */
    .chat-wrapper { display: flex; height: calc(100vh - 140px); background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e2e8f0; }
    .chat-sidebar { width: 320px; border-right: 1px solid #e2e8f0; display: flex; flex-direction: column; background: #f8fafc; }
    .chat-main { flex: 1; display: flex; flex-direction: column; background: #efeae2; background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png'); }
    
    /* List Chat */
    .room-item { display: flex; align-items: center; gap: 15px; padding: 15px 20px; border-bottom: 1px solid #f1f5f9; text-decoration: none; color: inherit; transition: 0.2s; }
    .room-item:hover { background: #f1f5f9; }
    .room-item.active { background: #eff6ff; border-left: 3px solid #3b82f6; }
    
    /* Gaya Bubble Chat */
    .msg-wrapper { display: flex; margin-bottom: 20px; width: 100%; }
    .msg-wrapper.mine { justify-content: flex-end; }
    .msg-wrapper.other { justify-content: flex-start; }
    
    .msg-content { display: flex; flex-direction: column; max-width: 75%; }
    .msg-wrapper.mine .msg-content { align-items: flex-end; }
    .msg-wrapper.other .msg-content { align-items: flex-start; }
    
    .msg-avatar { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 1px solid #e2e8f0; }
    .msg-wrapper.mine .msg-avatar { margin-left: 10px; }
    .msg-wrapper.other .msg-avatar { margin-right: 10px; }
    
    .msg-name { font-size: 11px; color: #64748b; margin-bottom: 3px; }
    
    .msg-bubble { padding: 10px 15px; border-radius: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); color: #1e293b; font-size: 14px; position: relative; }
    .msg-wrapper.mine .msg-bubble { background: #dbeafe; border-bottom-right-radius: 0; }
    .msg-wrapper.other .msg-bubble { background: #ffffff; border-bottom-left-radius: 0; }
    
    /* Menu Titik Tiga */
    .options-btn { background: none; border: none; cursor: pointer; color: #94a3b8; padding: 5px; transition: 0.2s; }
    .options-btn:hover { color: #3b82f6; }
    .dropdown-menu { display: none; position: absolute; top: 25px; background: white; border: 1px solid #e2e8f0; border-radius: 6px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 10; min-width: 100px; }
    .dropdown-menu button { display: block; width: 100%; text-align: left; padding: 8px 12px; border: none; background: none; font-size: 13px; cursor: pointer; }
    .dropdown-menu button:hover { background: #f1f5f9; }
</style>

<div class="chat-wrapper" data-aos="fade-up">
    
    <!-- ================= SIDEBAR KIRI ================= -->
    <div class="chat-sidebar">
        <div style="padding: 20px; border-bottom: 1px solid #e2e8f0; background: white;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: #0f172a;">Percakapan</h3>
                <div style="display: flex; gap: 5px;">
                    <button onclick="document.getElementById('modalKontak').style.display='flex'" style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: bold; cursor: pointer;">+ Chat</button>
                    <button onclick="document.getElementById('modalGrup').style.display='flex'" style="background: #3b82f6; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: bold; cursor: pointer;">+ Grup</button>
                </div>
            </div>
            <input type="text" placeholder="Cari percakapan..." style="width: 100%; padding: 10px 15px; border: 1px solid #cbd5e1; border-radius: 20px; outline: none; font-size: 13px; box-sizing: border-box;">
        </div>
        
        <div style="flex: 1; overflow-y: auto;">
            <?php if(empty($rooms)): ?>
                <div style="padding: 30px; text-align: center; color: #94a3b8; font-size: 13px;">Belum ada percakapan.</div>
            <?php else: ?>
                <?php foreach($rooms as $r): ?>
                    <a href="<?= base_url('chat/room/'.$r['id']) ?>" class="room-item <?= $active_room_id == $r['id'] ? 'active' : '' ?>">
                        <img src="<?= $r['avatar'] ?>" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0;">
                        <div style="flex: 1; overflow: hidden;">
                            <h4 style="margin: 0 0 5px 0; font-size: 14px; font-weight: 700; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= esc($r['display_name']) ?></h4>
                            <p style="margin: 0; font-size: 12px; color: #64748b;">Klik untuk membuka</p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- ================= AREA CHAT KANAN ================= -->
    <div class="chat-main">
        <?php if($active_room_id): ?>
            <?php 
                $currentRoom = array_filter($rooms, fn($rm) => $rm['id'] == $active_room_id);
                $currentRoom = reset($currentRoom);
            ?>
            <!-- Header Chat -->
            <div style="background: white; padding: 15px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); z-index: 10;">
                <img src="<?= $currentRoom['avatar'] ?>" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover;">
                <div>
                    <h4 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;"><?= esc($currentRoom['display_name']) ?></h4>
                    <p style="margin: 0; font-size: 12px; color: #10b981; font-weight: 600;"><?= $currentRoom['type'] == 'group' ? 'Grup Obrolan' : 'Online' ?></p>
                </div>
            </div>

            <!-- Area Pesan -->
            <div id="chatBox" style="flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column;"></div>

            <!-- Input Area -->
            <div style="padding: 15px; background: white; border-top: 1px solid #e2e8f0;">
                
                <!-- Kotak Preview Balasan -->
                <div id="reply-preview" style="display:none; background:#f1f5f9; padding:10px 15px; border-left:4px solid #3b82f6; margin-bottom:10px; border-radius:4px; position:relative; font-size:13px;">
                    <span id="reply-name" style="font-weight:bold; color:#3b82f6; display:block;"></span>
                    <span id="reply-text" style="color:#64748b;"></span>
                    <button type="button" onclick="batalBalas()" style="position:absolute; right:10px; top:10px; background:none; border:none; cursor:pointer; color:red;"><i class="bi bi-x-circle"></i></button>
                </div>

                <form id="formChat" style="display: flex; gap: 10px; margin: 0;">
                    <input type="hidden" id="reply_to_id" value="">
                    <input type="text" id="messageInput" placeholder="Ketik pesan..." autocomplete="off" style="flex: 1; padding: 15px 20px; border: 1px solid #cbd5e1; border-radius: 25px; outline: none; font-size: 14px;">
                    <button type="submit" id="btnKirim" style="background: #1e3a8a; color: white; border: none; padding: 0 25px; border-radius: 25px; font-weight: bold; cursor: pointer;">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div style="flex: 1; display: flex; justify-content: center; align-items: center; flex-direction: column; background: #f8fafc; color: #64748b;">
                <i class="bi bi-chat-dots-fill" style="font-size: 50px; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h3 style="margin: 0 0 10px 0; color: #0f172a; font-weight: 800;">Ruang Obrolan Tim</h3>
                <p style="margin: 0; font-size: 14px;">Pilih percakapan di sebelah kiri untuk mulai mengobrol.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ================= MODAL KONTAK ================= -->
<div id="modalKontak" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 9999;">
    <div style="background: white; width: 400px; max-width: 90%; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
        <div style="padding: 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">Mulai Chat Baru</h3>
            <button onclick="document.getElementById('modalKontak').style.display='none'" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #64748b;">&times;</button>
        </div>
        <div style="max-height: 400px; overflow-y: auto;">
            <?php foreach($contacts as $c): ?>
                <a href="<?= base_url('chat/personal/'.$c['id']) ?>" style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; border-bottom: 1px solid #f1f5f9; text-decoration: none; color: inherit;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='white'">
                    <img src="<?= $c['foto'] ? base_url('uploads/users/'.$c['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($c['nama']).'&background=random' ?>" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <div>
                        <div style="font-weight: bold; color: #0f172a; font-size: 14px;"><?= esc($c['nama']) ?></div>
                        <div style="font-size: 12px; color: #64748b; text-transform: capitalize;"><?= esc($c['role']) ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- ================= MODAL GRUP ================= -->
<div id="modalGrup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 9999;">
    <div style="background: white; width: 450px; max-width: 90%; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
        <div style="padding: 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">Buat Grup Baru</h3>
            <button onclick="document.getElementById('modalGrup').style.display='none'" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #64748b;">&times;</button>
        </div>
        <form action="<?= base_url('chat/create-group') ?>" method="POST">
            <?= csrf_field() ?>
            <div style="padding: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="font-weight: bold; font-size: 14px; display: block; margin-bottom: 5px;">Nama Grup</label>
                    <input type="text" name="group_name" required placeholder="Misal: Tim Diskusi" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="font-weight: bold; font-size: 14px; display: block; margin-bottom: 10px;">Pilih Anggota:</label>
                    <div style="max-height: 200px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px;">
                        <?php foreach($contacts as $c): ?>
                            <label style="display: flex; align-items: center; gap: 10px; padding: 8px; cursor: pointer; border-bottom: 1px solid #f1f5f9;">
                                <input type="checkbox" name="participants[]" value="<?= $c['id'] ?>" style="width: 18px; height: 18px; accent-color: #3b82f6;">
                                <span style="font-size: 14px; font-weight: 600; color: #334155;"><?= esc($c['nama']) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button type="submit" style="width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Buat Grup</button>
            </div>
        </form>
    </div>
</div>

<?php if($active_room_id): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chatBox = document.getElementById("chatBox");
        var formChat = document.getElementById("formChat");
        var messageInput = document.getElementById("messageInput");
        var roomId = "<?= $active_room_id ?>";
        var replyInput = document.getElementById("reply_to_id");

        function loadMessages() {
            fetch("<?= base_url('chat/fetch/') ?>" + roomId)
                .then(res => res.json())
                .then(data => {
                    chatBox.innerHTML = data.html;
                    chatBox.scrollTop = chatBox.scrollHeight;
                });
        }

        formChat.addEventListener("submit", function(e) {
            e.preventDefault(); 
            var message = messageInput.value.trim();
            if (message === "") return;

            var formData = new FormData();
            formData.append("room_id", roomId);
            formData.append("message", message);
            formData.append("reply_to_id", replyInput.value);

            fetch("<?= base_url('chat/send') ?>", { method: "POST", body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    messageInput.value = "";
                    batalBalas(); 
                    loadMessages();
                } else {
                    alert("Error: " + data.message);
                }
            });
        });

        window.toggleMenu = function(id) {
            document.querySelectorAll('[id^="menu-"]').forEach(el => {
                if(el.id !== 'menu-'+id) el.style.display = 'none';
            });
            var menu = document.getElementById('menu-' + id);
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        };

        window.replyTo = function(id, text, name) {
            document.getElementById('reply-preview').style.display = 'block';
            document.getElementById('reply-name').innerText = 'Membalas ' + name + ':';
            document.getElementById('reply-text').innerText = text;
            replyInput.value = id;
            messageInput.focus();
            toggleMenu(id); 
        };

        window.batalBalas = function() {
            document.getElementById('reply-preview').style.display = 'none';
            replyInput.value = '';
        };

        window.hapusPesan = function(id) {
            if(confirm('Hapus pesan ini?')) {
                fetch("<?= base_url('chat/delete/') ?>" + id)
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') loadMessages();
                    else alert(data.message);
                });
            }
        };

        window.addEventListener('click', function(e) {
            if (!e.target.closest('.msg-bubble') && !e.target.closest('button')) {
                document.querySelectorAll('[id^="menu-"]').forEach(el => el.style.display = 'none');
            }
        });

        loadMessages();
        setInterval(loadMessages, 2000); 
    });
</script>
<?php endif; ?>

<?= $this->endSection() ?>