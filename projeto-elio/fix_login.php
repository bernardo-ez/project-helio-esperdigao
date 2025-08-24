<?php
// Script para testar login diretamente
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔧 Teste de Login Direto</h1>";

try {
    // 1. Conectar ao banco
    require_once 'system/Database.php';
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception("Falha na conexão com banco");
    }
    
    echo "✅ Banco conectado<br>";
    
    // 2. Verificar usuário admin
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute(['admin']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        throw new Exception("Usuário admin não encontrado");
    }
    
    echo "✅ Usuário admin encontrado<br>";
    
    // 3. Verificar senha
    if (!password_verify('admin123', $user['password'])) {
        throw new Exception("Senha incorreta");
    }
    
    echo "✅ Senha correta<br>";
    
    // 4. Gerar JWT
    require_once 'vendor/autoload.php';
    
    $payload = [
        'iat' => time(),
        'exp' => time() + 3600,
        'data' => [
            'userId' => $user['id'],
            'username' => $user['username']
        ]
    ];
    
    $jwt = Firebase\JWT\JWT::encode($payload, 'SUA_CHAVE_SECRETA_MUITO_FORTE_AQUI_PARA_SEGURANCA');
    
    echo "✅ JWT gerado com sucesso!<br>";
    echo "<strong>Token:</strong> " . substr($jwt, 0, 50) . "...<br>";
    
    // 5. Testar se o token é válido
    $decoded = Firebase\JWT\JWT::decode($jwt, 'SUA_CHAVE_SECRETA_MUITO_FORTE_AQUI_PARA_SEGURANCA', ['HS256']);
    
    echo "✅ Token decodificado com sucesso!<br>";
    echo "Usuário: " . $decoded->data->username . "<br>";
    
    echo "<h2>🎉 TUDO FUNCIONANDO!</h2>";
    echo "<p>O problema deve estar no roteamento da API.</p>";
    
    // 6. Testar roteamento
    echo "<h2>🔍 Testando Roteamento</h2>";
    
    // Simular requisição para a API
    $data = json_encode(['username' => 'admin', 'password' => 'admin123']);
    
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => $data
        ]
    ]);
    
    $response = file_get_contents('http://localhost/projeto-elio/api.php/login', false, $context);
    
    if ($response !== false) {
        echo "✅ API respondeu<br>";
        echo "Resposta: " . substr($response, 0, 200) . "...<br>";
    } else {
        echo "❌ API não respondeu - problema no roteamento<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "<br>";
}

echo "<h2>🎯 Próximos passos:</h2>";
echo "<p><a href='public/index.html' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔐 Ir para Login</a></p>";
?>
