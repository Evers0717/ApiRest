<?php

class Order
{
    private $conn;
    public $id;

    public $idUser;

    public $dateOrder;

    public $total;

    public $state;

    public $address;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($idUser)
    {
        $queryCart = "SELECT * FROM cart WHERE user_id = $idUser";
        $resultCart = mysqli_query($this->conn, $queryCart);
        if (!$resultCart || mysqli_num_rows($resultCart) == 0) {
            echo json_encode(["message" => "El carrito está vacío o el usuario no existe."]);
            return;
        }

        $cartItems = [];
        while ($row = mysqli_fetch_assoc($resultCart)) {
            $cartItems[] = $row;
        }

        $total = 0;
        $orderProducts = [];
        foreach ($cartItems as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];

            $queryPrice = "SELECT price FROM products WHERE idProducts = $productId";
            $resultPrice = mysqli_query($this->conn, $queryPrice);
            $product = mysqli_fetch_assoc($resultPrice);

            if ($product) {
                $price = $product['price'];
                $subtotal = $price * $quantity;
                $total += $subtotal;

                $orderProducts[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price
                ];
            } else {
                echo json_encode(["message" => "Producto con ID $productId no encontrado."]);
                return;
            }
        }
        $stmt = $this->conn->prepare("SELECT idAdress FROM adress WHERE user_id = ? AND isActive = 1");
        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        $result = $stmt->get_result();
        $address = $result->fetch_assoc();

        if (!$address) {
            echo json_encode(["message" => "Dirección activa no encontrada para el usuario."]);
            return;
        }


        $idAddress = $address['idAdress'];
        $dateOrder = date('Y-m-d H:i:s');
        $state = 'Pendiente';


        $queryOrder = "INSERT INTO `order` (idUser, dateOrder, total, state, address) 
                   VALUES ($idUser, '$dateOrder', $total, '$state', $idAddress)";
        $resultOrder = mysqli_query($this->conn, $queryOrder);

        if (!$resultOrder) {
            echo json_encode(["message" => "Error al registrar la orden."]);
            return;
        }

        $orderId = mysqli_insert_id($this->conn);


        foreach ($orderProducts as $orderProduct) {
            $productId = $orderProduct['product_id'];
            $quantity = $orderProduct['quantity'];
            $price = $orderProduct['price'];
            $subtotal = $price * $quantity;

            $queryOrderProduct = "INSERT INTO orderdetails (orderId, productId, quantity, unitPrice,subtotal) 
                              VALUES ($orderId, $productId, $quantity, $price, $subtotal)";
            $resultOrderProduct = mysqli_query($this->conn, $queryOrderProduct);

            if (!$resultOrderProduct) {
                echo json_encode(["message" => "Error al registrar el producto con ID $productId en la orden."]);
                return;
            }
        }

        $queryEmptyCart = "DELETE FROM cart WHERE user_id = $idUser";
        $resultEmptyCart = mysqli_query($this->conn, $queryEmptyCart);

        if (!$resultEmptyCart) {
            echo json_encode(["message" => "Error al vaciar el carrito del usuario."]);
            return;
        }


        echo json_encode([
            "message" => "Orden creada exitosamente.",
            "order_id" => $orderId,
            "total" => $total
        ]);
    }
}
