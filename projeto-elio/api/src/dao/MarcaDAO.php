
<?php

class MarcaDAO
{
    private $conn;
    private $table_name = "marcas";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT idMarca, nomeMarca FROM " . $this->table_name . " ORDER BY nomeMarca DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readOne($idMarca)
    {
        $query = "SELECT idMarca, nomeMarca FROM " . $this->table_name . " WHERE idMarca = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $idMarca);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nomeMarca)
    {
        $query = "INSERT INTO " . $this->table_name . " SET nomeMarca=:nomeMarca";
        $stmt = $this->conn->prepare($query);

        $nomeMarca = htmlspecialchars(strip_tags($nomeMarca));

        $stmt->bindParam(":nomeMarca", $nomeMarca);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update($idMarca, $nomeMarca)
    {
        $query = "UPDATE " . $this->table_name . " SET nomeMarca = :nomeMarca WHERE idMarca = :idMarca";
        $stmt = $this->conn->prepare($query);

        $nomeMarca = htmlspecialchars(strip_tags($nomeMarca));
        $idMarca = htmlspecialchars(strip_tags($idMarca));

        $stmt->bindParam(':nomeMarca', $nomeMarca);
        $stmt->bindParam(':idMarca', $idMarca);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete($idMarca)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE idMarca = ?";
        $stmt = $this->conn->prepare($query);

        $idMarca = htmlspecialchars(strip_tags($idMarca));

        $stmt->bindParam(1, $idMarca);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
