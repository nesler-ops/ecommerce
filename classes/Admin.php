<?php
class Admin {
    private $conn;
    private $table_name = "admin";

    public $id;
    public $email;
    public $telephone;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->id = $row['id'];
            $this->email = $row['email'];
            $this->telephone = $row['telephone'];
            $this->password = $row['password'];
            return true;
        }
        
        return false;
    }
}
?>