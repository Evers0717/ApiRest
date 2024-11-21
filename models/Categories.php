<?php

class Categories
{
    private $conn;
    public $id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function create($name)
    {
        $query = "INSERT INTO categories (name) VALUES ('$name')";
        return mysqli_query($this->conn, $query);
    }

    public function getAll()
    {
        $query = "SELECT * FROM categories";
        $result = mysqli_query($this->conn, $query);
        if (!$result) {

            die("Error en la consulta: " . mysqli_error($this->conn));
        }
        $categories = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
        return $categories;
    }
}
