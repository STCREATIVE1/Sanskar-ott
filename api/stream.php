<?php
$id = $_GET['id'] ?? '';
$type = $_GET['type'] ?? '';

if ($type == 'zee5') {
    $api = "https://catalogapi.zee5.com/v1/channel/" . $id;
    $token_api = "https://useraction.zee5.com/token/live.php";
    $res = json_decode(@file_get_contents($api));
    $tok = json_decode(@file_get_contents($token_api));
    if($res) {
        header("Location: " . $res->stream_url_hls . $tok->video_token);
        exit;
    }
} 

if ($type == 'sony') {
    // SonyLIV Resolver (Direct playback link)
    $sony_resolver = "https://sony-api-seven.vercel.app/get_m3u8?id=" . $id; 
    header("Location: " . $sony_resolver);
    exit;
}
?>
