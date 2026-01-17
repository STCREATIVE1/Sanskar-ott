<?php
error_reporting(0);
header('Content-Type: application/json');

function getSonyEvents() {
    $url = "https://msapi.sonyliv.com/privileged/v1/content/live/events?contentId=sports";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64)");
    $res = curl_exec($ch);
    $data = json_decode($res, true);
    
    $events = [];
    if(isset($data['resultObj']['containers'][0]['assets'])) {
        foreach($data['resultObj']['containers'][0]['assets'] as $asset) {
            $id = $asset['contentId'];
            $events[] = [
                "title" => $asset['title'],
                "id" => $id,
                "type" => "sony",
                "img" => $asset['image_url'],
                // Yahan hum direct streaming proxy link daal rahe hain
                "url" => "https://sony-api-seven.vercel.app/get_m3u8?id=" . $id
            ];
        }
    }
    return $events;
}

// Zee5 channels ke liye static list with stream.php path
$zee_channels = [
    [
        "title" => "Zee Cinema HD", 
        "id" => "0-9-zeecinemahd", 
        "type" => "zee5", 
        "img" => "https://static.zee5.com/images/ZEE_CINEMA_HD.png",
        "url" => "api/stream.php?id=0-9-zeecinemahd&type=zee5"
    ]
];

$sony_data = getSonyEvents();
$final_data = array_merge($zee_channels, $sony_data);

echo json_encode($final_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>
