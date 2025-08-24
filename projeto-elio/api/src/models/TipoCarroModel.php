
<?php

require_once 'api/src/dao/TipoCarroDAO.php';

class TipoCarroModel
{
    private $tipoCarroDAO;

    public $idTipoCarro;
    public $nomeTipoCarro;

    public function __construct($db)
    {
        $this->tipoCarroDAO = new TipoCarroDAO($db);
    }

    public function read()
    {
        return $this->tipoCarroDAO->read();
    }

    public function readOne()
    {
        $row = $this->tipoCarroDAO->readOne($this->idTipoCarro);

        if ($row) {
            $this->nomeTipoCarro = $row['nomeTipoCarro'];
            return true;
        }
        return false;
    }

    public function create()
    {
        return $this->tipoCarroDAO->create($this->nomeTipoCarro);
    }

    public function update()
    {
        return $this->tipoCarroDAO->update($this->idTipoCarro, $this->nomeTipoCarro);
    }

    public function delete()
    {
        return $this->tipoCarroDAO->delete($this->idTipoCarro);
    }
}
