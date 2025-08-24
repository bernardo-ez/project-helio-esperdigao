# 🔐 Como Criar os Usuários - Passo a Passo

## 🚀 **Método Mais Fácil:**

### 1. Iniciar o XAMPP
- Abra o **XAMPP Control Panel**
- Clique em **Start** no Apache
- Clique em **Start** no MySQL

### 2. Abrir phpMyAdmin
- Abra o navegador
- Acesse: `http://localhost/phpmyadmin`

### 3. Executar o Script SQL
- Clique no banco `api_carros` (à esquerda)
- Clique na aba **SQL** (no topo)
- Copie e cole o conteúdo do arquivo `db/create_users_simple.sql`
- Clique em **Executar**

### 4. Verificar se funcionou
- Você deve ver uma tabela com os usuários criados
- Se aparecer erro, verifique se o banco `api_carros` existe

## 📋 **Usuários que serão criados:**

| Usuário | Senha |
|---------|-------|
| `admin` | `admin123` |
| `user` | `user123` |
| `test` | `test123` |
| `elio` | `elio123` |
| `porsche` | `porsche123` |
| `ferrari` | `ferrari123` |
| `lamborghini` | `lamborghini123` |

## 🎯 **Depois de criar os usuários:**

1. Acesse: `http://localhost/projeto-elio/public/index.html`
2. Use: **admin** / **admin123**
3. Clique em "Entrar"

## 🔧 **Se der erro:**

- Verifique se o XAMPP está rodando
- Verifique se o banco `api_carros` existe
- Verifique se a tabela `users` foi criada pelo `schema.sql`

---

**🎉 Pronto! Agora você pode fazer login!**
