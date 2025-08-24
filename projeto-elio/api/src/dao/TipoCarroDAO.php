
<?php

class TipoCarroDAO
{
    private $conn;
    private $table_name = "tiposCarro";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT idTipoCarro, nomeTipoCarro FROM " . $this->table_name . " ORDER BY nomeTipoCarro DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readOne($idTipoCarro)
    {
        $query = "SELECT idTipoCarro, nomeTipoCarro FROM " . $this->table_name . " WHERE idTipoCarro = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $idTipoCarro);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nomeTipoCarro)
    {
        $query = "INSERT INTO " . $this->table_name . " SET nomeTipoCarro=:nomeTipoCarro";
        $stmt = $this->conn->prepare($query);

        $nomeTipoCarro = htmlspecialchars(strip_tags($nomeTipoCarro));

        $stmt->bindParam(":nomeTipoCarro", $nomeTipoCarro);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update($idTipoCarro, $nomeTipoCarro)
    {
        $query = "UPDATE " . $this->table_name . " SET nomeTipoCarro = :nomeTipoCarro WHERE idTipoCarro = :idTipoCarro";
        $stmt = $this->conn->prepare($query);

        $nomeTipoCarro = htmlspecialchars(strip_tags($nomeTipoCarro));
        $idTipoCarro = htmlspecialchars(strip_tags($idTipoCarro));

        $stmt->bindParam(':nomeTipoCarro', $nomeTipoCarro);
        $stmt->bindParam(':idTipoCarro', $idTipoCarro);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete($idTipoCarro)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE idTipoCarro = ?";
        $stmt = $this->conn->prepare($query);

        $idTipoCarro = htmlspecialchars(strip_tags($idTipoCarro));

        $stmt->bindParam(1, $idTipoCarro);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
