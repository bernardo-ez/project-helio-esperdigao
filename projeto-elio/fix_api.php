<?php
// API simplificada para login
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Verificar se é uma requisição POST para login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/login') {
    
    // Pegar dados do POST
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        http_response_code(400);
        echo json_encode(['error' => 'Dados inválidos']);
        exit;
    }
    
    $username = $input['username'] ?? '';
    $password = $input['password'] ?? '';
    
    // Conectar ao banco
    try {
        require_once 'system/Database.php';
        $database = new Database();
        $db = $database->getConnection();
        
        // Verificar usuário
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Login bem-sucedido
            require_once 'vendor/autoload.php';
            
            $payload = [
                'iat' => time(),
                'exp' => time() + 3600,
                'data' => [
                    'userId' => $user['id'],
                    'username' => $user['username']
                ]
            ];
            
            $jwt = Firebase\JWT\JWT::encode($payload, 'SUA_CHAVE_SECRETA_MUITO_FORTE_AQUI_PARA_SEGURANCA');
            
            echo json_encode([
                'success' => true,
                'token' => $jwt,
                'message' => 'Login realizado com sucesso'
            ]);
        } else {
            // Login falhou
            http_response_code(401);
            echo json_encode([
                'error' => 'Usuário ou senha inválidos'
            ]);
        }
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Erro interno: ' . $e->getMessage()
        ]);
    }
    
} else {
    // Rota não encontrada
    http_response_code(404);
    echo json_encode(['error' => 'Rota não encontrada']);
}
?>
