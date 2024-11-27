<?php

class Address
{
    private $conn;
    public $id;
    public $user_id;
    public $name_address;
    public $city;

    public $country;
    public $isActive;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getByUser($user_id)
    {
        $query = "SELECT * FROM adress WHERE user_id = $user_id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {

            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        $addresses = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $addresses[] = $row;
        }

        return $addresses;
    }

    public function getActiveAddress($user_id)
    {
        $query = "SELECT * FROM adress WHERE user_id = $user_id AND isActive = 1";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {

            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        return mysqli_fetch_assoc($result);
    }

    public function create($user_id, $name_address, $city, $country)
    {
        $checkQuery = "SELECT * FROM adress WHERE user_id = $user_id";
        $checkResult = mysqli_query($this->conn, $checkQuery);

        // Si no existe dirección, la nueva será activa (isActive = 1)
        $isActive = mysqli_num_rows($checkResult) === 0 ? 1 : 0;

        $query = "INSERT INTO adress (user_id, name_address, city, country, isActive) 
                  VALUES ('$user_id', '$name_address', '$city', '$country', '$isActive')";
        return mysqli_query($this->conn, $query);
    }

    public function makeActive($address_id, $user_id)
    {
        $query = "UPDATE adress SET isActive = 0 WHERE user_id = $user_id";
        mysqli_query($this->conn, $query);

        $query = "UPDATE adress SET isActive = 1 WHERE idAdress = $address_id";
        return mysqli_query($this->conn, $query);

    }
}
