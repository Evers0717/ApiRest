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

        // Comprobar si los datos están completos
        if (isset($data['name']) && isset($data['password']) && isset($data['email']) && isset($data['cellphone'])) {
            $name = $data['name'];
            $password = $data['password'];
            $email = $data['email'];
            $cellphone = $data['cellphone'];

            // Crear un nuevo objeto Costumer y guardar en la base de datos
            $costumer = new Costumer($this->db->getConnection());
            $result = $costumer->create($name, $password, $email, $cellphone);

            // Comprobar si la inserción fue exitosa y devolver la respuesta correspondiente
            if ($result) {
                echo json_encode(["message" => "Costumer created successfully"]);
            } else {
                echo json_encode(["message" => "Failed to create costumer"]);
            }
        } else {
            echo json_encode(["message" => "Invalid input data"]);
        }
    }
}
