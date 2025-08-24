
<?php

class TipoCarroMiddleware
{
    public function handle($callback)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // Aplica validações apenas para POST e PUT
        if ($method === 'POST' || $method === 'PUT') {
            $data = json_decode(file_get_contents("php://input"));

            if (empty($data->nomeTipoCarro)) {
                http_response_code(400);
                echo json_encode(["message" => "O nome do tipo de carro não pode ser vazio."]);
                return null;
            }
            // Adicione outras validações para TipoCarro aqui, se necessário.
        }

        return call_user_func($callback);
    }
}
