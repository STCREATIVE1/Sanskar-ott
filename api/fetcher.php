<?php
// api/fetcher.php ke start mein ye zaroor rakhein
error_reporting(0); 
header('Content-Type: application/json');

// ... baaki ka logic ...

// Last mein sirf ye print karein
echo json_encode($final_data);
?>
