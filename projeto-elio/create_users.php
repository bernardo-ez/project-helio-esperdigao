<?php
require_once 'system/Database.php';

$database = new Database();
$db = $database->getConnection();

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

echo "Criando usuários...\n";

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
        echo "Usuário '$username' já existe. Pulando...\n";
        continue;
    }
    
    // Inserir novo usuário
    $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    
    if ($stmt->execute()) {
        echo "✅ Usuário '$username' criado com sucesso!\n";
    } else {
        echo "❌ Erro ao criar usuário '$username'\n";
    }
}

echo "\n🎉 Processo concluído!\n";
echo "\n📋 Credenciais para login:\n";
echo "========================\n";
foreach ($users as $user) {
    echo "👤 Usuário: {$user['username']} | 🔑 Senha: {$user['password']}\n";
}
echo "\n🌐 Acesse: http://localhost/projeto-elio/public/index.html\n";
?>
