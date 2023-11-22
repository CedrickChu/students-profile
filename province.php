<?php
include_once("db.php"); // Include the Database class file

class Province {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll($offset, $limit) {
        try {
            $sql = "SELECT * FROM province ORDER BY name ASC LIMIT :offset, :limit ";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e; 
        }
    }
    public function getTotalRowCount() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM province";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }
    public function displayAllWithLimit($offset, $limit) {
        try {
            $sql = "SELECT * FROM province LIMIT :offset, :limit";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }
    public function getProvinceById($id) {
        try {
            $sql = "SELECT id, name FROM province WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
            $stmt->execute(); 
        
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
    public function delete($id) {
        try {
            $this->db->getConnection()->beginTransaction();
    
            $province_sql = "DELETE FROM province WHERE id = :id"; 
            $province_stmt = $this->db->getConnection()->prepare($province_sql); 
            $province_stmt->bindValue(':id', $id);
            $province_stmt->execute();
    
            $this->db->getConnection()->commit();
    
            if ($province_stmt->rowCount() > 0) {
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
}
?>
