<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'shopping_cart';
    private $username = 'root';
    private $password = 'Nhat2002@';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Kết nối lỗi: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
?>
