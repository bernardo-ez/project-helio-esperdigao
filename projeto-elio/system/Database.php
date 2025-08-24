
<?php

class Database
{
    private $host = 'localhost';
    private $db_name = 'api_carros';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            http_response_code(500);
            echo json_encode(["message" => "Erro de conexão com o banco de dados: " . $exception->getMessage()]);
            exit();
        }

        return $this->conn;
    }
}
