<?php
include_once("../db.php");
include_once("../town_city.php");
$db = new Database();
$city = new TownCity($db);

include '../record_table/base.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $result = $city->getCityById($id); 
    if ($result) {
        ?>
    <div class="container-sm">
        <h2>Edit Town City</h2>
        <form action="" method="post">
            <div class='form-group'>
                <label for='name'>TOWN CITY</label>
                <input class='form-control' type='text' name='name' value="<?php echo $result['name']; ?>" required><br>
            </div>
            <button class="btn btn-danger" type="submit" name="submit">Update</button>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            try {
                $id = $_GET['id'];
                $townCity = $_POST['name'];
                $data = [
                    'name' => $townCity, // Correct column name
                ];

                $updateResult = $city->update($id, $data);

                if ($updateResult) {
                    echo "<script>alert('TOWN CITY record with ID: " . $id . " has been successfully edited!');";
                    echo "window.location.href = '../record_table/town_city.view.php';</script>";
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
<table id='data-table'></table>
</main>
</body>
</html>
