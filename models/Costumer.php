<?php
class Costumer
{
    private $conn;
    public $id;
    public $name;
    public $password;
    public $email;
    public $cellphone;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = "SELECT * FROM costumer";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {

            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        $costumers = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $costumers[] = $row;
        }

        return $costumers;
    }


    public function getById($id)
    {
        $query = "SELECT * FROM costumer WHERE id = $id";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result);
    }


    public function create($name, $password, $email, $cellphone)
    {
        $query = "INSERT INTO costumer (name,password, email,cellphone) VALUES ('$name', '$password', '$email','$cellphone')";
        return mysqli_query($this->conn, $query);
    }

    public function login($email, $password)
    {
        $query = "SELECT * FROM costumer WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result);
    }
}
