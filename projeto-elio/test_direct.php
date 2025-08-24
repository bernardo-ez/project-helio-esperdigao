<?php
// Teste direto - sem dependências externas
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Teste Direto - Projeto Elio</h1>";

// 1. Verificar se o arquivo api.php existe
echo "<h2>1. Verificando arquivo api.php</h2>";
if (file_exists('api.php')) {
    echo "✅ Arquivo api.php encontrado<br>";
} else {
    echo "❌ Arquivo api.php NÃO encontrado<br>";
}

// 2. Verificar se o banco está funcionando
echo "<h2>2. Testando banco de dados</h2>";
try {
    require_once 'system/Database.php';
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db) {
        echo "✅ Conexão com banco estabelecida<br>";
        
        // Verificar se há usuários
        $stmt = $db->query("SELECT COUNT(*) FROM users");
        $count = $stmt->fetchColumn();
        echo "📊 Total de usuários: $count<br>";
        
        if ($count > 0) {
            // Verificar usuário admin
            $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute(['admin']);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                echo "✅ Usuário 'admin' encontrado<br>";
                if (password_verify('admin123', $user['password'])) {
                    echo "✅ Senha 'admin123' está correta<br>";
                } else {
                    echo "❌ Senha 'admin123' está incorreta<br>";
                }
            } else {
                echo "❌ Usuário 'admin' NÃO encontrado<br>";
            }
        }
    } else {
        echo "❌ Falha na conexão com banco<br>";
    }
} catch (Exception $e) {
    echo "❌ Erro no banco: " . $e->getMessage() . "<br>";
}

// 3. Verificar se o JWT está funcionando
echo "<h2>3. Testando JWT</h2>";
try {
    require_once 'vendor/autoload.php';
    echo "✅ Autoload funcionando<br>";
    
    // Testar JWT
    $payload = ['test' => 'data'];
    $jwt = Firebase\JWT\JWT::encode($payload, 'test_key');
    echo "✅ JWT funcionando: " . substr($jwt, 0, 20) . "...<br>";
} catch (Exception $e) {
    echo "❌ Erro no JWT: " . $e->getMessage() . "<br>";
}

// 4. Testar roteamento
echo "<h2>4. Testando roteamento</h2>";
$request_uri = $_SERVER['REQUEST_URI'];
echo "URI atual: $request_uri<br>";

// 5. Testar se a API responde
echo "<h2>5. Testando resposta da API</h2>";
try {
    // Simular uma requisição POST para login
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
        echo "Resposta: " . substr($response, 0, 100) . "...<br>";
    } else {
        echo "❌ API não respondeu<br>";
    }
} catch (Exception $e) {
    echo "❌ Erro ao testar API: " . $e->getMessage() . "<br>";
}

echo "<h2>🎯 Próximos passos:</h2>";
echo "<p><a href='public/index.html' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔐 Ir para Login</a></p>";
?>
