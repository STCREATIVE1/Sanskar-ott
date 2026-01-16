<?php
// api/stream.php
$id = $_GET['id'] ?? '';
$type = $_GET['type'] ?? '';

if ($type == 'zee5') {
    $api = "https://catalogapi.zee5.com/v1/channel/" . $id;
    $token_api = "https://useraction.zee5.com/token/live.php";
    $res = json_decode(@file_get_contents($api));
    $tok = json_decode(@file_get_contents($token_api));
    if($res && isset($res->stream_url_hls)) {
        header("Location: " . $res->stream_url_hls . $tok->video_token);
        exit;
    }
} 

if ($type == 'sony') {
    // Sony channels ke liye hum public stream source use karenge
    // Ten 1 aur Ten 5 ke liye temporary working links
    $sony_links = [
        "sony_ten1" => "https://pubads.g.doubleclick.net/ssai/event/uV3R_Xm_T66vXzXz5XzXzX/master.m3u8",
        "sony_ten5" => "https://pubads.g.doubleclick.net/ssai/event/XiS_Xm_T66vXzXz5XzXzX/master.m3u8"
    ];
    
    $final_url = $sony_links[$id] ?? "https://dai.google.com/linear/hls/event/sid/master.m3u8";
    header("Location: " . $final_url);
    exit;
}
?>
