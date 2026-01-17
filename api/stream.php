<?php
// Sabse upar CORS headers taaki player block na kare
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/vnd.apple.mpegurl");

$id = $_GET['id'] ?? '';
$type = $_GET['type'] ?? '';

if ($type == 'zee5') {
    $api = "https://catalogapi.zee5.com/v1/channel/" . $id;
    $token_api = "https://useraction.zee5.com/token/live.php";
    
    $res = json_decode(@file_get_contents($api));
    $tok = json_decode(@file_get_contents($token_api));
    
    if($res && isset($res->stream_url_hls)) {
        $finalUrl = $res->stream_url_hls . $tok->video_token;
        // Direct Redirect to m3u8
        header("Location: $finalUrl");
        exit;
    }
} 

if ($type == 'sony') {
    $sony_resolver = "https://sony-api-seven.vercel.app/get_m3u8?id=" . $id; 
    header("Location: $sony_resolver");
    exit;
}
?>
