<?php
require_once 'models/Provider.php';
class ProviderController
{


    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['name']) && isset($data['cellphone']) && isset($data['password']) && isset($data['desc'])) {
            $name = $data['name'];
            $password = $data['password'];
            $desc = $data['desc'];
            $cellphone = $data['cellphone'];

            $provider = new Provider($this->db->getConnection());
            $result = $provider->create($name, $password, $desc, $cellphone);

            if ($result) {
                echo json_encode(["message" => "Provider created successfully"]);
            } else {
                echo json_encode(["message" => "Failed to create provider"]);
            }
        } else {
            echo json_encode(["message" => "Invalid input data"]);
        }
    }

    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['email']) && isset($data['password'])) {
            $email = $data['email'];
            $password = $data['password'];

            $provider = new Provider($this->db->getConnection());
            $result = $provider->login($email, $password);

            if ($result) {
                echo json_encode([
                    "success" => true,
                    "message" => "Login successful",
                    "id" => $result['idProvider'],
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

    public function getAll()
    {
        $provider = new Provider($this->db->getConnection());
        $result = $provider->getAll();

        echo json_encode($result);
    }

    public function getById($id)
    {
        $provider = new Provider($this->db->getConnection());
        $result = $provider->getById($id);

        echo json_encode($result);
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['idProvider']) && isset($data['name']) && isset($data['cellphone']) && isset($data['password']) && isset($data['desc'])) {
            $id = $data['idProvider'];
            $name = $data['name'];
            $password = $data['password'];
            $desc = $data['desc'];
            $cellphone = $data['cellphone'];

            $provider = new Provider($this->db->getConnection());
            $result = $provider->update($id, $name, $password, $desc, $cellphone);

            if ($result) {
                echo json_encode(["message" => "Provider updated successfully"]);
            } else {
                echo json_encode(["message" => "Failed to update provider"]);
            }
        } else {
            echo json_encode(["message" => "Invalid input data"]);
        }
    }
}
