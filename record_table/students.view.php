<?php
include_once("../db.php");
include_once("../student.php");
$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);
?>
        <?php  include 'base.php'; ?>
        <div class="content-center">
            <div class="container container-fluid mx-auto">
                <table id='data-table' class="table table-striped table-dark table-bordered">
                    <thead>
                        <tr>
                        <th class='text-center' colspan='14'><h3>STUDENTS RECORD</h3></th>
                        </tr>
                        <tr>
                            <th colspan='2'>STUDENT NUMBER</th>
                            <th>FIRST NAME</th>
                            <th>MIDDLE NAME</th>
                            <th>LAST NAME</th>
                            <th>GENDER</th>
                            <th colspan='2'>BIRTHDAY</th>
                            <th colspan='2'>CONTACT NUMBER</th>
                            <th colspan="2">ADDRESS</th>
                            <th class='text-center' colspan="2">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $results = $student->displayAll(); 
                        foreach ($results as $result) {
                        ?>
                        <tr>
                            <td colspan="2"><?php echo $result['student_number']; ?></td>
                            <td><?php echo $result['first_name']; ?></td>
                            <td><?php echo $result['middle_name']; ?></td>
                            <td><?php echo $result['last_name']; ?></td>
                            <?php 
                            if($result['gender'] == 1)
                            {
                            echo "<td>MALE</td>";
                            }
                            elseif($result['gender'] == 0)
                            {
                                echo "<td>FEMALE</td>";
                            }
                            ?>
                            <td colspan='2'><?php echo $result['birthday']; ?></td>
                            <td colspan="2"><?php echo $result['contact_number']; ?></td>
                            <td colspan="2"><?php echo $result['ADDRESS']; ?></td>
                            <td colspan="2" class='text-center'>
                                <a href="../views/student_edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                                |
                                <a href="../views/student_delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                            </td>
                            <?php
                            ?>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <a class="button-link" href="student_add.php">Add New Record</a>
        </div>  
        <p></p>
    </main>
</body>

</html>