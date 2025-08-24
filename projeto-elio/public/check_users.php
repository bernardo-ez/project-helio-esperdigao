<?php
// Script para verificar se os usuários existem
// Acesse: http://localhost/projeto-elio/public/check_users.php

require_once '../system/Database.php';

echo "<h1>🔍 Verificando Usuários - Projeto Elio</h1>";

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "<p>✅ Conexão com banco de dados estabelecida!</p>";
    
    // Verificar se há usuários na tabela
    $query = "SELECT COUNT(*) as total FROM users";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $total_users = $result['total'];
    
    echo "<h2>📊 Status dos Usuários:</h2>";
    echo "<p>Total de usuários no banco: <strong>$total_users</strong></p>";
    
    if ($total_users > 0) {
        echo "<p>✅ <strong>Usuários já existem!</strong> Você pode fazer login agora.</p>";
        
        // Listar usuários existentes
        $list_query = "SELECT username FROM users";
        $list_stmt = $db->prepare($list_query);
        $list_stmt->execute();
        
        echo "<h3>👥 Usuários disponíveis:</h3>";
        echo "<ul>";
        while ($user = $list_stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li><strong>{$user['username']}</strong></li>";
        }
        echo "</ul>";
        
        echo "<h3>🎯 Credenciais para teste:</h3>";
        echo "<p><strong>Usuário:</strong> admin | <strong>Senha:</strong> admin123</p>";
        echo "<p><a href='index.html' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Ir para Login</a></p>";
        
    } else {
        echo "<p>❌ <strong>Nenhum usuário encontrado!</strong> Precisa criar os usuários primeiro.</p>";
        echo "<p><a href='create_users_web.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔐 Criar Usuários</a></p>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Erro: " . $e->getMessage() . "</p>";
    echo "<p>Verifique se o banco de dados está configurado corretamente.</p>";
}
?>
