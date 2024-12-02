<?php

class Provider
{

    private $conn;
    public $id;
    public $name;

    public $password;


    public $desc;
    public $email;
    public $cellphone;



    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function create($name, $password, $desc, $cellphone)
    {
        $email = $name . "Provedor@gmail.com";
        $query = "INSERT INTO provider (name,password, `desc`,email,cellphone) VALUES ('$name', '$password', '$desc','$email','$cellphone')";
        return mysqli_query($this->conn, $query);
    }
    public function login($email, $password)
    {
        $query = "SELECT * FROM provider WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($this->conn, $query);

        return mysqli_fetch_assoc($result);
    }

    public function getAll()
    {
        $query = "SELECT * FROM provider";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        $providers = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $providers[] = $row;
        }

        return $providers;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM provider WHERE idProvider = $id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        return mysqli_fetch_assoc($result);
    }

    public function update($id, $name, $password, $desc, $cellphone)
    {
        $query = "UPDATE provider SET name = '$name', password = '$password', `desc` = '$desc', cellphone = '$cellphone' WHERE idProvider = $id";
        return mysqli_query($this->conn, $query);
    }
}
