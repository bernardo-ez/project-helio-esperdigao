
<?php

require_once 'api/src/dao/MarcaDAO.php';

class MarcaModel
{
    private $marcaDAO;

    public $idMarca;
    public $nomeMarca;

    public function __construct($db)
    {
        $this->marcaDAO = new MarcaDAO($db);
    }

    public function read()
    {
        return $this->marcaDAO->read();
    }

    public function readOne()
    {
        $row = $this->marcaDAO->readOne($this->idMarca);

        if ($row) {
            $this->nomeMarca = $row['nomeMarca'];
            return true;
        }
        return false;
    }

    public function create()
    {
        return $this->marcaDAO->create($this->nomeMarca);
    }

    public function update()
    {
        return $this->marcaDAO->update($this->idMarca, $this->nomeMarca);
    }

    public function delete()
    {
        return $this->marcaDAO->delete($this->idMarca);
    }
}
