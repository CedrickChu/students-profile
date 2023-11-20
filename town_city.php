<?php
include_once("db.php"); // Include the Database class file
include_once("student.php");
$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);

class TownCity {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        try {
            $sql = "SELECT id, name FROM town_city";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            throw $e; 
        }
    }
    public function update($id, $data) {
        try {
            $sql = "UPDATE town_city SET name = :name WHERE id = :id";
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
    public function getCityById($id) {
        try {
            // Use a WHERE clause in your SQL query to filter by ID
            $sql = "SELECT id, name FROM town_city WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);
            
            // Bind the parameter
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
            $stmt->execute(); 
        
            // Fetch the city information
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }
    
}
?>
