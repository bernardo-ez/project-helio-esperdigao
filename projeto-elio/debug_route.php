<?php
// Debug de roteamento
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Debug de Roteamento</h1>";

echo "<h2>1. Informações da Requisição</h2>";
echo "REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "<br>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "PHP_SELF: " . $_SERVER['PHP_SELF'] . "<br>";

echo "<h2>2. Testando Roteamento</h2>";

// Simular uma requisição POST para login
$data = json_encode(['username' => 'admin', 'password' => 'admin123']);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => $data
    ]
]);

// Testar diferentes URLs
$urls = [
    'http://localhost/projeto-elio/login',
    'http://localhost/projeto-elio/api.php/login',
    'http://localhost/projeto-elio/api.php'
];

foreach ($urls as $url) {
    echo "<h3>Testando: $url</h3>";
    
    $response = file_get_contents($url, false, $context);
    
    if ($response !== false) {
        echo "✅ Resposta recebida<br>";
        echo "Conteúdo: " . substr($response, 0, 200) . "...<br>";
    } else {
        echo "❌ Sem resposta<br>";
        $error = error_get_last();
        if ($error) {
            echo "Erro: " . $error['message'] . "<br>";
        }
    }
    echo "<hr>";
}

echo "<h2>3. Verificar se api.php existe</h2>";
if (file_exists('api.php')) {
    echo "✅ api.php existe<br>";
    
    // Verificar se o arquivo pode ser executado
    $content = file_get_contents('api.php');
    if ($content !== false) {
        echo "✅ api.php pode ser lido<br>";
        echo "Primeiras linhas: " . substr($content, 0, 100) . "...<br>";
    } else {
        echo "❌ api.php não pode ser lido<br>";
    }
} else {
    echo "❌ api.php não existe<br>";
}

echo "<h2>4. Verificar .htaccess</h2>";
if (file_exists('.htaccess')) {
    echo "✅ .htaccess existe<br>";
    $htaccess = file_get_contents('.htaccess');
    echo "Conteúdo: <pre>$htaccess</pre>";
} else {
    echo "❌ .htaccess não existe<br>";
}

echo "<h2>5. Teste direto da API</h2>";
echo "<p><a href='api.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔗 Acessar api.php diretamente</a></p>";
?>
