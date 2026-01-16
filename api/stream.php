<?php
$id = $_GET['id'] ?? '';
$type = $_GET['type'] ?? '';

if ($type == 'zee5') {
    $api = "https://catalogapi.zee5.com/v1/channel/" . $id;
    $token_api = "https://useraction.zee5.com/token/live.php";
    $res = json_decode(file_get_contents($api));
    $tok = json_decode(file_get_contents($token_api));
    header("Location: " . $res->stream_url_hls . $tok->video_token);
} else {
    // Sony ya anya ke liye fallback link
    header("Location: https://dai.google.com/linear/hls/event/sid/master.m3u8");
}
?>
