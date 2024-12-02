<?php
require_once 'models/OrderDetails.php';

class OrderDetailsController
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function getCostumerOrders($idUser)
    {
        $orderDetails = new OrderDetails($this->db->getConnection());
        $orderDetails = $orderDetails->getOrderDetailsByUser($idUser);
        echo json_encode($orderDetails);
    }

    public function getAll()
    {
        $orderDetails = new OrderDetails($this->db->getConnection());
        $orderDetails = $orderDetails->getAll();
        echo json_encode($orderDetails);

    }

    public function getByProvider($provider)
    {
        $orderDetails = new OrderDetails($this->db->getConnection());
        $orderDetails = $orderDetails->getByProvider($provider);
        echo json_encode($orderDetails);
    }
}
