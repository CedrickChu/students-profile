<?php
include_once("db.php"); // Include the file with the Database class

class Student {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO students(student_number, first_name, middle_name, last_name, gender, birthday) VALUES(:student_number, :first_name, :middle_name, :last_name, :gender, :birthday);";
            $stmt = $this->db->getConnection()->prepare($sql);
    
            // Bind values to placeholders
            $stmt->bindParam(':student_number', $data['student_number']);
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':middle_name', $data['middle_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':gender', $data['gender']);
            $stmt->bindParam(':birthday', $data['birthday']);
    
            // Execute the INSERT query
            $success = $stmt->execute();
    
            // Check if the insert was successful
            if ($success) {
                // Return the last inserted ID only if the statement was successfully executed
                return $this->db->getConnection()->lastInsertId();
            } else {
                return null; // Return null if the insert was not successful
            }
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
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

            // Fetch the student data as an associative array
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
            // Handle any potential errors here
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
    
            $stmt->execute(); // Execute the prepared statement
    
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; 
        }
    }
        
    

    public function displayAll(){
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
            LIMIT 100";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
}
 

?>