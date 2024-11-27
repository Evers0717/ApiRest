<?php

require_once 'models/Costumer.php';

class CostumerController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        $costumer = new Costumer($this->db->getConnection());
        $costumers = $costumer->getAll();
        echo json_encode($costumers);
    }


    public function getById($id)
    {
        $costumer = new Costumer($this->db->getConnection());
        $costumer = $costumer->getById($id);
        echo json_encode($costumer);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);


        if (isset($data['name']) && isset($data['password']) && isset($data['email']) && isset($data['cellphone'])) {
            $name = $data['name'];
            $password = $data['password'];
            $email = $data['email'];
            $cellphone = $data['cellphone'];

            $costumer = new Costumer($this->db->getConnection());
            $result = $costumer->create($name, $password, $email, $cellphone);


            if ($result) {
                echo json_encode(["message" => "Costumer created successfully"]);
            } else {
                echo json_encode(["message" => "Failed to create costumer"]);
            }
        } else {
            echo json_encode(["message" => "Invalid input data"]);
        }
    }

    public function login()
{
    $data = json_decode(file_get_contents("php://input"), true);

    $costumer = new Costumer($this->db->getConnection());
    $result = $costumer->login($data['email'], $data['password']);
    
    if ($result) {
        echo json_encode([
            "success" => true,
            "message" => "Login successful",
            "id" => $result['id'],        
            "name" => $result['name'],    
            "email" => $result['email']   
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Login failed"
        ]);
    }
}
}
