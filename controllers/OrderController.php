<?php
require_once 'models/Order.php';

class OrderController
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create($idUser)
    {
        $order = new Order($this->db->getConnection());
        $order->create($idUser);
    }
}
