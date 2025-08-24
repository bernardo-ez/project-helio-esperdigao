<?php
// Script para testar se a API está funcionando
// Acesse: http://localhost/projeto-elio/public/test_api.php

echo "<h1>🧪 Teste da API - Projeto Elio</h1>";

// Teste 1: Verificar se o arquivo api.php existe
echo "<h2>1. Verificando arquivo api.php</h2>";
if (file_exists('../api.php')) {
    echo "✅ Arquivo api.php encontrado<br>";
} else {
    echo "❌ Arquivo api.php NÃO encontrado<br>";
}

// Teste 2: Verificar se o banco de dados está funcionando
echo "<h2>2. Testando conexão com banco de dados</h2>";
try {
    require_once '../system/Database.php';
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db) {
        echo "✅ Conexão com banco estabelecida<br>";
        
        // Verificar se a tabela users existe
        $stmt = $db->query("SHOW TABLES LIKE 'users'");
        if ($stmt->rowCount() > 0) {
            echo "✅ Tabela 'users' existe<br>";
            
            // Verificar se há usuários
            $count_stmt = $db->query("SELECT COUNT(*) FROM users");
            $user_count = $count_stmt->fetchColumn();
            echo "📊 Total de usuários: $user_count<br>";
        } else {
            echo "❌ Tabela 'users' NÃO existe<br>";
        }
    } else {
        echo "❌ Falha na conexão com banco<br>";
    }
} catch (Exception $e) {
    echo "❌ Erro no banco: " . $e->getMessage() . "<br>";
}

// Teste 3: Verificar se o Apache está rodando
echo "<h2>3. Testando Apache</h2>";
$apache_test = @file_get_contents('http://localhost');
if ($apache_test !== false) {
    echo "✅ Apache está rodando<br>";
} else {
    echo "❌ Apache NÃO está rodando<br>";
}

// Teste 4: Testar endpoint da API
echo "<h2>4. Testando endpoint da API</h2>";
$api_url = 'http://localhost/projeto-elio/api.php/marcas';
$api_test = @file_get_contents($api_url);

if ($api_test !== false) {
    echo "✅ API está respondendo<br>";
    echo "📄 Resposta: " . substr($api_test, 0, 100) . "...<br>";
} else {
    echo "❌ API NÃO está respondendo<br>";
    echo "🔗 URL testada: $api_url<br>";
}

// Teste 5: Verificar se o projeto está no local correto
echo "<h2>5. Verificando estrutura do projeto</h2>";
$required_files = [
    '../api.php',
    '../system/Database.php',
    '../system/Router.php',
    '../api/src/controllers/UserController.php'
];

foreach ($required_files as $file) {
    if (file_exists($file)) {
        echo "✅ $file existe<br>";
    } else {
        echo "❌ $file NÃO existe<br>";
    }
}

echo "<h2>🎯 Próximos passos:</h2>";
echo "<p>Se algum teste falhou, você precisa:</p>";
echo "<ol>";
echo "<li>Iniciar o XAMPP (Apache + MySQL)</li>";
echo "<li>Verificar se o projeto está em: C:/xampp/htdocs/projeto-elio/</li>";
echo "<li>Criar os usuários no banco de dados</li>";
echo "</ol>";

echo "<p><a href='index.html' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔐 Ir para Login</a></p>";
?>
