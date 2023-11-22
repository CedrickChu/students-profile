<?php
include_once("../db.php");
include_once("../town_city.php");
$db = new Database();
$city = new TownCity($db);
?>
    <?php include 'base.php'; ?>
    <div class="content-center">
        <div class="container container-fluid mx-auto">
            <table id='data-table' class="table table-striped table-dark table-bordered">
                <thead>
                    <tr>
                        <th class='text-center' colspan='3'><h3>TOWN CITY</h3></th>
                    </tr>
                    <tr>
                        <th class='text-center'>TOWN CITY ID</th>
                        <th class='text-center'>TOWN CITY NAME</th>
                        <th class='text-center'>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $recordsPerPage = 10;
                    $totalRowCount = $city->getTotalRowCount();
                    $totalPages = ceil($totalRowCount / $recordsPerPage);
                    
                    $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
                    
                    $offset = ($currentpage - 1) * $recordsPerPage;
                    $results = $city->getAll($offset, $recordsPerPage); 
                    
                    foreach ($results as $result) {
                    ?>
                    <tr>
                        <td class='text-center'><?php echo $result['id']; ?></td>
                        <td class='text-center'><?php echo $result['name']; ?></td>
                        
                        <td class='text-center'>
                            <a href="../views/town_city.edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                            |
                            <a href="../views/town_city.delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div style='padding-bottom: 10px; 'class="pagination">
                    <?php if ($currentpage > 1) : ?>
                        <a style='padding-right: 20px; padding-bottom: 10px;'href="?page=<?php echo $currentpage - 1; ?>">&laquo; Previous</a>
                    <?php endif; ?>

                    <?php if ($currentpage < $totalPages) : ?>
                        <a href="?page=<?php echo $currentpage + 1; ?>">Next &raquo;</a>
                    <?php endif; ?>
            </div>
            <a href="../views/town_city_add.php">
                <button class="btn btn-fill btn-danger">Add New Record</button>
            </a>
        </div>
    </div>
</body>
</html>
