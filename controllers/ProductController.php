<?php
include_once '../config/Database.php';
include_once '../classes/Product.php';
require_once '../init.php';

class ProductController {
    private $db;
    private $product;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
    }

    public function getProducts() {
        return $this->product->read();
    }

    public function getProductById($id) {
        return $this->product->readOne($id);
    }

    public function createProduct($name, $price, $description, $image) {
        $this->product->name = htmlspecialchars(strip_tags($name));
        $this->product->price = htmlspecialchars(strip_tags($price));
        $this->product->description = htmlspecialchars(strip_tags($description));
        $this->product->image = htmlspecialchars(strip_tags($image));
        return $this->product->create();
    }

    public function updateProduct($id, $name, $price, $description, $image) {
        $this->product->id = $id;
        $this->product->name = htmlspecialchars(strip_tags($name));
        $this->product->price = htmlspecialchars(strip_tags($price));
        $this->product->description = htmlspecialchars(strip_tags($description));
        $this->product->image = htmlspecialchars(strip_tags($image));
        return $this->product->update();
    }

    public function deleteProduct($id) {
        $this->product->id = $id;
        return $this->product->delete();
    }
}
?>