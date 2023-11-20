<?php

include "../student.php";
$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Call the delete method
    $delete_result = $student->delete($id);

    if ($delete_result) {
        echo "<script>alert('Student record with ID: " . $id . " has been successfully Deleted!');";
        echo "window.location.href = '../record_table/students.view.php';</script>";
    } else {
        echo 'ERROR: Unable to delete student record.';
    }
}
?>
