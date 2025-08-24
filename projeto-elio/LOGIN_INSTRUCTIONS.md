# 🔐 Instruções de Login - Projeto Elio

## 📋 Como criar os usuários

### Opção 1: Via phpMyAdmin (Recomendado)
1. Abra o **phpMyAdmin** no seu navegador
2. Acesse o banco de dados `api_carros`
3. Vá na aba **SQL**
4. Execute o script: `db/insert_users.sql`

### Opção 2: Via linha de comando MySQL
```bash
mysql -u root -p api_carros < db/insert_users.sql
```

### Opção 3: Via script PHP
```bash
php create_users.php
```

## 👥 Usuários criados

| Usuário | Senha | Descrição |
|---------|-------|-----------|
| `admin` | `admin123` | Administrador |
| `user` | `user123` | Usuário padrão |
| `test` | `test123` | Usuário de teste |
| `elio` | `elio123` | Usuário Elio |
| `porsche` | `porsche123` | Usuário Porsche |
| `ferrari` | `ferrari123` | Usuário Ferrari |
| `lamborghini` | `lamborghini123` | Usuário Lamborghini |

## 🌐 Como fazer login

1. Acesse: `http://localhost/projeto-elio/public/index.html`
2. Use qualquer uma das credenciais acima
3. Clique em "Entrar"
4. Você será redirecionado para o dashboard

## 🔧 Se não funcionar

### Verificar banco de dados:
```sql
-- Verificar se a tabela users existe
SHOW TABLES;

-- Verificar se há usuários
SELECT * FROM users;

-- Se não houver usuários, execute:
INSERT INTO users (username, password) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
```

### Verificar configuração do banco:
- Arquivo: `system/Database.php`
- Verifique se as credenciais estão corretas:
  - host: 'localhost'
  - db_name: 'api_carros'
  - username: 'root'
  - password: '' (ou sua senha)

## 🎯 Teste rápido

Use estas credenciais para teste:
- **Usuário:** `admin`
- **Senha:** `admin123`

---

**🎉 Pronto! Agora você pode fazer login no sistema!**
