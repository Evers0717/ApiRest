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

        if (isset($data['name']) && isset($data['email']) && isset($data['cellphone']) && isset($data['password']) && isset($data['desc'])) {
            $name = $data['name'];
            $password = $data['password'];
            $desc = $data['desc'];
            $email = $data['email'];
            $cellphone = $data['cellphone'];

            $provider = new Provider($this->db->getConnection());
            $result = $provider->create($name, $password, $desc, $email, $cellphone);

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

                $response = [
                    "success" => true,
                    "message" => "Login successful",
                    "data" => $result
                ];
            } else {

                $response = [
                    "success" => false,
                    "message" => "Invalid email or password"
                ];
            }
        } else {

            $response = [
                "success" => false,
                "message" => "Invalid input data"
            ];
        }


        echo json_encode($response);
    }
}
