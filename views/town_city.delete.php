<?php

include "../town_city.php";
$db = new Database();
$connection = $db->getConnection();
$town_city = new TownCity($db);

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $delete_result = $town_city->delete($id);

    if ($delete_result) {
        echo "<script>alert('Town City record with ID: " . $id . " has been successfully Deleted!');";
        echo "window.location.href = '../record_table/town_city.view.php';</script>";
    } else {
        echo 'ERROR: Unable to delete student record.';
    }
}
?>
