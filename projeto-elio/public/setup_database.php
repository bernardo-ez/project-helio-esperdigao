<?php
// Script para criar banco de dados e tabelas
// Acesse: http://localhost/projeto-elio/public/setup_database.php

echo "<h1>🗄️ Configurando Banco de Dados - Projeto Elio</h1>";

try {
    // Conectar sem especificar banco
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p>✅ Conexão com MySQL estabelecida!</p>";
    
    // Criar banco de dados
    $pdo->exec("CREATE DATABASE IF NOT EXISTS api_carros");
    echo "<p>✅ Banco 'api_carros' criado!</p>";
    
    // Selecionar o banco
    $pdo->exec("USE api_carros");
    
    // Criar tabela users
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id int(11) NOT NULL AUTO_INCREMENT,
        username varchar(255) NOT NULL UNIQUE,
        password varchar(255) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "<p>✅ Tabela 'users' criada!</p>";
    
    // Criar tabela marcas
    $pdo->exec("CREATE TABLE IF NOT EXISTS marcas (
        idMarca int(11) NOT NULL AUTO_INCREMENT,
        nomeMarca varchar(255) NOT NULL,
        PRIMARY KEY (idMarca)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "<p>✅ Tabela 'marcas' criada!</p>";
    
    // Criar tabela tiposCarro
    $pdo->exec("CREATE TABLE IF NOT EXISTS tiposCarro (
        idTipoCarro int(11) NOT NULL AUTO_INCREMENT,
        nomeTipoCarro varchar(255) NOT NULL,
        PRIMARY KEY (idTipoCarro)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "<p>✅ Tabela 'tiposCarro' criada!</p>";
    
    // Criar tabela carros
    $pdo->exec("CREATE TABLE IF NOT EXISTS carros (
        idCarro int(11) NOT NULL AUTO_INCREMENT,
        modelo varchar(255) NOT NULL,
        ano int(11) NOT NULL,
        idMarca int(11) NOT NULL,
        idTipoCarro int(11) NOT NULL,
        PRIMARY KEY (idCarro),
        FOREIGN KEY (idMarca) REFERENCES marcas(idMarca) ON DELETE CASCADE,
        FOREIGN KEY (idTipoCarro) REFERENCES tiposCarro(idTipoCarro)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "<p>✅ Tabela 'carros' criada!</p>";
    
    // Inserir dados iniciais
    $pdo->exec("INSERT IGNORE INTO marcas (idMarca, nomeMarca) VALUES 
        (1, 'Porsche'), (2, 'Ferrari'), (3, 'Lamborghini')");
    echo "<p>✅ Dados iniciais das marcas inseridos!</p>";
    
    $pdo->exec("INSERT IGNORE INTO tiposCarro (idTipoCarro, nomeTipoCarro) VALUES 
        (1, 'Esportivo'), (2, 'SUV'), (3, 'Sedan')");
    echo "<p>✅ Dados iniciais dos tipos de carro inseridos!</p>";
    
    $pdo->exec("INSERT IGNORE INTO carros (idCarro, modelo, ano, idMarca, idTipoCarro) VALUES 
        (1, '911 Carrera', 2023, 1, 1),
        (2, 'F8 Tributo', 2022, 2, 1),
        (3, 'Huracan EVO', 2024, 3, 1)");
    echo "<p>✅ Dados iniciais dos carros inseridos!</p>";
    
    // Criar usuários
    $users = [
        ['username' => 'admin', 'password' => 'admin123'],
        ['username' => 'user', 'password' => 'user123'],
        ['username' => 'test', 'password' => 'test123'],
        ['username' => 'elio', 'password' => 'elio123'],
        ['username' => 'porsche', 'password' => 'porsche123'],
        ['username' => 'ferrari', 'password' => 'ferrari123'],
        ['username' => 'lamborghini', 'password' => 'lamborghini123']
    ];
    
    foreach ($users as $user) {
        $username = $user['username'];
        $password = $user['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT IGNORE INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashed_password]);
    }
    echo "<p>✅ Usuários criados!</p>";
    
    echo "<h2>🎉 Banco de dados configurado com sucesso!</h2>";
    echo "<p><a href='index.html' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Ir para Login</a></p>";
    
} catch (Exception $e) {
    echo "<p>❌ Erro: " . $e->getMessage() . "</p>";
}
?>
