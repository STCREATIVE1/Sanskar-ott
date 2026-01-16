<?php
error_reporting(0);
header('Content-Type: application/json');

function getSonyEvents() {
    $url = "https://msapi.sonyliv.com/privileged/v1/content/live/events?contentId=sports";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64)");
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $res = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($res, true);
    $events = [];
    
    // Agar live events milte hain toh unhe add karein
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
    
    // Agar koi live match nahi hai, toh fix Sony Sports channels add karein
    if(empty($events)) {
        $events[] = ["title" => "Sony Sports Ten 1", "id" => "sony_ten1", "type" => "sony", "img" => "https://upload.wikimedia.org/wikipedia/en/2/23/Sony_LIV_logo.png"];
        $events[] = ["title" => "Sony Sports Ten 5", "id" => "sony_ten5", "type" => "sony", "img" => "https://upload.wikimedia.org/wikipedia/en/2/23/Sony_LIV_logo.png"];
    }
    
    return $events;
}

$zee_channels = [
    ["title" => "Zee Cinema HD", "id" => "0-9-zeecinemahd", "type" => "zee5", "img" => "https://static.zee5.com/images/ZEE_CINEMA_HD.png"],
    ["title" => "Zee TV HD", "id" => "0-9-zeetvhd", "type" => "zee5", "img" => "https://static.zee5.com/images/ZEE_TV_HD.png"]
];

$sony_data = getSonyEvents();
$final_data = array_merge($zee_channels, $sony_data);

echo json_encode($final_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>
