<?php
include_once("../db.php");
include_once("../student.php");
$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);

$sql = "SELECT COUNT(*) as student_count, MONTH(s.birthday) as birth_month, s.gender
        FROM students s
        WHERE YEAR(s.birthday) = 2000
        GROUP BY birth_month, s.gender
        ORDER BY birth_month ASC";

$stmt = $connection->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$maleData = [];
$femaleData = [];
$months = [];

for ($i = 1; $i <= 12; $i++) {
    $months[] = $i;
    $maleData[$i] = 0;
    $femaleData[$i] = 0;
}

foreach ($results as $row) {
    if ($row['gender'] == 0) {
        $maleData[$row['birth_month']] = $row['student_count'];
    } elseif ($row['gender'] == 1) {
        $femaleData[$row['birth_month']] = $row['student_count'];
    }
}
?>

<?php

if (!empty($months) && (!empty($maleData) || !empty($femaleData))) {
    include_once('base.php');
    ?>
    <div class="content-center">
        <div class="container container-fluid mx-auto">
            <div class="card" style="width: 80rem;">
                <div class="card-body">
                    <h5 class="card-title">STUDENT BIRTHDAYS - Year 2000 group by GENDER</h5>
                    <canvas id="birthdayChart" width="1200" height="600"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
    var ctx = document.getElementById('birthdayChart').getContext('2d');
    var birthdayChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Male',
                    data: <?php echo json_encode(array_values($maleData)); ?>,
                    backgroundColor: 'rgb(54, 162, 235)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 3,
                    pointRadius: 5,
                    fill: false
                },
                {
                    label: 'Female',
                    data: <?php echo json_encode(array_values($femaleData)); ?>,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    pointRadius: 5,
                    fill: false
                }
            ]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    type: 'category', 
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    },
                    }]
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
