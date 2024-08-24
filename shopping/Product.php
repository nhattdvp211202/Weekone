<?php
class Product {
    private $conn;
    private $table = 'tbl_product';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getProducts() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
