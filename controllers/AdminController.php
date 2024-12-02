<?php
require_once 'models/Admin.php';


class AdminController
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $admin = new Admin($this->db->getConnection());
        $result = $admin->login($data['user'], $data['password']);
        if ($result) {
            echo json_encode([
            "success" => true,
            "message" => "Login successful",
            "id" => $result['idAdmin'],        
            "user" => $result['user']
        ]);
        } else {
            echo json_encode(["message" => "Login failed"]);
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $admin = new Admin($this->db->getConnection());
        $result = $admin->create($data['user'], $data['password']);
        if ($result) {
            echo json_encode(["message" => "Admin created successfully"]);
        } else {
            echo json_encode(["message" => "Failed to create admin"]);
        }
    }
}
