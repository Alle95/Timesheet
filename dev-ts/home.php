<!DOCTYPE html>
<html lang="en">

<?php $pageTitle = "Home"; include("head.php"); ?>

<body>
<?php include("menu.php"); ?>
    <div id="container" style="width:100%; height:400px;">
        <script>
            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Hours Worked Over the Last 21 Days'
                },
                subtitle: {
                    text: 'Dummy data showing hours worked per day'
                },
                xAxis: {
                    categories: [
                        'Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7',
                        'Day 8', 'Day 9', 'Day 10', 'Day 11', 'Day 12', 'Day 13', 'Day 14',
                        'Day 15', 'Day 16', 'Day 17', 'Day 18', 'Day 19', 'Day 20', 'Day 21'
                    ],
                    labels: {
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    },
                    title: {
                        text: 'Days'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Hours Worked'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'Hours worked: <b>{point.y} hours</b>'
                },
                series: [{
                    name: 'Hours Worked',
                    colorByPoint: true,
                    groupPadding: 0,
                    data: [
                        ['Day 1', 8],
                        ['Day 2', 7.5],
                        ['Day 3', 8],
                        ['Day 4', 7],
                        ['Day 5', 9],
                        ['Day 6', 6.5],
                        ['Day 7', 8],
                        ['Day 8', 8],
                        ['Day 9', 7],
                        ['Day 10', 8.5],
                        ['Day 11', 9],
                        ['Day 12', 6],
                        ['Day 13', 8],
                        ['Day 14', 7],
                        ['Day 15', 8.5],
                        ['Day 16', 7],
                        ['Day 17', 8],
                        ['Day 18', 9],
                        ['Day 19', 6.5],
                        ['Day 20', 7.5],
                        ['Day 21', 8]
                    ],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        inside: true,
                        verticalAlign: 'top',
                        format: '{point.y}', // no decimal
                        y: 10, // 10 pixels down from the top
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }]
            });
        </script>
    </div>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Last 10 Time Entries</h2>
    <table id="timeEntriesTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Task ID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Description</th>
            <th>User ID</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>1001</td>
            <td>2024-09-01</td>
            <td>08:00:00</td>
            <td>Task description example 1</td>
            <td>1</td>
            <td>2024-09-01 08:30:00</td>
            <td>2024-09-01 08:35:00</td>
        </tr>
        <tr>
            <td>2</td>
            <td>1002</td>
            <td>2024-09-02</td>
            <td>09:00:00</td>
            <td>Task description example 2</td>
            <td>2</td>
            <td>2024-09-02 09:30:00</td>
            <td>2024-09-02 09:35:00</td>
        </tr>
        <tr>
            <td>3</td>
            <td>1003</td>
            <td>2024-09-03</td>
            <td>10:00:00</td>
            <td>Task description example 3</td>
            <td>3</td>
            <td>2024-09-03 10:30:00</td>
            <td>2024-09-03 10:35:00</td>
        </tr>
        <tr>
            <td>4</td>
            <td>1004</td>
            <td>2024-09-04</td>
            <td>11:00:00</td>
            <td>Task description example 4</td>
            <td>4</td>
            <td>2024-09-04 11:30:00</td>
            <td>2024-09-04 11:35:00</td>
        </tr>
        <tr>
            <td>5</td>
            <td>1005</td>
            <td>2024-09-05</td>
            <td>12:00:00</td>
            <td>Task description example 5</td>
            <td>5</td>
            <td>2024-09-05 12:30:00</td>
            <td>2024-09-05 12:35:00</td>
        </tr>
        <tr>
            <td>6</td>
            <td>1006</td>
            <td>2024-09-06</td>
            <td>13:00:00</td>
            <td>Task description example 6</td>
            <td>6</td>
            <td>2024-09-06 13:30:00</td>
            <td>2024-09-06 13:35:00</td>
        </tr>
        <tr>
            <td>7</td>
            <td>1007</td>
            <td>2024-09-07</td>
            <td>14:00:00</td>
            <td>Task description example 7</td>
            <td>7</td>
            <td>2024-09-07 14:30:00</td>
            <td>2024-09-07 14:35:00</td>
        </tr>
        <tr>
            <td>8</td>
            <td>1008</td>
            <td>2024-09-08</td>
            <td>15:00:00</td>
            <td>Task description example 8</td>
            <td>8</td>
            <td>2024-09-08 15:30:00</td>
            <td>2024-09-08 15:35:00</td>
        </tr>
        <tr>
            <td>9</td>
            <td>1009</td>
            <td>2024-09-09</td>
            <td>16:00:00</td>
            <td>Task description example 9</td>
            <td>9</td>
            <td>2024-09-09 16:30:00</td>
            <td>2024-09-09 16:35:00</td>
        </tr>
        <tr>
            <td>10</td>
            <td>1010</td>
            <td>2024-09-10</td>
            <td>17:00:00</td>
            <td>Task description example 10</td>
            <td>10</td>
            <td>2024-09-10 17:30:00</td>
            <td>2024-09-10 17:35:00</td>
        </tr>
        </tbody>
    </table>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLR+Rxm/X00bc31qMj4tIxZB5i7PLmMFpDfWlQ8s4w" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-2.1.6/datatables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#timeEntriesTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            pageLength: 10,
            lengthChange: false
        });
    });
</script>

</body>
</html>
