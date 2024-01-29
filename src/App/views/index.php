<?php
include $this->resolve("partials/_header.php");

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Complied', <?= $allWorkQueue['complied'] ?>],
            ['Uncomplied', <?= $allWorkQueue['uncomplied'] ?>]
        ]);

        var options = {
            title: 'All Work Queue Available'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>


<section>
    <div class="row ms-2 text-center fw-bold">
        <h2>WORK QUEUE</h2>
    </div>
    <div class="row mx-2">
        <div class="col-4">
            <div class="row">
                <span class="fs-5 fw-bold">Personnel Status</span>
            </div>
            <div class="row">

            </div>
        </div>
    </div>
    <div class="row">
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </div>
</section>

<?php
include $this->resolve("partials/_footer.php");
?>