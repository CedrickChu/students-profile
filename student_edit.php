<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/utils.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/modern-normalize.css">
    <script type="module" src="js/theme_toggle.js"></script>
</head>
<body>
    <main>
        <?php include 'templates/header.html'; ?>

<?php
include_once("db.php");
include ("student.php");
$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $result = $student->getStudentById($id);
    if ($result) {
        ?>
        <div class="container-sm">
            
            <h2>Edit Employee</h2>
            <form action="" method="post">
                <div class='form-group'>
                    <label for='student_number'>STUDENT_NUMBER: </label>
                    <input class='form-control' type='text' name='student_number' value="<?php echo $result['student_number']; ?>" required><br>
                </div>
                <div class='form-group'>
                    <label for='first_name'>FIRST NAME: </label>
                    <input class='form-control' type='text' name='first_name' value="<?php echo $result['first_name']; ?>" required><br>
                </div>
                <div class='form-group'>
                    <label for='first_name'>MIDDLE NAME: </label>
                    <input class='form-control' type='text' name='middle_name' value="<?php echo $result['middle_name']; ?>" required><br>
                </div>
                <div class='form-group'>
                    <label for='first_name'>LAST NAME: </label>
                    <input class='form-control' type='text' name='last_name' value="<?php echo $result['last_name']; ?>" required><br>
                </div>
                <div class='form-group'>
                    <label for='first_name'>GENDER: </label>
                    <input class='form-control' type='text' name='gender' value="<?php echo $result['gender']; ?>" required><br>
                </div>
                <div class='form-group'>
                    <label for="birthday">BIRTHDAY:</label>
                    <input class='form-control' style='width: 20%;' type="date" id="birthday" name="birthday">

                </div>
                <div class='form-group'>
                    <label for='first_name'>CONTACT NUMBER: </label>
                    <input class='form-control' type='text' name='contact_number' value="<?php echo $result['contact_number']; ?>" required><br>
                </div>
                <div class='form-group'>
                    <label for='first_name'>STREET: </label>
                    <input class='form-control' type='text' name='street' value="<?php echo $result['street']; ?>" required><br>
                </div>
                <div class='form-group'>
                    <label for='town_city'>TOWN CITY: </label>
                    <?php
                    try {
                        
                        $sql = "SELECT name FROM town_city order by name ASC";
                        $stmt = $connection->prepare($sql);
                        $stmt->execute();
                        
                        // Fetch all town names as an associative array
                        $towns = $stmt->fetchAll(PDO::FETCH_COLUMN);

                        $selectedTown = isset($action) ? $action : '';

                        echo "<select class='form-control' style='width: 20%;' id='action' name='action' required>";
                        foreach ($towns as $town) {
                            $selected = ($town == $selectedTown) ? 'selected' : '';
                            echo "<option value='$town' $selected>$town</option>";
                        }
                        echo "</select>" . "<br>";
                    } catch (PDOException $e) {
                        // Handle any potential errors here
                        echo "Error: " . $e->getMessage();
                        // You might want to handle the error more gracefully in a production environment
                    }
                    ?>
                </div>
                <div class='form-group'>
                    <label for='province'>PROVINCE: </label>
                    <?php
                    try {
                        
                        
                        $sql = "SELECT name FROM province order by name ASC";
                        $stmt = $connection->prepare($sql);
                        $stmt->execute();
                        
                        // Fetch all town names as an associative array
                        $provinces = $stmt->fetchAll(PDO::FETCH_COLUMN);

                        $selectedProvince = isset($action) ? $action : '';

                        echo "<select class='form-control' style='width: 20%;' id='action' name='action' required>";
                        foreach ($provinces as $province) {
                            $selected = ($province == $selectedProvince) ? 'selected' : '';
                            echo "<option value='$province' $selected>$province</option>";
                        }
                        echo "</select>" . "<br>";
                    } catch (PDOException $e) {
                        // Handle any potential errors here
                        echo "Error: " . $e->getMessage();
                        // You might want to handle the error more gracefully in a production environment
                    }
                    ?>
                    <div class='form-group'>
                    <label for='zip_code'>ZIP CODE: </label>
                    <input class='form-control' style='width: 20%'type='text' name='zip_code' value="<?php echo $result['zip_code']; ?>" required><br>
                </div>
                </div>

                <a href="students/students.view.php">
                    <button class="button btn-primary" type="submit" name="submit">Submit</button>
                </a>
            </form>
        </div>
        <?php
    } else {
        echo 'Error retrieving student data.';
    }
} else {
    echo 'Invalid or missing student ID.';
}
?>

        <?php include('templates/footer.html'); ?>
        <p></p>
    </main>
</body>

</html>