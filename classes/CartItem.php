<?php
class CartItem {
    private $conn;
    private $table_name = "cart_items";

    public $id;
    public $user_id;
    public $product_id;
    public $quantity;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addToCart() {
        $query = "INSERT INTO " . $this->table_name . " (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)
                  ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':quantity', $this->quantity);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getCartItems($user_id) {
        $query = "SELECT ci.id, ci.product_id, ci.quantity, p.name, p.price, p.image 
                  FROM " . $this->table_name . " ci
                  JOIN products p ON ci.product_id = p.id
                  WHERE ci.user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt;
    }

    public function updateQuantity() {
        $query = "UPDATE " . $this->table_name . " SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':product_id', $this->product_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function removeFromCart() {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':product_id', $this->product_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function clearCart($user_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>