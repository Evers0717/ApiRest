<?php

require_once 'models/Address.php';

class AddressController
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getByUser($user_id)
    {
        $address = new Address($this->db->getConnection());
        $address = $address->getByUser($user_id);
        echo json_encode($address);
    }

    public function getActiveAddress($user_id)
    {
        $address = new Address($this->db->getConnection());
        $address = $address->getActiveAddress($user_id);
        echo json_encode($address);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        // Comprobar si los datos están completos
        if (isset($data['name_address']) && isset($data['city']) && isset($data['country']) && isset($data['user_id'])) {
            $user_id = $data['user_id'];
            $name_address = $data['name_address'];
            $city = $data['city'];
            $country = $data['country'];

            $address = new Address($this->db->getConnection());
            $result = $address->create($user_id, $name_address, $city, $country);
            if ($result) {
                echo json_encode(["message" => "Adress for user {$user_id} created successfully"]);
            } else {
                echo json_encode(["message" => "Failed to create address for user {$user_id}"]);
            }
        } else {
            echo json_encode(["message" => "Invalid input data"]);
        }
    }

    public function makeActive()
    {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['address_id']) || !isset($data['user_id'])) {
            echo json_encode(["message" => "Invalid input data"]);
            return;
        }
    
        $address_id = $data['address_id'];
        $user_id = $data['user_id'];
        $address = new Address($this->db->getConnection());
        $result = $address->makeActive($address_id, $user_id);
        if ($result) {
            echo json_encode(["message" => "Address for user {$user_id} updated successfully"]);
        } else {
            echo json_encode(["message" => "Failed to update address for user {$user_id}"]);
        }
    }
}
