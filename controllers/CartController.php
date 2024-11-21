<?php

require_once 'models/Cart.php';

class CartController
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $cart = new Cart($this->db->getConnection());
        $result = $cart->create($data['user_id'], $data['product_id'], $data['quantity']);
        if ($result) {
            echo json_encode(["message" => "Cart created successfully"]);
        } else {
            echo json_encode(["message" => "Failed to create cart"]);
        }
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $cart = new Cart($this->db->getConnection());
        $result = $cart->delete($data['user_id'], $data['product_id']);
        if ($result) {
            echo json_encode(["message" => "Item FromCart deleted successfully"]);
        } else {
            echo json_encode(["message" => "Failed to delete cart"]);
        }
    }


    public function getByUser($user_id)
    {
        $cart = new Cart($this->db->getConnection());
        $result = $cart->getByUser($user_id);
        echo json_encode($result);
    }
}
