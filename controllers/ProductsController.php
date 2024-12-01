<?php
require_once 'models/Products.php';
class ProductsController
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        $products = new Products($this->db->getConnection());
        $products = $products->getAll();
        echo json_encode($products);
    }

    public function getById($id)
    {
        $products = new Products($this->db->getConnection());
        $products = $products->getById($id);
        echo json_encode($products);
    }


    public function create()
    {
        // Obtener los datos del formulario
        if (isset($_POST['name'], $_POST['code'], $_POST['stock'], $_POST['provider'], $_POST['categoryId'], $_POST['genre'], $_POST['price'], $_POST['description'])) {

            // Obtener los valores del formulario
            $name = $_POST['name'];
            $code = $_POST['code'];
            $stock = $_POST['stock'];
            $provider = $_POST['provider'];
            $categoryId = $_POST['categoryId'];
            $genre = $_POST['genre'];
            $price = $_POST['price'];
            $description = $_POST['description'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Directorio donde se guardarán las imágenes
                $targetDir = __DIR__ . "/../uploads/";


                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0755, true); // Crear el directorio si no existe
                }


                $targetFile = $targetDir . uniqid() . basename($_FILES["image"]["name"]);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                $validImageTypes = ["jpg", "jpeg", "png", "gif", "webp"];
                if (!in_array($imageFileType, $validImageTypes)) {
                    echo json_encode(["message" => "Solo se permiten imágenes JPG, JPEG, PNG o GIF"]);
                    return;
                }

                $image = null;
                if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
                    $image = imagecreatefromjpeg($_FILES["image"]["tmp_name"]);
                } elseif ($imageFileType == "png") {
                    $image = imagecreatefrompng($_FILES["image"]["tmp_name"]);
                } elseif ($imageFileType == "gif") {
                    $image = imagecreatefromgif($_FILES["image"]["tmp_name"]);
                } elseif ($imageFileType == "webp") {
                    $image = imagecreatefromwebp($_FILES["image"]["tmp_name"]);
                }

                // Redimensionar la imagen a 400x400
                if ($image !== null) {

                    $originalWidth = imagesx($image);
                    $originalHeight = imagesy($image);


                    $newWidth = 400;
                    $newHeight = 400;

                    // Crear una nueva imagen vacía con las dimensiones deseadas
                    $newImage = imagecreatetruecolor($newWidth, $newHeight);


                    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

                    // Guardar la imagen redimensionada
                    if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
                        imagejpeg($newImage, $targetFile, 90);
                    } elseif ($imageFileType == "png") {
                        imagepng($newImage, $targetFile);
                    } elseif ($imageFileType == "gif") {
                        imagegif($newImage, $targetFile);
                    } elseif ($imageFileType == "webp") {
                        imagewebp($newImage, $targetFile);
                    }


                    imagedestroy($image);
                    imagedestroy($newImage);


                    $imageUrl = "uploads/" . basename($targetFile);
                } else {
                    echo json_encode(["message" => "Error al cargar la imagen"]);
                    return;
                }
            } else {
                $imageUrl = null;
            }

            $products = new Products($this->db->getConnection());
            $result = $products->create($name, $code, $stock, $provider, $categoryId, $genre, $price, $description, $imageUrl);

            if ($result) {
                echo json_encode(["message" => "Producto creado exitosamente"]);
            } else {
                echo json_encode(["message" => "No se pudo crear el producto"]);
            }
        } else {
            echo json_encode(["message" => "Datos de entrada no válidos"]);
        }
    }


    public function getByGenre($genre)
    {
        $products = new Products($this->db->getConnection());
        $products = $products->getByGenre($genre);
        echo json_encode($products);
    }

    public function getByProvider($provider)
    {
        $products = new Products($this->db->getConnection());
        $products = $products->getByProvider($provider);
        echo json_encode($products);
    }

    public function getByCategoryIndex($categoryId)
    {
        $products = new Products($this->db->getConnection());
        $products = $products->getByCategoryIndex($categoryId);
        echo json_encode($products);
    }

    public function search($search)
    {
        $products = new Products($this->db->getConnection());
        $products = $products->search($search);
        echo json_encode($products);
    }
}
