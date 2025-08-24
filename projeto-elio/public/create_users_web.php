<?php
// Script para criar usuários via navegador
// Acesse: http://localhost/projeto-elio/public/create_users_web.php

require_once '../system/Database.php';

echo "<h1>🔐 Criando Usuários - Projeto Elio</h1>";

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "<p>✅ Conexão com banco de dados estabelecida!</p>";
    
    // Array de usuários para criar
    $users = [
        ['username' => 'admin', 'password' => 'admin123'],
        ['username' => 'user', 'password' => 'user123'],
        ['username' => 'test', 'password' => 'test123'],
        ['username' => 'elio', 'password' => 'elio123'],
        ['username' => 'porsche', 'password' => 'porsche123'],
        ['username' => 'ferrari', 'password' => 'ferrari123'],
        ['username' => 'lamborghini', 'password' => 'lamborghini123']
    ];
    
    echo "<h2>📋 Criando usuários...</h2>";
    
    foreach ($users as $user) {
        $username = $user['username'];
        $password = $user['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Verificar se o usuário já existe
        $check_query = "SELECT id FROM users WHERE username = :username";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(':username', $username);
        $check_stmt->execute();
        
        if ($check_stmt->fetch()) {
            echo "<p>⚠️ Usuário <strong>'$username'</strong> já existe. Pulando...</p>";
            continue;
        }
        
        // Inserir novo usuário
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        
        if ($stmt->execute()) {
            echo "<p>✅ Usuário <strong>'$username'</strong> criado com sucesso!</p>";
        } else {
            echo "<p>❌ Erro ao criar usuário <strong>'$username'</strong></p>";
        }
    }
    
    echo "<h2>🎉 Processo concluído!</h2>";
    echo "<h3>📋 Credenciais para login:</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Usuário</th><th>Senha</th><th>Descrição</th></tr>";
    
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td><strong>{$user['username']}</strong></td>";
        echo "<td><code>{$user['password']}</code></td>";
        echo "<td>Usuário {$user['username']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h3>🌐 Próximos passos:</h3>";
    echo "<p>1. <a href='index.html'>Clique aqui para ir para a página de login</a></p>";
    echo "<p>2. Use qualquer uma das credenciais acima</p>";
    echo "<p>3. Recomendado: <strong>admin</strong> / <strong>admin123</strong></p>";
    
} catch (Exception $e) {
    echo "<p>❌ Erro: " . $e->getMessage() . "</p>";
    echo "<p>Verifique se:</p>";
    echo "<ul>";
    echo "<li>O banco de dados 'api_carros' existe</li>";
    echo "<li>A tabela 'users' foi criada</li>";
    echo "<li>As credenciais no arquivo system/Database.php estão corretas</li>";
    echo "</ul>";
}
?>
