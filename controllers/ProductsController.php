<?php
require_once 'models/Products.php';
class ProductsController
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        $products = new Products($this->db->getConnection());
        $products = $products->getAll();
        echo json_encode($products);
    }

    public function getById($id)
    {
        $products = new Products($this->db->getConnection());
        $products = $products->getById($id);
        echo json_encode($products);
    }


    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $products = new Products($this->db->getConnection());
        $result = $products->create($data['name'], $data['code'], $data['stock'], $data['provider'], $data['categoryId'], $data['genre'], $data['price'], $data['description']);

        if ($result) {
            echo json_encode(["message" => "Product created successfully"]);
        } else {
            echo json_encode(["message" => "Failed to create product"]);
        }
    }

    public function getByGenre($genre)
    {
        $products = new Products($this->db->getConnection());
        $products = $products->getByGenre($genre);
        echo json_encode($products);
    }

    public function getByProvider($provider)
    {
        $products = new Products($this->db->getConnection());
        $products = $products->getByProvider($provider);
        echo json_encode($products);
    }
}
