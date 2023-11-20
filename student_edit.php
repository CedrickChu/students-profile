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
            <h2>Edit Student</h2>
            <form action="" method="post">
                <div class='row'>
                    <div class='col'>
                        <div class='form-group'>
                            <label for='student_number'>STUDENT_NUMBER: </label>
                            <input class='form-control' type='text' name='student_number' value="<?php echo $result['student_number']; ?>" required><br>
                        </div>
                        <div class='form-group'>
                            <label for='first_name'>FIRST NAME: </label>
                            <input class='form-control' type='text' name='first_name' value="<?php echo $result['first_name']; ?>" required><br>
                        </div>
                        <div class='form-group'>
                            <label for='middle_name'>MIDDLE NAME: </label>
                            <input class='form-control' type='text' name='middle_name' value="<?php echo $result['middle_name']; ?>" required><br>
                        </div>
                        <div class='form-group'>
                            <label for='last_name'>LAST NAME: </label>
                            <input class='form-control' type='text' name='last_name' value="<?php echo $result['last_name']; ?>" required><br>
                        </div>
                    </div>
                    <div class='col'>
                        <div class='form-group'>
                            <label for='gender'>GENDER: </label>
                            <select class='form-control text-center' style='width: 100%' name="gender" id="gender">
                                <option value="" disabled>-- SELECT --</option>
                                <option value="0" <?php echo ($result['gender'] == '0') ? 'selected' : ''; ?>>MALE</option>
                                <option value="1" <?php echo ($result['gender'] == '1') ? 'selected' : ''; ?>>FEMALE</option>
                            </select><br>
                        </div>
                        <div class='form-group'>
                            <label for='birthday'>BIRTHDAY: </label>
                            <input class='form-control' type='text' name='birthday' value="<?php echo $result['birthday']; ?>" required><br>
                        </div>
                        <div class='form-group'>
                            <label for='contact_number'>CONTACT NUMBER: </label>
                            <input class='form-control' type='text' name='contact_number' value="<?php echo $result['contact_number']; ?>" required><br>
                        </div>
                        <div class='form-group'>
                            <label for='street'>STREET: </label>
                            <input class='form-control' type='text' name='street' value="<?php echo $result['street']; ?>" required><br>
                        </div>
                    </div>
                </div>
                <div class='container-center'>
                    <div class='row'>
                        <div class='col-sm'>
                            <div class='form-group'>
                                <label for='town_city'>TOWN CITY: </label>
                                <?php
                                try {
                                    $sql = "SELECT name FROM town_city order by name ASC";
                                    $stmt = $connection->prepare($sql);
                                    $stmt->execute();

                                    $towns = $stmt->fetchAll(PDO::FETCH_COLUMN);

                                    $selectedTown = $result['town_city'];

                                    echo "<select class='form-control text-center' style='width: 100%' id='town_city' name='town_city' required>";
                                    echo "<option value='' disabled>-- SELECT --</option>";
                                    foreach ($towns as $town) {
                                        $selected = ($town == $selectedTown) ? 'selected' : '';
                                        echo "<option value='$town' $selected>$town</option>";
                                    }
                                    echo "</select>";
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                ?>
                            </div>
                        </div>
                        <div class='col-sm'>
                            <div class='form-group'>
                                <label for='province'>PROVINCE: </label>
                                <?php
                                try {
                                    $sql = "SELECT name FROM province order by name ASC";
                                    $stmt = $connection->prepare($sql);
                                    $stmt->execute();
                                    $provinces = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                    $selectedProvince = $result['province'];
                                    echo "<select class='form-control text-center' style='width: 100%' id='province' name='province' required>";
                                    echo "<option value='' disabled>-- SELECT --</option>";
                                    foreach ($provinces as $province) {
                                        $selected = ($province == $selectedProvince) ? 'selected' : '';
                                        echo "<option value='$province' $selected>$province</option>";
                                    }
                                    echo "</select>";
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                ?>
                            </div>
                        </div>
                        <div class='col-sm'>
                            <div class='form-group'>
                                <label for='zip_code'>ZIP CODE: </label>
                                <input class='form-control text-center' style='width: 100%' type='text' name='zip_code' value="<?php echo $result['zip_code']; ?>" required>
                            </div>
                        </div>
                    </div><br>
                </div>
                <button class="btn btn-danger" type="submit" name="submit">Update</button>
            </form>

            <?php
                if (isset($_POST['submit'])) {
                    try {
                        $students = new Student($db);
                        $id = $_GET['id'];
                        $student_number = $_POST['student_number'];
                        $first_name = $_POST['first_name'];
                        $middle_name = $_POST['middle_name'];
                        $last_name = $_POST['last_name'];
                        $gender = $_POST['gender'];
                        $birthday = $_POST['birthday'];
                        $town_city = $_POST['town_city'];
                        $province = $_POST['province'];
                        $contact_number = $_POST['contact_number'];
                        $street = $_POST['street'];
                        $zip_code = $_POST['zip_code'];
                        $data = [
                            'student_number' => $student_number,
                            'first_name' => $first_name,
                            'middle_name' => $middle_name,
                            'last_name' => $last_name,
                            'gender' => $gender,
                            'birthday' => $birthday,
                            'town_city' => $town_city,
                            'province' => $province,
                            'contact_number' => $contact_number,
                            'street' => $street,
                            'zip_code' => $zip_code,
                        ];

                        $result = $students->update($id, $data);

                        if ($result) {
                            echo "<script>alert('Student record with ID: " . $id . " has been successfully edited!');</script>";
                            echo "window.location.href = './students/students.view.php';";
                        } else {
                            echo "<script>alert('Error updating record.');</script>";
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
                ?>

        </div>
        <?php
    } else {
        echo 'Error retrieving student data.';
    }
} else {
    echo 'Invalid or missing student ID.';
}
?>

        
        <p></p>
    </main>
</body>

</html>