<?php

require_once 'models/Categories.php';

class CategoriesController
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['name'])) {
            $name = $data['name'];

            $categories = new Categories($this->db->getConnection());
            $result = $categories->create($name);

            if ($result) {
                echo json_encode(["message" => "Category created successfully"]);
            } else {
                echo json_encode(["message" => "Failed to create category"]);
            }
        } else {
            echo json_encode(["message" => "Invalid input data"]);
        }
    }

    public function getAll()
    {
        $categories = new Categories($this->db->getConnection());
        $categories = $categories->getAll();
        echo json_encode($categories);
    }
}
