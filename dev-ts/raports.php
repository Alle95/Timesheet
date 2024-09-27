<?php
$pageTitle = "Statistic";
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y'); // Get the year from URL or default to current year

$host = "localhost";
$username = "root";
$password = "";
$dbname = "time registration"; // Connect to "time_registration" database

// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get worked hours per month
$query = "
    SELECT CONCAT(u.first_name, ' ', u.last_name) AS name, 
           SUM(CASE WHEN MONTH(te.date) = 1 THEN TIME_TO_SEC(te.time) / 3600 ELSE 0 END) AS month1,
           SUM(CASE WHEN MONTH(te.date) = 2 THEN TIME_TO_SEC(te.time) / 3600 ELSE 0 END) AS month2,
           SUM(CASE WHEN MONTH(te.date) = 3 THEN TIME_TO_SEC(te.time) / 3600 ELSE 0 END) AS month3,
           SUM(CASE WHEN MONTH(te.date) = 4 THEN TIME_TO_SEC(te.time) / 3600 ELSE 0 END) AS month4,
           SUM(CASE WHEN MONTH(te.date) = 5 THEN TIME_TO_SEC(te.time) / 3600 ELSE 0 END) AS month5,
           SUM(CASE WHEN MONTH(te.date) = 6 THEN TIME_TO_SEC(te.time) / 3600 ELSE 0 END) AS month6,
           SUM(CASE WHEN MONTH(te.date) = 7 THEN TIME_TO_SEC(te.time) / 3600 ELSE 0 END) AS month7,
           SUM(CASE WHEN MONTH(te.date) = 8 THEN TIME_TO_SEC(te.time) / 3600 ELSE 0 END) AS month8,
           SUM(CASE WHEN MONTH(te.date) = 9 THEN TIME_TO_SEC(te.time) / 3600 ELSE 0 END) AS month9,
           SUM(CASE WHEN MONTH(te.date) = 10 THEN TIME_TO_SEC(te.time) / 3600 ELSE 0 END) AS month10,
           SUM(CASE WHEN MONTH(te.date) = 11 THEN TIME_TO_SEC(te.time) / 3600 ELSE 0 END) AS month11,
           SUM(CASE WHEN MONTH(te.date) = 12 THEN TIME_TO_SEC(te.time) / 3600 ELSE 0 END) AS month12
    FROM users u
    LEFT JOIN time_entries te ON u.id = te.user_id
    WHERE YEAR(te.date) = $year
    GROUP BY u.first_name, u.last_name
";

