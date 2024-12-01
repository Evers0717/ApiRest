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
public function getByName($name)
{
    $costumer = new Costumer($this->db->getConnection());
    $result = $costumer->getByName($name);

    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(["message" => "Costumer not found"]);
    }
}
public function selectById($id)
{
    $costumer = new Costumer($this->db->getConnection());
    $result = $costumer->getById($id);

    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(["message" => "Costumer not found"]);
    }
}
public function update()
{
    $data = json_decode(file_get_contents("php://input"), true);

    $costumer = new Costumer($this->db->getConnection());
    $result = $costumer->update($data['id'], $data['name'], $data['password'], $data['email'], $data['cellphone']);

    if ($result) {
        echo json_encode(["message" => "Costumer updated successfully"]);
    } else {
        echo json_encode(["message" => "Failed to update costumer"]);
    }
}
}
