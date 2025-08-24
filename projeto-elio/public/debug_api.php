<?php
// Debug da API
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🐛 Debug da API</h1>";

// Testar se a API está funcionando
$api_url = 'http://localhost/projeto-elio/api.php/login';

echo "<h2>Testando: $api_url</h2>";

$data = json_encode(['username' => 'admin', 'password' => 'admin123']);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => $data
    ]
]);

$response = file_get_contents($api_url, false, $context);

echo "<h3>Resposta bruta:</h3>";
echo "<pre>" . htmlspecialchars($response) . "</pre>";

echo "<h3>Headers da resposta:</h3>";
echo "<pre>";
print_r($http_response_header);
echo "</pre>";
?>
