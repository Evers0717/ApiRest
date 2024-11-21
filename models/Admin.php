<?php

class Admin
{

    private $conn;
    public $id;

    public $user;

    public $password;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($user, $password)
    {
        $query = "SELECT * FROM admin WHERE user = '$user' AND password = '$password'";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result);
    }

    public function create($user, $password)
    {
        $query = "INSERT INTO admin (user, password) VALUES ('$user', '$password')";
        return mysqli_query($this->conn, $query);
    }
}
