<?php
include_once("../db.php");
include_once("../town_city.php");
$db = new Database();
$city = new TownCity($db); 
?>
    <?php  include 'base.php'; ?>
    <div class="content-center">
        <div class="container container-fluid mx-auto">
            <table id='town_city-table' class="table table-striped table-dark table-bordered">
                <thead>
                    <tr>
                        <th class='text-center' colspan="3">Student Records</th> 
                    </tr>
                    <tr>
                        <th class='text-center'>TOWN CITY ID</th>
                        <th class='text-center'>TOWN CITY NAME</th>
                        <th class='text-center'>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $results = $city->getAll(); 
                    foreach ($results as $result) {
                    ?>
                    <tr>
                        <td class='text-center'><?php echo $result['id']; ?></td>
                        <td class='text-center'><?php echo $result['name']; ?></td>
                        
                        <td class='text-center'>
                            <a href="town_city.edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                            |
                            <a href="../town_city.delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>

                    
                </tbody>
            </table>
        </div>
    </div>
    <a class="button-link" href="student_add.php">Add New Record</a>

        </div>
        
    <?php include('../templates/footer.html'); ?>


    <p></p>
</body>
</html>
