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
    public function delete($id) {
        try {
            $this->db->getConnection()->beginTransaction();
    
            $town_city_sql = "DELETE FROM town_city WHERE id = :id"; 
            $town_city_stmt = $this->db->getConnection()->prepare($town_city_sql); 
            $town_city_stmt->bindValue(':id', $id);
            $town_city_stmt->execute();
    
            $this->db->getConnection()->commit();
    
            if ($town_city_stmt->rowCount() > 0) {
                return true; 
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->db->getConnection()->rollBack();
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }
    public function getCityById($id) {
        try {
            $sql = "SELECT id, name FROM town_city WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
            $stmt->execute(); 
        
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }
    
}
?>
