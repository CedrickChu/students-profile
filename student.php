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
            $sql = "UPDATE students SET
                    student_number = :student_number,
                    first_name = :first_name,
                    middle_name = :middle_name,
                    last_name = :last_name,
                    gender = :gender,
                    birthday = :birthday
                    WHERE id = :id";
    
            $stmt = $this->db->getConnection()->prepare($sql);
    
            // Bind parameters
            $stmt->bindValue(':student_number', $data['student_number']);
            $stmt->bindValue(':first_name', $data['first_name']);
            $stmt->bindValue(':middle_name', $data['middle_name']);
            $stmt->bindValue(':last_name', $data['last_name']);
            $stmt->bindValue(':gender', $data['gender']);
            $stmt->bindValue(':birthday', $data['birthday']);
           
    
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
        
                // Fetch the result as an associative array
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Handle any potential errors here
                echo "Error: " . $e->getMessage();
                throw $e; // Re-throw the exception for higher-level handling
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