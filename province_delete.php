<?php

include "province.php";
$db = new Database();
$connection = $db->getConnection();
$province = new Province($db);

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $delete_result = $province->delete($id);

    if ($delete_result) {
        echo "<script>alert('Province record with ID: " . $id . " has been successfully Deleted!');";
        echo "window.location.href = 'students/province.view.php';</script>";
    } else {
        echo 'ERROR: Unable to delete province record.';
    }
}
?>
