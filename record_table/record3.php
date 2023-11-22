<?php
include_once("../db.php");
include_once("../student.php");
$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);

$sql = "SELECT COUNT(*) as student_count, YEAR(s.birthday) as birth_year, s.gender
        FROM students s
        WHERE YEAR(s.birthday) BETWEEN 2010 AND 2023
        GROUP BY birth_year, s.gender
        ORDER BY birth_year ASC";

$stmt = $connection->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$maleData = [];
$femaleData = [];
$years = range(2010, 2023);

foreach ($results as $row) {
    $index = array_search($row['birth_year'], $years);
    if ($row['gender'] == 0) {
        $maleData[$index] = $row['student_count'];
    } elseif ($row['gender'] == 1) {
        $femaleData[$index] = $row['student_count'];
    }
}
?>

<?php

if (!empty($years) && (!empty($maleData) || !empty($femaleData))) {
    include 'base.php';
    ?>
    <div class="content-center">
        <div class="container container-fluid mx-auto">
            <div class="card" style="width: 80rem;">
                <div class="card-body">
                    <h5 class="card-title">STUDENT BIRTHDAYS - 2010 to 2023 group by GENDER</h5>
                    <canvas id="birthdayChart" width="1200" height="500"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        var ctx = document.getElementById('birthdayChart').getContext('2d');
        var birthdayChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($years); ?>,
                datasets: [
                    {
                        label: 'Male',
                        data: <?php echo json_encode(array_values($maleData)); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Female',
                        data: <?php echo json_encode(array_values($femaleData)); ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'category',
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>

<?php
} else {
    echo "No data available for chart.";
}
?>
<table id='data-table'></table>
</main>
</body>
</html>
