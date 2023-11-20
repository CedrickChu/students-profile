<?php
include_once("db.php"); // Include the Database class file

class Province {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        try {
            $sql = "SELECT * FROM province";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e; 
        }
    }
    public function getProvinceById($id) {
        try {
            $sql = "SELECT id, name FROM province WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
            $stmt->execute(); 
        
            // Fetch the city information
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }
    public function update($id, $data) {
        try {
            $sql = "UPDATE province SET name = :name WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);
    
            // Bind parameters
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Execute the statement
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }
}
?>
