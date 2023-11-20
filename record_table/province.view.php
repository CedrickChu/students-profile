<?php
include_once("../db.php");
include_once("../province.php");
$db = new Database();
$province = new province($db); 
?>

<?php  include 'base.php'; ?>
    <div class="content-center">
        <div class="container container-fluid mx-auto">
            <table id='data-table' class="table table-striped table-dark table-bordered">
                <thead>
                    <tr>
                        <th class='text-center' colspan='3'><h3>PROVINCE</h3></th>
                    </tr>
                    <tr>
                        <th class='text-center'>PROVINCE ID</th>
                        <th class='text-center'>PROVINCE NAME</th>
                        <th class='text-center'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $results = $province->getAll(); 
                    foreach ($results as $result) {
                    ?>
                    <tr>
                        <td class='text-center'><?php echo $result['id']; ?></td>
                        <td class='text-center'><?php echo $result['name']; ?></td>
                        
                        <td class='text-center'>
                            <a href="../views/province.edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                            |
                            <a href="../views/province_delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <a class="button-link" href="student_add.php">Add New Record</a>
    </div>
    <p></p>
</body>
</html>
