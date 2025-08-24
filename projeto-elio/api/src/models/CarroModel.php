
<?php

require_once 'api/src/dao/CarroDAO.php';

class CarroModel
{
    private $carroDAO;

    public $idCarro;
    public $modelo;
    public $ano;
    public $idMarca;
    public $idTipoCarro;

    public function __construct($db)
    {
        $this->carroDAO = new CarroDAO($db);
    }

    public function read()
    {
        return $this->carroDAO->read();
    }

    public function readOne()
    {
        $row = $this->carroDAO->readOne($this->idCarro);

        if ($row) {
            $this->modelo = $row['modelo'];
            $this->ano = $row['ano'];
            $this->idMarca = $row['idMarca'];
            $this->idTipoCarro = $row['idTipoCarro'];
            return true;
        }

        return false;
    }

    public function create()
    {
        return $this->carroDAO->create($this->modelo, $this->ano, $this->idMarca, $this->idTipoCarro);
    }

    public function update()
    {
        return $this->carroDAO->update($this->idCarro, $this->modelo, $this->ano, $this->idMarca, $this->idTipoCarro);
    }

    public function delete()
    {
        return $this->carroDAO->delete($this->idCarro);
    }
}
