<?php
// Teste direto do login
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔧 Teste Direto do Login</h1>";

// Simular dados de login
$_POST = json_decode('{"username":"admin","password":"admin123"}', true);
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/login';

// Incluir a API
require_once 'api.php';

echo "<h2>✅ Teste concluído!</h2>";
echo "<p><a href='public/index.html'>🔐 Ir para Login</a></p>";
?>
