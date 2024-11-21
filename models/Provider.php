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


    public function create($name, $password, $desc, $email, $cellphone)
    {
        $query = "INSERT INTO provider (name,password, `desc`,email,cellphone) VALUES ('$name', '$password', '$desc','$email','$cellphone')";
        return mysqli_query($this->conn, $query);
    }

    public function login($email, $password)
    {
        $query = "SELECT * FROM provider WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        return mysqli_fetch_assoc($result);
    }
}
