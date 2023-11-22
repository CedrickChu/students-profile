<?php
include_once("../db.php"); 
include_once("../town_city.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
    try{
        $data = [
            'name' => $_POST['name'],
        ];
        $db = new Database();
        $city = new TownCity($db);
        $result = $city->create($data);
        if ($result) {
            echo "<script>alert('TOWN CITY has been successfully added!');
                  window.location.href = '../record_table/town_city.view.php';</script>";
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
        <h2>ADD TOWN CITY</h2>
        <form action="" method="post">
            <div class='form-group'>
                <label for='name'>TOWN CITY: </label>
                <input class='form-control' type='text' name='name' required><br>
            </div>  
            <button class="btn btn-danger" type="submit" name="submit">SUBMIT</button>
        </form>
    </div>
    <?php include('../templates/footer.html'); ?>
    <table id='data-table'></table>
</body>
</html>
