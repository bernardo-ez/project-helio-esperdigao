<?php
// Script para criar usuários diretamente no banco
// Executando via linha de comando

echo "🔐 Criando usuários no banco de dados...\n";

try {
    // Configuração do banco
    $host = 'localhost';
    $dbname = 'api_carros';
    $username = 'root';
    $password = '';
    
    // Conectar ao banco
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conexão com banco estabelecida!\n";
    
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
    
    echo "📋 Criando usuários...\n";
    
    foreach ($users as $user) {
        $username = $user['username'];
        $password = $user['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Verificar se o usuário já existe
        $check_stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $check_stmt->execute([$username]);
        
        if ($check_stmt->fetch()) {
            echo "⚠️  Usuário '$username' já existe. Pulando...\n";
            continue;
        }
        
        // Inserir novo usuário
        $insert_stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        
        if ($insert_stmt->execute([$username, $hashed_password])) {
            echo "✅ Usuário '$username' criado com sucesso!\n";
        } else {
            echo "❌ Erro ao criar usuário '$username'\n";
        }
    }
    
    // Verificar quantos usuários foram criados
    $count_stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $total_users = $count_stmt->fetchColumn();
    
    echo "\n🎉 Processo concluído!\n";
    echo "📊 Total de usuários no banco: $total_users\n";
    echo "\n📋 Credenciais para login:\n";
    echo "========================\n";
    
    foreach ($users as $user) {
        echo "👤 Usuário: {$user['username']} | 🔑 Senha: {$user['password']}\n";
    }
    
    echo "\n🌐 Acesse: http://localhost/projeto-elio/public/index.html\n";
    echo "🎯 Recomendado: admin / admin123\n";
    
} catch (PDOException $e) {
    echo "❌ Erro de banco de dados: " . $e->getMessage() . "\n";
    echo "Verifique se:\n";
    echo "- O banco 'api_carros' existe\n";
    echo "- A tabela 'users' foi criada\n";
    echo "- As credenciais estão corretas\n";
} catch (Exception $e) {
    echo "❌ Erro geral: " . $e->getMessage() . "\n";
}
?>
