
<?php

require_once 'api/src/models/CarroModel.php';

class CarroController
{
    private $carroModel;

    public function __construct($db)
    {
        $this->carroModel = new CarroModel($db);
    }

    public function read()
    {
        $stmt = $this->carroModel->read();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $carros_arr = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $carro_item = [
                    "idCarro" => $idCarro,
                    "modelo" => $modelo,
                    "ano" => $ano,
                    "idMarca" => $idMarca,
                    "nomeMarca" => $nomeMarca,
                    "idTipoCarro" => $idTipoCarro,
                    "nomeTipoCarro" => $nomeTipoCarro
                ];
                array_push($carros_arr, $carro_item);
            }
            http_response_code(200);
            echo json_encode($carros_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Nenhum carro encontrado."]);
        }
    }

    public function readOne($idCarro)
    {
        $this->carroModel->idCarro = $idCarro;
        $this->carroModel->readOne();

        if ($this->carroModel->modelo != null) {
            $carro_item = [
                "idCarro" => $this->carroModel->idCarro,
                "modelo" => $this->carroModel->modelo,
                "ano" => $this->carroModel->ano,
                "idMarca" => $this->carroModel->idMarca,
                "idTipoCarro" => $this->carroModel->idTipoCarro
            ];
            http_response_code(200);
            echo json_encode($carro_item);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Carro não encontrado."]);
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->modelo) &&
            !empty($data->ano) &&
            !empty($data->idMarca) &&
            !empty($data->idTipoCarro)
        ) {
            $this->carroModel->modelo = $data->modelo;
            $this->carroModel->ano = $data->ano;
            $this->carroModel->idMarca = $data->idMarca;
            $this->carroModel->idTipoCarro = $data->idTipoCarro;

            if ($this->carroModel->create()) {
                http_response_code(201);
                echo json_encode(["message" => "Carro criado com sucesso."]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Não foi possível criar o carro."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Não foi possível criar o carro. Dados incompletos."]);
        }
    }

    public function update($idCarro)
    {
        $data = json_decode(file_get_contents("php://input"));

        $this->carroModel->idCarro = $idCarro;

        if (
            !empty($data->modelo) &&
            !empty($data->ano) &&
            !empty($data->idMarca) &&
            !empty($data->idTipoCarro)
        ) {
            $this->carroModel->modelo = $data->modelo;
            $this->carroModel->ano = $data->ano;
            $this->carroModel->idMarca = $data->idMarca;
            $this->carroModel->idTipoCarro = $data->idTipoCarro;

            if ($this->carroModel->update()) {
                http_response_code(200);
                echo json_encode(["message" => "Carro atualizado com sucesso."]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Não foi possível atualizar o carro."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Não foi possível atualizar o carro. Dados incompletos."]);
        }
    }

    public function delete($idCarro)
    {
        $this->carroModel->idCarro = $idCarro;

        if ($this->carroModel->delete()) {
            http_response_code(200);
            echo json_encode(["message" => "Carro deletado com sucesso."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Não foi possível deletar o carro."]);
        }
    }
}
