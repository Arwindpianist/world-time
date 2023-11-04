<?php
// CORS shit

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type");

if (isset($_GET['timeZone'])) {
    $timeZone = urlencode($_GET['timeZone']);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://timeapi.io/api/Time/current/zone?timeZone=$timeZone");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(['error' => 'cURL error: ' . curl_error($ch)]);
    } else {
        $data = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'Invalid JSON response']);
        }
    }

    curl_close($ch);
} else {
    echo json_encode(['error' => 'Missing timeZone parameter']);
}
