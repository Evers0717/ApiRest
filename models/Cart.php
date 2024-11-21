<?php

class Cart
{

    private $conn;
    public $id;

    public $user_id;
    public $product_id;
    public $quantity;
    public $created_at;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($user_id, $product_id, $quantity)
    {
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO cart (user_id, product_id, quantity, created_at) VALUES ($user_id, $product_id, $quantity, '$date')";
        return mysqli_query($this->conn, $query);
    }

    public function delete($user_id, $product_id)
    {
        $query = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id";
        return mysqli_query($this->conn, $query);
    }

    public function getByUser($user_id)
    {
        $query = "SELECT * FROM cart WHERE user_id = $user_id";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
