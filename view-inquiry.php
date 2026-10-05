<?php
// CORS Headers - બ્રાઉઝર ફેચ રિક્વેસ્ટ બ્લોક ન કરે તે માટે
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// Preflight OPTIONS Request મારે ત્યારે તરત જ 200 OK આપીને નીકળી જાઓ
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Error display બંધ રાખવું જેથી JSON ખરાબ ન થાય
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once 'db.php';

$response = [];

try {
    $sql = "SELECT id, name, email, subject, message, created_at FROM inquiries ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
        http_response_code(200);
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Query failed: " . $conn->error]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}

$conn->close();
?>