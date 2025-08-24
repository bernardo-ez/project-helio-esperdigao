
<?php

require_once __DIR__ . '/../../vendor/autoload.php'; // Para JWT

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware
{
    private $secretKey = "SUA_CHAVE_SECRETA_MUITO_FORTE_AQUI_PARA_SEGURANCA"; // Mude para a mesma chave segura e complexa do UserController

    public function handle(callable $next)
    {
        $headers = getallheaders();
        $token = null;

        if (isset($headers['Authorization']) && strpos($headers['Authorization'], 'Bearer ') !== false) {
            $token = substr($headers['Authorization'], 7);
        }

        if (!$token) {
            http_response_code(401);
            echo json_encode(["message" => "Token de autenticação não fornecido."]);
            return;
        }

        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            // O token é válido. Agora podemos passar os dados do usuário para a próxima camada, se necessário.
            // Por exemplo, você pode armazenar $decoded->data em um objeto Request global ou em uma sessão.

            // Chamar o próximo middleware ou a função da rota
            $next();
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(["message" => "Token de autenticação inválido: " . $e->getMessage()]);
            return;
        }
    }
}
