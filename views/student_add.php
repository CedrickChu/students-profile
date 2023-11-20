<?php
include_once("../db.php"); // Include the Database class file
include_once("../student.php"); // Include the Student class file
include_once("../student_details.php"); // Include the Student class file
include_once("../town_city.php");
include_once("../province.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    
    'student_number' => $_POST['student_number'],
    'first_name' => $_POST['first_name'],
    'middle_name' => $_POST['middle_name'],
    'last_name' => $_POST['last_name'],
    'gender' => $_POST['gender'],
    'birthday' => $_POST['birthday'],
    ];

    // Instantiate the Database and Student classes
    $database = new Database();
    $student = new Student($database);
    $student_id = $student->create($data);
    
    if ($student_id) {
        // Student record successfully created
        
        // Retrieve student details from the form
        $studentDetailsData = [
            'student_id' => $student_id, // Use the obtained student ID
            'contact_number' => $_POST['contact_number'],
            'street' => $_POST['street'],
            'zip_code' => $_POST['zip_code'],
            'town_city' => $_POST['town_city'],
            'province' => $_POST['province'],
            // Other student details fields
        ];

        // Create student details linked to the student
        $studentDetails = new StudentDetails($database);
        
        if ($studentDetails->create($studentDetailsData)) {
            echo "Record inserted successfully.";
        } else {
            echo "Failed to insert the record.";
        }
    }

    
}
?>

    <?php include('../students/base.php'); ?>
    <div class="content-center">
        <h1>Add Student Data</h1>
        <form action="" method="post">
            <label for="student_number">Student Number:</label>
            <input type="text" name="student_number" id="student_number" required><br>

            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" required><br>

            <label for="middle_name">Middle Name:</label>
            <input type="text" name="middle_name" id="middle_name">

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" required><br>

            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required><br>
                <option value="0">Male</option>
                <option value="1">Female</option>
            </select>
            <label for="birthday">Birthdate:</label>
            <input type="date" name="birthday" id="birthday" required><br>

            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" required><br>

            <label for="street">Street:</label>
            <input type="text" id="street" name="street" required><br>

            <label for="town_city">Town / City:</label>
            <select name="town_city" id="town_city" required><br>
            <?php

                $database = new Database();
                $towns = new TownCity($database);
                $results = $towns->getAll();
                // echo print_r($results);
                foreach($results as $result)
                {
                    echo '<option value="' . $result['id'] . '">' . $result['name'] . '</option>';
                }
            ?>      
            </select>

            <label for="province">Province:</label>
            <select name="province" id="province" required>
            <?php

                $database = new Database();
                $provinces = new Province($database);
                $results = $provinces->getAll();
                foreach($results as $result)
                {
                    echo '<option value="' . $result['id'] . '">' . $result['name'] . '</option>';
                }
            ?>  
            </select>    

            <label for="zip_code">Zip Code:</label>
            <input type="text" id="zip_code" name="zip_code" required>

            


            <input type="submit" value="Add Student">
        </form>
    </div>
    
    <?php include('../templates/footer.html'); ?>
</body>
</html>
