
<?php

class CarroDAO
{
    private $conn;
    private $table_name = "carros";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT c.idCarro, c.modelo, c.ano, c.idMarca, m.nomeMarca, c.idTipoCarro, t.nomeTipoCarro FROM " . $this->table_name . " c LEFT JOIN marcas m ON c.idMarca = m.idMarca LEFT JOIN tiposCarro t ON c.idTipoCarro = t.idTipoCarro ORDER BY c.modelo DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readOne($idCarro)
    {
        $query = "SELECT c.idCarro, c.modelo, c.ano, c.idMarca, m.nomeMarca, c.idTipoCarro, t.nomeTipoCarro FROM " . $this->table_name . " c LEFT JOIN marcas m ON c.idMarca = m.idMarca LEFT JOIN tiposCarro t ON c.idTipoCarro = t.idTipoCarro WHERE c.idCarro = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $idCarro);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($modelo, $ano, $idMarca, $idTipoCarro)
    {
        $query = "INSERT INTO " . $this->table_name . " SET modelo=:modelo, ano=:ano, idMarca=:idMarca, idTipoCarro=:idTipoCarro";
        $stmt = $this->conn->prepare($query);

        $modelo = htmlspecialchars(strip_tags($modelo));
        $ano = htmlspecialchars(strip_tags($ano));
        $idMarca = htmlspecialchars(strip_tags($idMarca));
        $idTipoCarro = htmlspecialchars(strip_tags($idTipoCarro));

        $stmt->bindParam(":modelo", $modelo);
        $stmt->bindParam(":ano", $ano);
        $stmt->bindParam(":idMarca", $idMarca);
        $stmt->bindParam(":idTipoCarro", $idTipoCarro);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update($idCarro, $modelo, $ano, $idMarca, $idTipoCarro)
    {
        $query = "UPDATE " . $this->table_name . " SET modelo = :modelo, ano = :ano, idMarca = :idMarca, idTipoCarro = :idTipoCarro WHERE idCarro = :idCarro";
        $stmt = $this->conn->prepare($query);

        $modelo = htmlspecialchars(strip_tags($modelo));
        $ano = htmlspecialchars(strip_tags($ano));
        $idMarca = htmlspecialchars(strip_tags($idMarca));
        $idTipoCarro = htmlspecialchars(strip_tags($idTipoCarro));
        $idCarro = htmlspecialchars(strip_tags($idCarro));

        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':idMarca', $idMarca);
        $stmt->bindParam(':idTipoCarro', $idTipoCarro);
        $stmt->bindParam(':idCarro', $idCarro);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete($idCarro)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE idCarro = ?";
        $stmt = $this->conn->prepare($query);

        $idCarro = htmlspecialchars(strip_tags($idCarro));

        $stmt->bindParam(1, $idCarro);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
