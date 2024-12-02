<?php

class OrderDetails
{
    private $conn;

    public $id;
    public $orderId;
    public $productId;
    public $quantity;
    public $unitPrice;
    public $subtotal;
    public $boughtdate;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getOrderDetailsByUser($userId)
    {
        // Consulta SQL con placeholders
        $query = "
        SELECT 
            od.idorderDetails,
            od.orderId,
            od.productId,
            od.quantity,
            od.unitPrice,
            od.subtotal,
            p.name AS product_name,
            p.image_url AS product_image,
            o.dateOrder,
            o.total,
            o.state,
            o.address
        FROM 
            orderdetails od
        JOIN 
            orders o ON od.orderId = o.idorder
        JOIN 
            products p ON od.productId = p.idProducts
        WHERE 
            o.iduser = ?
    ";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Enlazar parámetros (el usuario debe ser un entero)
        $stmt->bind_param("i", $userId);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        // Recoger los datos en un array
        $orderDetails = [];
        while ($row = $result->fetch_assoc()) {
            $orderDetails[] = $row;
        }

        // Cerrar la declaración
        $stmt->close();

        return $orderDetails;
    }

    public function getAll()
    {
        $query = "
    SELECT 
        od.idorderDetails,
        od.orderId,
        od.productId,
        od.quantity,
        od.unitPrice,
        od.subtotal,
        p.name AS product_name,
        p.provider,
        o.dateOrder,
        o.total,
        o.state,
        o.address
    FROM 
        orderdetails od
    JOIN 
        orders o ON od.orderId = o.idorder
    JOIN 
        products p ON od.productId = p.idProducts
    ORDER BY 
        o.dateOrder DESC
    ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $result = $stmt->get_result();

        $orderDetails = [];
        while ($row = $result->fetch_assoc()) {
            $orderDetails[] = $row;
        }

        $stmt->close();

        return $orderDetails;
    }

    public function getByProvider($provider)
    {
        $query = "
    SELECT 
        od.idorderDetails,
        od.orderId,
        od.productId,
        od.quantity,
        od.unitPrice,
        od.subtotal,
        p.name AS product_name,
        p.provider,
        o.dateOrder,
        o.total,
        o.state,
        o.address
    FROM 
        orderdetails od
    JOIN 
        orders o ON od.orderId = o.idorder
    JOIN 
        products p ON od.productId = p.idProducts
    WHERE 
        p.provider = ?
    ORDER BY 
        o.dateOrder DESC
    ";

        $stmt = $this->conn->prepare($query);

        // Bind the $provider variable directly
        $stmt->bind_param("s", $provider);

        $stmt->execute();

        $result = $stmt->get_result();

        $orderDetails = [];
        while ($row = $result->fetch_assoc()) {
            $orderDetails[] = $row;
        }

        $stmt->close();

        return $orderDetails;
    }

}
