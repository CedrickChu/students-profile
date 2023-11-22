<?php
include_once("db.php"); // Include the file with the Database class

class Student {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        try {
            $this->db->getConnection()->beginTransaction();
    
            $sqlStudents = "INSERT INTO students (student_number, first_name, middle_name, last_name, gender, birthday)
                            VALUES (:student_number, :first_name, :middle_name, :last_name, :gender, :birthday)";
    
            $stmtStudent = $this->db->getConnection()->prepare($sqlStudents);
    
            $stmtStudent->bindParam(':student_number', $data['student_number']);
            $stmtStudent->bindParam(':first_name', $data['first_name']);
            $stmtStudent->bindParam(':middle_name', $data['middle_name']);
            $stmtStudent->bindParam(':last_name', $data['last_name']);
            $stmtStudent->bindParam(':gender', $data['gender']);
            $stmtStudent->bindParam(':birthday', $data['birthday']);
    
            $successStudent = $stmtStudent->execute();

            if (!$successStudent) {
                $this->db->getConnection()->rollBack();
                return null;
            }

            $lastInsertId = $this->db->getConnection()->lastInsertId();

            $sqlDetails = "INSERT INTO student_details (student_id, contact_number, street, zip_code, town_city, province)
                        VALUES (:student_id, :contact_number, :street, :zip_code, :town_city, :province)";

            $stmtDetails = $this->db->getConnection()->prepare($sqlDetails);

            $stmtDetails->bindParam(':student_id', $lastInsertId);
            $stmtDetails->bindParam(':contact_number', $data['contact_number']);
            $stmtDetails->bindParam(':street', $data['street']);
            $stmtDetails->bindParam(':zip_code', $data['zip_code']);
            $stmtDetails->bindParam(':town_city', $data['town_city']);
            $stmtDetails->bindParam(':province', $data['province']);
    
            $successDetails = $stmtDetails->execute();
    
            if (!$successDetails) {
                $this->db->getConnection()->rollBack();
                return null;
            }
    
            $this->db->getConnection()->commit();
    
            return $lastInsertId;
    
        } catch (PDOException $e) {
            $this->db->getConnection()->rollBack();
            echo "Error: " . $e->getMessage();
            throw $e; 
        }
    }
    
    public function delete($id) {
        try {
            $this->db->getConnection()->beginTransaction();
    
            $detailSql = "DELETE FROM student_details WHERE student_id = :id";
            $detailStmt = $this->db->getConnection()->prepare($detailSql);
            $detailStmt->bindValue(':id', $id);
            $detailStmt->execute(); 
    
           
            $studentSql = "DELETE FROM students WHERE id = :id";
            $studentStmt = $this->db->getConnection()->prepare($studentSql);
            $studentStmt->bindValue(':id', $id);
            $studentStmt->execute();
    
            
            $this->db->getConnection()->commit();
    
           
            if ($studentStmt->rowCount() > 0) {
                return true; // Record deleted successfully
            } else {
                return false; 
            }
        } catch (PDOException $e) {
           
            $this->db->getConnection()->rollBack();
            echo "Error: " . $e->getMessage();
            throw $e; 
        }
    }

    public function read($id) {
        try {
            $connection = $this->db->getConnection();
            $sql = "SELECT * FROM students WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

            return $studentData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE students s
                    JOIN student_details sd ON s.id = sd.student_id
                    JOIN town_city tc ON sd.town_city = tc.id
                    JOIN province p ON sd.province = p.id
                    SET
                        s.student_number = :student_number,
                        s.first_name = :first_name,
                        s.middle_name = :middle_name,
                        s.last_name = :last_name,
                        s.gender = :gender,
                        s.birthday = :birthday,
                        sd.zip_code = :zip_code,
                        sd.contact_number = :contact_number,
                        sd.street = :street,
                        tc.name = :town_city,  
                        p.name = :province     
                    WHERE s.id = :id";
    
            $stmt = $this->db->getConnection()->prepare($sql);
    
            // Bind parameters
            $stmt->bindValue(':student_number', $data['student_number']);
            $stmt->bindValue(':first_name', $data['first_name']);
            $stmt->bindValue(':middle_name', $data['middle_name']);
            $stmt->bindValue(':last_name', $data['last_name']);
            $stmt->bindValue(':gender', $data['gender']);
            $stmt->bindValue(':birthday', $data['birthday']);
            $stmt->bindValue(':zip_code', $data['zip_code']);
            $stmt->bindValue(':contact_number', $data['contact_number']);
            $stmt->bindValue(':street', $data['street']);
            $stmt->bindValue(':town_city', $data['town_city']);  
            $stmt->bindValue(':province', $data['province']);    
            $stmt->bindValue(':id', $id);
    
            // Execute the query
            $stmt->execute();
    
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function getStudentById($id) {
        try {
            $sql = "SELECT
                s.id as id,
                s.student_number as student_number,
                s.first_name as first_name,
                s.middle_name as middle_name,
                s.last_name as last_name,
                s.gender as gender,
                sd.zip_code as zip_code,
                s.birthday as birthday,
                sd.contact_number as contact_number,
                sd.street as street,
                tc.name as town_city,
                p.name as province
            FROM
                students s
            JOIN
                student_details sd ON s.id = sd.student_id
            JOIN
                town_city tc ON sd.town_city = tc.id
            JOIN
                province p ON sd.province = p.id
            WHERE s.id = :id
            LIMIT 100";
    
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            $stmt->execute(); 
    
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; 
        }
    }
        
    public function getTotalRowCount() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM students";
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
            $sql = "SELECT * FROM students LIMIT :offset, :limit";
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

    public function displayAll($offset, $limit){
        try {
            $sql = "SELECT
                s.id as id,
                s.student_number as student_number,
                s.first_name as first_name,
                s.middle_name as middle_name,
                s.last_name as last_name,
                s.gender as gender,
                s.birthday as birthday,
                sd.contact_number as contact_number,
                CONCAT(sd.street, ' ', sd.town_city, ' ', sd.province, ' ', sd.zip_code) as ADDRESS
            FROM
                students s
            JOIN
                student_details sd ON s.id = sd.student_id
            LIMIT :offset, :limit";
    
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
    public function getTotalRowCountByTownCity($townCityId) {
        $sql = "SELECT COUNT(*) as total FROM students s
                  JOIN student_details sd ON s.id = sd.student_id
                  WHERE sd.town_city = :townCityId";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(":townCityId", $townCityId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
    public function getStudentsByTownCity($townCityId) {
        $sql= "SELECT s.id, s.first_name, s.middle_name, s.last_name, s.gender
                  FROM students s
                  JOIN student_details sd ON s.id = sd.student_id
                  WHERE sd.town_city = :townCityId";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(":townCityId", $townCityId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>