<?php
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
            $events[] = [
                "title" => $asset['title'],
                "id" => $asset['contentId'],
                "type" => "sony",
                "img" => $asset['image_url']
            ];
        }
    }
    return $events;
}

$zee_channels = [
    ["title" => "Zee Cinema HD", "id" => "0-9-zeecinemahd", "type" => "zee5", "img" => "https://static.zee5.com/images/ZEE_CINEMA_HD.png"],
    ["title" => "Zee TV HD", "id" => "0-9-zeetvhd", "type" => "zee5", "img" => "https://static.zee5.com/images/ZEE_TV_HD.png"]
];

$sony_events = getSonyEvents();
$final_data = array_merge($zee_channels, $sony_events);

echo json_encode($final_data, JSON_PRETTY_PRINT);
?>
