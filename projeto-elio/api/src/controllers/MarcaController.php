
<?php

require_once 'api/src/models/MarcaModel.php';

class MarcaController
{
    private $marcaModel;

    public function __construct($db)
    {
        $this->marcaModel = new MarcaModel($db);
    }

    public function read()
    {
        $stmt = $this->marcaModel->read();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $marcas_arr = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $marc_item = [
                    "idMarca" => $idMarca,
                    "nomeMarca" => $nomeMarca
                ];
                array_push($marcas_arr, $marc_item);
            }
            http_response_code(200);
            echo json_encode($marcas_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Nenhuma marca encontrada."]);
        }
    }

    public function readOne($idMarca)
    {
        $this->marcaModel->idMarca = $idMarca;
        $this->marcaModel->readOne();

        if ($this->marcaModel->nomeMarca != null) {
            $marc_item = [
                "idMarca" => $this->marcaModel->idMarca,
                "nomeMarca" => $this->marcaModel->nomeMarca
            ];
            http_response_code(200);
            echo json_encode($marc_item);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Marca não encontrada."]);
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->nomeMarca)
        ) {
            $this->marcaModel->nomeMarca = $data->nomeMarca;

            if ($this->marcaModel->create()) {
                http_response_code(201);
                echo json_encode(["message" => "Marca criada com sucesso."]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Não foi possível criar a marca."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Não foi possível criar a marca. Dados incompletos."]);
        }
    }

    public function update($idMarca)
    {
        $data = json_decode(file_get_contents("php://input"));

        $this->marcaModel->idMarca = $idMarca;

        if (
            !empty($data->nomeMarca)
        ) {
            $this->marcaModel->nomeMarca = $data->nomeMarca;

            if ($this->marcaModel->update()) {
                http_response_code(200);
                echo json_encode(["message" => "Marca atualizada com sucesso."]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Não foi possível atualizar a marca."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Não foi possível atualizar a marca. Dados incompletos."]);
        }
    }

    public function delete($idMarca)
    {
        $this->marcaModel->idMarca = $idMarca;

        if ($this->marcaModel->delete()) {
            http_response_code(200);
            echo json_encode(["message" => "Marca deletada com sucesso."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Não foi possível deletar a marca."]);
        }
    }
}
