<!--include icons in the pages--> 

<?php
$conn = new mysqli("localhost", "root", "", "db_name");

$sql = "SELECT category, SUM(amount) AS total 

        FROM sales 
        GROUP BY category";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>

<!--json--> 
[
  {"category":"Fresh Produce","total":3000},
  {"category":"Dairy","total":1200},
  {"category":"Bakery","total":800}
]


<!--add this to dashboard-->
<canvas id="salesPieChart" width="400" height="400"></canvas>

<!--include chart.js--> 
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!--include this in js-->
fetch("get_sales_data.php")
    .then(response => response.json())
    .then(data => {
        const categories = data.map(item => item.category);
        const totals = data.map(item => item.total);

        const ctx = document.getElementById('salesPieChart').getContext('2d');

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categories,
                datasets: [{
                    data: totals,
                    backgroundColor: [
                        '#4CAF50',
                        '#FF9800',
                        '#2196F3',
                        '#9C27B0',
                        '#F44336'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
