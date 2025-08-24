
<?php

require_once 'api/src/models/TipoCarroModel.php';

class TipoCarroController
{
    private $tipoCarroModel;

    public function __construct($db)
    {
        $this->tipoCarroModel = new TipoCarroModel($db);
    }

    public function read()
    {
        $stmt = $this->tipoCarroModel->read();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $tiposCarro_arr = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $tipoCarro_item = [
                    "idTipoCarro" => $idTipoCarro,
                    "nomeTipoCarro" => $nomeTipoCarro
                ];
                array_push($tiposCarro_arr, $tipoCarro_item);
            }
            http_response_code(200);
            echo json_encode($tiposCarro_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Nenhum tipo de carro encontrado."]);
        }
    }

    public function readOne($idTipoCarro)
    {
        $this->tipoCarroModel->idTipoCarro = $idTipoCarro;
        $this->tipoCarroModel->readOne();

        if ($this->tipoCarroModel->nomeTipoCarro != null) {
            $tipoCarro_item = [
                "idTipoCarro" => $this->tipoCarroModel->idTipoCarro,
                "nomeTipoCarro" => $this->tipoCarroModel->nomeTipoCarro
            ];
            http_response_code(200);
            echo json_encode($tipoCarro_item);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Tipo de carro não encontrado."]);
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->nomeTipoCarro)
        ) {
            $this->tipoCarroModel->nomeTipoCarro = $data->nomeTipoCarro;

            if ($this->tipoCarroModel->create()) {
                http_response_code(201);
                echo json_encode(["message" => "Tipo de carro criado com sucesso."]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Não foi possível criar o tipo de carro."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Não foi possível criar o tipo de carro. Dados incompletos."]);
        }
    }

    public function update($idTipoCarro)
    {
        $data = json_decode(file_get_contents("php://input"));

        $this->tipoCarroModel->idTipoCarro = $idTipoCarro;

        if (
            !empty($data->nomeTipoCarro)
        ) {
            $this->tipoCarroModel->nomeTipoCarro = $data->nomeTipoCarro;

            if ($this->tipoCarroModel->update()) {
                http_response_code(200);
                echo json_encode(["message" => "Tipo de carro atualizado com sucesso."]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Não foi possível atualizar o tipo de carro."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Não foi possível atualizar o tipo de carro. Dados incompletos."]);
        }
    }

    public function delete($idTipoCarro)
    {
        $this->tipoCarroModel->idTipoCarro = $idTipoCarro;

        if ($this->tipoCarroModel->delete()) {
            http_response_code(200);
            echo json_encode(["message" => "Tipo de carro deletado com sucesso."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Não foi possível deletar o tipo de carro."]);
        }
    }
}
