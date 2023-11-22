<?php
include_once("../db.php");
include_once("../student.php");
$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);

$sql = "SELECT COUNT(*) as student_count, p.name as province_name
FROM students s
JOIN student_details sd ON s.id = sd.student_id
JOIN province p ON p.id = sd.province
GROUP BY p.id
ORDER BY student_count DESC
LIMIT 100;";

$stmt = $connection->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$data = [];

foreach ($results as $row) {
    $labels[] = $row['province_name'];
    $data[] = $row['student_count'];
}
?>

<?php
if (!empty($labels) && !empty($data)) {
    include 'base.php';
    ?>
    <div class="content-center">
        <div class="container container-fluid mx-auto">
            <div class="card" style="width: 80rem; height: 80rem;">
                <div class="card-body">
                    <h5 class="card-title">STUDENT STATISTIC</h5>
                    <h6 class="card-subtitle mb-2 text-muted">100 province who has most the student_count</h6>
                    <canvas id="studentChart" width="1200" height="1200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        var ctx = document.getElementById('studentChart').getContext('2d');
        var studentChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false
            }
        });
    </script>
<?php
} else {
    echo "No data available for chart.";
}
?>
</main>
</body>
</html>