// Execute query
$result = $conn->query($query);
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[$row['name']] = [
            intval($row['month1']) . ":" . (intval(floatval($row['month1']) * 60) % 60),
            intval($row['month2']) . ":" . (intval(floatval($row['month2']) * 60) % 60),
            intval($row['month3']) . ":" . (intval(floatval($row['month3']) * 60) % 60),
            intval($row['month4']) . ":" . (intval(floatval($row['month4']) * 60) % 60),
            intval($row['month5']) . ":" . (intval(floatval($row['month5']) * 60) % 60),
            intval($row['month6']) . ":" . (intval(floatval($row['month6']) * 60) % 60),
            intval($row['month7']) . ":" . (intval(floatval($row['month7']) * 60) % 60),
            intval($row['month8']) . ":" . (intval(floatval($row['month8']) * 60) % 60),
            intval($row['month9']) . ":" . (intval(floatval($row['month9']) * 60) % 60),
            intval($row['month10']) . ":" . (intval(floatval($row['month10']) * 60) % 60),
            intval($row['month11']) . ":" . (intval(floatval($row['month11']) * 60) % 60),
            intval($row['month12']) . ":" . (intval(floatval($row['month12']) * 60) % 60)
        ];
    }
} else {
    echo "No data found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style_raports.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <style>
        .custom-container {
            width: 90%; /* Custom width for the navbar */
            margin: 0 auto; /* Center it */
        }
    </style>
</head>
<body>
    <?php include("menu.php"); ?>

    <?php 
    // Months array for table headers
    $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    ?>

    <!-- ************ My code ************ -->

    <!-- ************ A class 4 a raport ************ -->
    <div class="statistics card">
        <div class="card-body">
            <div class="container-fluid description" id="description_1">
                <p>In this report, you can see the name of the user, the hours worked for each month, and the total hours per user:</p>
            </div>

            <div class="container-fluid chart-container">
                <div class="table-container table-responsive" id="table_1">
                    <table id="myDataTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <?php foreach ($months as $month): ?>
                                    <th scope="col"><?php echo $month; ?></th>
                                <?php endforeach; ?>
                                <th scope="col">Total/User</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <?php
                        $index = 1;
                        foreach ($users as $user => $user_hours) {
                            $total_hours = 0;
                            $total_minutes = 0;

                            // Calculate total hours and minutes for the user
                            foreach ($user_hours as $hours) {
                                list($h, $m) = explode(':', $hours);
                                $total_hours += intval($h);
                                $total_minutes += intval($m);
                            }

                            // Convert total minutes into hours and minutes
                            $extra_hours = intdiv($total_minutes, 60);
                            $total_hours += $extra_hours;
                            $total_minutes = $total_minutes % 60;

                            $formatted_total = sprintf('%d:%02d', $total_hours, $total_minutes);

                            echo "<tr>
                                    <th scope='row'>$index</th>
                                    <td>$user</td>";
                            foreach ($user_hours as $hours) {
                                echo "<td>$hours</td>";
                            }
                            echo "<td style='font-weight: bold;'>$formatted_total</td></tr>";
                            $index++;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: bold;">
                                <th scope="row">Total/Month</th>
                                <td> <3 </td>
                                <?php
                                // Array for each month with hours and minutes
                                $monthly_totals = array_fill(0, 12, ['hours' => 0, 'minutes' => 0]);

                                // Sum hours and minutes
                                foreach ($users as $user_hours) {
                                    foreach ($user_hours as $month_index => $hours) {
                                        list($h, $m) = explode(':', $hours);
                                        $monthly_totals[$month_index]['hours'] += intval($h);
                                        $monthly_totals[$month_index]['minutes'] += intval($m);
                                    }
                                }
                                foreach ($monthly_totals as $total) {
                                    // Convert minutes to hours and minutes
                                    $extra_hours = intdiv($total['minutes'], 60);
                                    $total_hours = $total['hours'] + $extra_hours;
                                    $total_minutes = $total['minutes'] % 60;
                                    echo "<td>" . sprintf('%d:%02d', $total_hours, $total_minutes) . "</td>";
                                }
                                ?>
                                <td> <3 </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- DataTables Initialization -->
                <script>
                $(document).ready(function () {
                    var table = $('#myDataTable').DataTable();

                    if (!$.fn.DataTable.isDataTable('#myDataTable')) {
                        $('#myDataTable').DataTable({
                            "paging": true,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "pageLength": 12,
                            "lengthChange": true,
                            "lengthMenu": [12, 25, 50, 75, 100],
                            "order": [[0, 'asc']],
                            "columnDefs": [
                                { 
                                    "targets": 0, 
                                    "orderable": false 
                                }
                            ],
                            "drawCallback": function(settings) {
                                var api = this.api();
                                api.column(0, { page: 'current' }).nodes().each(function(cell, i) {
                                    cell.innerHTML = i + 1;
                                });
                            }
                        });
                    }
                });
                </script>
            </div>

            <!-- Chart -->
            <div id="column_1" style="width: 100%; display: flex; justify-content: center;">
                <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var table = $('#myDataTable').DataTable();
                    var data = table.rows().data().toArray();

                    var categories = [];
                    var seriesData = [];

                    data.forEach(function(row) {
                        var name = row[1];
                        var totalHours = parseFloat(row[14]); // Assuming Total/User is at index 14

                        if (!isNaN(totalHours)) {
                            categories.push(name);
                            seriesData.push(totalHours);
                        }
                    });

                    Highcharts.chart('column_1', {
                        chart: {
                            type: 'column',
                            backgroundColor: 'transparent',
                            width: 600, 
                            height: 400
                        },
                        title: {
                            text: 'User Hours Worked'
                        },
                        credits: {
                            enabled: false
                        },
                        xAxis: {
                            categories: categories,
                            title: {
                                text: 'Users'
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Hours Worked'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><br/>',
                            pointFormat: '{series.name}: <b>{point.y}</b><br/>'
                        },
                        series: [{
                            name: 'Hours Worked',
                            data: seriesData
                        }]
                    });
                });
                </script>
            </div>
        </div>
    </div>
</body>
</html>
