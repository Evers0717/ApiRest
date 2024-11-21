<?php
class Database
{
    private $host = "ecommerce.mysql.database.azure.com";
    private $db_name = "ecommerce";
    private $username = "Fajardo";
    private $password = "Administr@tor";

    public $conn;

    public function getConnection()
    {
        // Inicializa la conexión
        $this->conn = mysqli_init();

        // Intenta conectar a la base de datos
        if (!mysqli_real_connect($this->conn, $this->host, $this->username, $this->password, $this->db_name, 3306)) {
            die('Error de conexión: ' . mysqli_connect_error());
        }

        // Retorna la conexión
        return $this->conn;
    }
}
