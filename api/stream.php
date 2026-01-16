<?php
// api/stream.php
$id = $_GET['id'] ?? '';
$type = $_GET['type'] ?? '';

if (empty($id)) {
    die("No ID provided");
}

if ($type == 'zee5') {
    // Zee5 Logic
    $api = "https://catalogapi.zee5.com/v1/channel/" . $id;
    $token_api = "https://useraction.zee5.com/token/live.php";
    $res = json_decode(file_get_contents($api));
    $tok = json_decode(file_get_contents($token_api));
    header("Location: " . $res->stream_url_hls . $tok->video_token);
    exit;

} elseif ($type == 'sony') {
    // SonyLIV Live Events Logic
    // Hum ek working server ka use karenge jo SonyLIV ke tokens handle karta hai
    $sony_url = "https://sony-api-seven.vercel.app/get_m3u8?id=" . $id; 
    
    // Redirecting to the live stream
    header("Location: " . $sony_url);
    exit;
}
?>
