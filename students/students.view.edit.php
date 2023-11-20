<?php
include_once("../db.php");
include_once("../student_edit.php");
include_once("../student.php");
include 'base.php';
?>

<div class="content">
    <div class="container-fluid">
        <div class="content">
            <div class="container-fluid">
                <h2>Edit Students</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="firstname">FIRST NAME: </label>
                        <input type="text" name="new_first_name" value="<?php echo $data['new_first_name']; ?>" required><br>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks: </label>
                        <input type="text" name="remarks" value="<?php echo $remarks; ?>" required><br>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-fill" type="submit" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../templates/footer.html'); ?>
<p></p>
</main>
</body>
</html>
