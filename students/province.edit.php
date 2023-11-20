<?php
include_once("../db.php");
include_once("../province.php");
$db = new Database();
$provinceManager = new Province($db); 

include 'base.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $result = $provinceManager->getProvinceById($id); 
    if ($result) {
        ?>
        <div class="container-sm">
            <h2>Edit Province</h2>
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
                    $newProvinceName = $_POST['name']; 
                    $data = [
                        'name' => $newProvinceName, 
                    ];

                    $updateResult = $provinceManager->update($id, $data); 

                    if ($updateResult) {
                        echo "<script>alert('Province record with ID: " . $id . " has been successfully edited!');</script>";
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
        echo 'Error retrieving Province data.';
    }
} else {
    echo 'Invalid or missing Province ID.';
}
?>

<p></p>
</main>
</body>
</html>
