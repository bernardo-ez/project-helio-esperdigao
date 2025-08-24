<?php
// Teste simples da API
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🧪 Teste Simples da API</h1>";

// Testar se o arquivo api.php existe
if (file_exists('api.php')) {
    echo "<p>✅ Arquivo api.php encontrado</p>";
} else {
    echo "<p>❌ Arquivo api.php NÃO encontrado</p>";
}

// Testar se o banco está funcionando
try {
    require_once 'system/Database.php';
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db) {
        echo "<p>✅ Conexão com banco estabelecida</p>";
        
        // Testar se há usuários
        $stmt = $db->query("SELECT COUNT(*) FROM users");
        $count = $stmt->fetchColumn();
        echo "<p>📊 Total de usuários: $count</p>";
    } else {
        echo "<p>❌ Falha na conexão com banco</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ Erro no banco: " . $e->getMessage() . "</p>";
}

// Testar se o JWT está funcionando
try {
    require_once 'vendor/autoload.php';
    echo "<p>✅ Autoload funcionando</p>";
    
    // Testar JWT
    $payload = ['test' => 'data'];
    $jwt = Firebase\JWT\JWT::encode($payload, 'test_key');
    echo "<p>✅ JWT funcionando: " . substr($jwt, 0, 20) . "...</p>";
} catch (Exception $e) {
    echo "<p>❌ Erro no JWT: " . $e->getMessage() . "</p>";
}

echo "<h2>🎯 Teste de Login Manual</h2>";

// Simular login
try {
    require_once 'api/src/dao/UserDAO.php';
    require_once 'api/src/models/UserModel.php';
    
    $userDAO = new UserDAO();
    $user = $userDAO->findByUsername('admin');
    
    if ($user) {
        echo "<p>✅ Usuário 'admin' encontrado</p>";
        
        if (password_verify('admin123', $user->getPassword())) {
            echo "<p>✅ Senha 'admin123' está correta</p>";
            
            // Gerar JWT
            $payload = [
                'iat' => time(),
                'exp' => time() + 3600,
                'data' => [
                    'userId' => $user->getId(),
                    'username' => $user->getUsername()
                ]
            ];
            
            $jwt = Firebase\JWT\JWT::encode($payload, 'SUA_CHAVE_SECRETA_MUITO_FORTE_AQUI_PARA_SEGURANCA');
            echo "<p>✅ JWT gerado com sucesso!</p>";
            echo "<p><strong>Token:</strong> " . substr($jwt, 0, 50) . "...</p>";
            
        } else {
            echo "<p>❌ Senha 'admin123' está incorreta</p>";
        }
    } else {
        echo "<p>❌ Usuário 'admin' NÃO encontrado</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ Erro no teste de login: " . $e->getMessage() . "</p>";
}

echo "<h2>🌐 Próximos passos:</h2>";
echo "<p><a href='public/index.html' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔐 Ir para Login</a></p>";
?>
