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

        $query = "
        SELECT 
            cart.idcart,
            cart.user_id,
            cart.product_id,
            cart.quantity,
            cart.created_at,
            products.name AS product_name,
            products.price AS product_price,
            products.image_url AS product_image
        FROM 
            cart
        INNER JOIN 
            products 
        ON 
            cart.product_id = products.idProducts
        WHERE 
            cart.user_id = ?";

        if ($stmt = $this->conn->prepare($query)) {

            $stmt->bind_param("i", $user_id);

            $stmt->execute();


            $result = $stmt->get_result();
            $cartItems = $result->fetch_all(MYSQLI_ASSOC);


            $stmt->close();

            return $cartItems;
        } else {

            return ["error" => "Error al ejecutar la consulta"];
        }
    }
}
