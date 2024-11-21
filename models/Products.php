<?php

class Products
{

    private $conn;
    public $id;
    public $name;
    public $code;
    public $stock;

    public $provider;
    public $categoryId;

    public $genre;

    public $price;

    public $description;

    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = "SELECT * FROM products";
        $result = mysqli_query($this->conn, $query);


        if (!$result) {

            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }

        return $products;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM products WHERE id = $id";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result);
    }

    public function create($name, $code, $stock, $provider, $categoryId, $genre, $price, $description)
    {
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO products (name, code, stock, provider, categoryId, genre, price, description, created_at) VALUES ('$name', '$code', $stock, '$provider', $categoryId, '$genre', $price, '$description', '$date')";
        return mysqli_query($this->conn, $query);
    }

    public function getByGenre($genre)
    {
        $query = "SELECT * FROM products WHERE genre = '$genre'";
        $result = mysqli_query($this->conn, $query);
        if (!$result) {

            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }

        return $products;
    }

    public function getByProvider($provider)
    {
        $query = "SELECT * FROM products WHERE provider = '$provider'";
        $result = mysqli_query($this->conn, $query);
        if (!$result) {

            die("Error en la consulta: " . mysqli_error($this->conn));
        }

        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }

        return $products;
    }
}
