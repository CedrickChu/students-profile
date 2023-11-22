<?php
include_once("../db.php"); 
include_once("../student.php"); 
include_once("../province.php");
include_once("../town_city.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
    try{
        $data = [    
            'student_number' => $_POST['student_number'],
            'first_name' => $_POST['first_name'],
            'middle_name' => $_POST['middle_name'],
            'last_name' => $_POST['last_name'],
            'gender'=> $_POST['gender'],
            'birthday' => $_POST['birthday'],
            'contact_number' => $_POST['contact_number'],
            'street' => $_POST['street'],
            'zip_code' => $_POST['zip_code'],
            'town_city' => $_POST['town_city'],
            'province' => $_POST['province'],
        
        ];
        $db = new Database();
        $students = new Student($db);
        $result = $students->create($data);
        if ($result) {
            echo "<script>alert('Student has been successfully added!');
                  window.location.href = '../record_table/students.view.php';</script>";
        } else {
            echo "<script>alert('Error updating record.');</script>";
        }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>
<?php include '../record_table/base.php' ?>
    <div class="container-sm">
        <h2>ADD STUDENT</h2>
        <form action="" method="post">
            <div class='row'>
                <div class='col'>
                    <div class='form-group'>
                        <label for='student_number'>STUDENT_NUMBER: </label>
                        <input class='form-control' type='text' name='student_number' required><br>
                    </div>
                    <div class='form-group'>
                        <label for='first_name'>FIRST NAME: </label>
                        <input class='form-control' type='text' name='first_name' required><br>
                    </div>
                    <div class='form-group'>
                        <label for='middle_name'>MIDDLE NAME: </label>
                        <input class='form-control' type='text' name='middle_name' required><br>
                    </div>
                    <div class='form-group'>
                        <label for='last_name'>LAST NAME: </label>
                        <input class='form-control' type='text' name='last_name' required><br>
                    </div>
                </div>
                <div class='col'>
                    <div class='form-group'>
                        <label for='gender'>GENDER: </label>
                        <select class='form-control text-center' name="gender" id="gender" required><br>
                            <option value="" disabled> -- SELECT -- </option>
                            <option value="0">Male</option>
                            <option value="1">Female</option>
                        </select><br>
                    </div>
                    <div class='form-group'>
                        <label for="birthday">BIRTHDAY:</label>

                        <input class='form-control text-center' type="date" id="birthday" name="birthday"
                            min="1960-01-01" max="2026-12-31" /><br>
                        </div>
                    <div class='form-group'>
                        <label for='contact_number'>CONTACT NUMBER: </label>
                        <input class='form-control' type='text' name='contact_number' required><br>
                    </div>
                    <div class='form-group'>
                        <label for='street'>STREET: </label>
                        <input class='form-control' type='text' name='street' required><br>
                    </div>
                </div>
            </div>
            <div class='container-center'>
                <div class='row'>
                    <div class='col-sm'>
                        <div class='form-group'>
                        <label for="town_city">Town / City:</label>
                            <select class='form-control text-center' name="town_city" id="town_city" required><br>
                            <?php

                                $database = new Database();
                                $towns = new TownCity($database);
                                $results = $towns->getAll($offset, $limit);
                                // echo print_r($results);
                                foreach($results as $result)
                                {
                                    echo '<option value="' . $result['id'] . '">' . $result['name'] . '</option>';
                                }
                            ?>      
                            </select>
                        </div>
                    </div>
                    <div class='col-sm'>
                        <div class='form-group'>
                        <label for="province">Province:</label>
                            <select class='form-control text-center' name="province" id="province" required>
                            <?php

                                $database = new Database();
                                $provinces = new Province($database);
                                $results = $provinces->getAll($offset, $limit);
                                foreach($results as $result)
                                {
                                    echo '<option value="' . $result['id'] . '">' . $result['name'] . '</option>';
                                }
                            ?>  
                            </select>    
                        </div>
                    </div>
                    <div class='col-sm'>
                        <div class='form-group'>
                            <label for='zip_code'>ZIP CODE: </label>
                            <input class='form-control text-center' style='width: 100%' type='text' name='zip_code' required>
                        </div>
                    </div>
                </div><br>
            </div>
            <button class="btn btn-danger" type="submit" name="submit">SUBMIT</button>
        </form>
    </div>
    <?php include('../templates/footer.html'); ?>
    <table id='data-table'></table>
</body>
</html>
