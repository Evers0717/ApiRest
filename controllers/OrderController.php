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

    public function getCostumerOrders($idUser)
    {
        $order = new Order($this->db->getConnection());
        $order = $order->getCostumerOrders($idUser);    
        echo json_encode($order);
    }
    
}
