<?php

require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../../vendor/autoload.php'; // Para JWT

use Firebase\JWT\JWT;

class UserController {
    private $userDAO;
    private $secretKey = "SUA_CHAVE_SECRETA_MUITO_FORTE_AQUI_PARA_SEGURANCA"; // Mude para uma chave segura e complexa

    public function __construct() {
        $this->userDAO = new UserDAO();
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->username) || !isset($data->password)) {
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos."));
            return;
        }

        $username = $data->username;
        $password = $data->password;

        $user = $this->userDAO->findByUsername($username);

        if ($user && password_verify($password, $user->getPassword())) {
            $tokenId    = base64_encode(random_bytes(16));
            $issuedAt   = new DateTimeImmutable();
            $expire     = $issuedAt->modify('+60 minutes')->getTimestamp(); // Token válido por 60 minutos
            $serverName = "your.domain.name"; // Substitua pelo seu domínio

            $data = [
                'iat'  => $issuedAt->getTimestamp(),         // Issued at: time when the token was generated
                'jti'  => $tokenId,                          // Json Token Id: an unique identifier for the token
                'iss'  => $serverName,                       // Issuer
                'nbf'  => $issuedAt->getTimestamp(),         // Not before
                'exp'  => $expire,                           // Expire
                'data' => [
                    'userId'   => $user->getId(),
                    'username' => $user->getUsername(),
                ]
            ];

            $jwt = JWT::encode(
                $data,
                $this->secretKey,
                'HS256'
            );

            http_response_code(200);
            echo json_encode(array(
                "message" => "Login realizado com sucesso.",
                "jwt" => $jwt
            ));
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Usuário ou senha inválidos."));
        }
    }

    public function register() {
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->username) || !isset($data->password)) {
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos."));
            return;
        }

        $username = $data->username;
        $password = $data->password;

        if ($this->userDAO->findByUsername($username)) {
            http_response_code(409); // Conflict
            echo json_encode(array("message" => "Usuário já existe."));
            return;
        }

        if ($this->userDAO->createUser($username, $password)) {
            http_response_code(201); // Created
            echo json_encode(array("message" => "Usuário registrado com sucesso."));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array("message" => "Não foi possível registrar o usuário."));
        }
    }
}
