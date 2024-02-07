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
            ['Tasks', 'Number'],
            ['Updated', <?= $active['updated'] ?>],
            ['For Update', <?= $active['forUpdate'] ?>],
            ['Near Deadline', <?= $active['nearDeadline'] ?>]
        ]);
        var options = {
            title: 'Active Work Queue: <?= $active['active'] ?>',
            titleTextStyle: {
                fontSize: 16
            },
            legend: {
                position: 'right',
                textStyle: {
                    color: 'black',
                    fontSize: 14
                },
                alignment: 'top'
            },
            chartArea: {
                left: 10,
                top: 50,
                height: 300,
                width: 550
            },
            height: 250,
            width: 400,
            is3D: true
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Tasks', 'Number'],
            ['Complied', <?= $allWorkQueue['complied'] ?>],
            ['Pending', <?= $allWorkQueue['pending'] ?>],
            ['Uncomplied', <?= $allWorkQueue['uncomplied'] ?>]
        ]);
        var options = {
            title: 'Total Work Queue Added: <?= $allWorkQueue['all'] ?>',
            titleTextStyle: {
                fontSize: 16
            },
            legend: {
                position: 'right',
                textStyle: {
                    color: 'black',
                    fontSize: 14
                },
                alignment: 'top'
            },
            chartArea: {
                left: 10,
                top: 50,
                height: 300,
                width: 550
            },
            height: 300,
            width: 400,
            is3D: true
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
        chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Tasks', 'Number'],
            ['Early', <?= $timeliness['early'] ?>],
            ['On Time', <?= $timeliness['onTime'] ?>],
            ['Late', <?= $timeliness['late'] ?>],
            ['No Target', <?= $timeliness['noTD'] ?>]
        ]);
        var options = {
            title: 'Timeliness of Compliances:',
            titleTextStyle: {
                fontSize: 16
            },
            legend: {
                position: 'right',
                textStyle: {
                    color: 'black',
                    fontSize: 14
                },
                alignment: 'top'
            },
            chartArea: {
                left: 10,
                top: 50,
                height: 300,
                width: 550
            },
            height: 250,
            width: 400,
            is3D: true
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart3'));
        chart.draw(data, options);
    }
</script>


<section>
    <div class="row ms-2 text-center fw-bold">
        <h2>DASHBOARD</h2>
    </div>
    <div class="row mx-2">
        <div class="col-12 col-md-3">
            <div class="row mb-3">
                <span class="fs-5 fw-bold">Personnel Status:</span>
            </div>
            <div class="row ps-2 overflow-y-scroll" style="height:680px">
                <div class="col">
                    <?php foreach ($users as $user) : ?>
                        <div class="row my-2 mx-1 border shadow">
                            <div class=" my-2 col-4">
                                <img class="border-dark border-2 rounded-1 border" src="/profile/<?php echo $user['picture'] ?>" alt="" style=" border-radius:10px; height:120px; width:100%">
                            </div>
                            <div class="col-8" style="height:fit-content">
                                <div class="row mb-1">
                                    <a class="fw-bold" href="/dashboard/profile/<?= $user['id'] ?>" style="color:black"><?= $user['name'] ?></a>
                                </div>
                                <div class="row mb-1">
                                    <span>Duty Status: <span class="fw-bold" style="color:green"><?= $user['status'] ?></span></span>
                                </div>
                                <div class="row">
                                    <span>Active Work Queue : <span class="fw-bold"><?= $user['workNumbers']['active'] ?></span></span>
                                    <span>For Update : <span class="fw-bold"><?= $user['workNumbers']['update'] ?></span></span>
                                    <span>Deadline : <span class="fw-bold" style="color:red"><?= $user['workNumbers']['deadline'] ?></span></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="col-9 ">
            <div class="row">
                <span class="fs-5 fw-bold">Data Charts:</span>
            </div>
            <div class="row overflow-y-scroll" style="height:700px">
                <div class="row mb-2" style="height:330px">
                    <div class="col-12 col-md-4">
                        <div id="piechart" style="height:50px; width:100%;" class=""></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div id="piechart2" style="height:50px; width:100%;" class=""></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div id="piechart3" style="height:50px; width:100%;" class=""></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-7">
                        <div class="row mb-2">
                            <span class="fw-bold fs-6"></span>
                        </div>
                        <div class="row ms-2">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-recentlyAdded-tab" data-bs-toggle="pill" data-bs-target="#pills-recentlyAdded" type="button" role="tab" aria-controls="pills-recentlyAdded" aria-selected="true">Recently Added</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-complied-tab" data-bs-toggle="pill" data-bs-target="#pills-complied" type="button" role="tab" aria-controls="pills-complied" aria-selected="true">Recently Complied</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-update-tab" data-bs-toggle="pill" data-bs-target="#pills-update" type="button" role="tab" aria-controls="pills-update" aria-selected="false">Follow Up</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-deadline-tab" data-bs-toggle="pill" data-bs-target="#pills-deadline" type="button" role="tab" aria-controls="pills-deadline" aria-selected="false">Deadline</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-approval-tab" data-bs-toggle="pill" data-bs-target="#pills-approval" type="button" role="tab" aria-controls="pills-approval" aria-selected="false">Pending Approval</button>
                                </li>
                            </ul>
                            <!-- TABS -->
                            <div class="row overflow-y-scroll" style="height:290px">
                                <div class="tab-content" id="pills-tabContent">

                                    <!-- TAB FOR RECENTLY ADDED WORK QUEUES -->
                                    <div class="tab-pane fade show active" id="pills-recentlyAdded" role="tabpanel" aria-labelledby="pills-recentlyAdded-tab" tabindex="0">
                                        <?php foreach ($recentlyAdded as $work) : ?>
                                            <div class="row mb-2 border">
                                                <div class="col-12 my-1">
                                                    <div class="row mb-2 d-flex align-items-center justify-content-start">
                                                        <span class="fw-bold ">Subject: <span style="text-decoration: underline;"><?= $work['subject'] ?></span> </span>
                                                    </div>
                                                    <div class="row mb-2 ">
                                                        <div class="col-3 d-flex align-items-center" style="width:fit-content">
                                                            <span>Assigned to: </span>
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="row mb-1">
                                                                <?php foreach ($work['assignment'] as $assigned) : ?>
                                                                    <div class="col-1 me-3">
                                                                        <img class="border-dark border-2 rounded-1 border" src="/profile/<?php echo $assigned[1]['picture'] ?>" alt="" style=" border-radius:10px; height:50px; width:50px">
                                                                    </div>
                                                                <?php endforeach ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <span>Added by: <span class="fst-italic fw-bold"><?= $work['added_by'] ?></span></span>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                    <!-- TAB FOR RECENTLY ADDED WORK QUEUES -->

                                    <!-- TAB FOR RECENTLY COMPLIED WORK QUEUES -->
                                    <div class="tab-pane fade" id="pills-complied" role="tabpanel" aria-labelledby="pills-complied-tab" tabindex="0">
                                        <?php foreach ($recentlyComplied as $work) : ?>
                                            <div class="row mb-2 border">
                                                <div class="col-9 my-1">
                                                    <div class="row d-flex align-items-center justify-content-start">
                                                        <span class="fw-bold ">Subject: <span style="text-decoration: underline;"><?= $work['subject'] ?></span></span>
                                                    </div>
                                                    <div class="row mb-2 d-flex align-items-center justify-content-start">

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-3 d-flex align-items-center" style="width: fit-content;">
                                                            <span>Assigned to: </span>
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="row mb-1">
                                                                <?php foreach ($work['assignment'] as $assigned) : ?>
                                                                    <div class="col-1 me-3">
                                                                        <img class="border-dark border-2 rounded-1 border" src="/profile/<?php echo $assigned[1]['picture'] ?>" alt="" style=" border-radius:10px; height:50px; width:50px">
                                                                    </div>
                                                                <?php endforeach ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <span>Added by: <span class="fst-italic fw-bold"><?= $work['added_by'] ?></span></span>
                                                    </div>
                                                </div>
                                                <div class="col-3 my-1 d-flex align-items-center justify-content-center">
                                                    <?php if ($work['timeliness'] == "Early") : ?>
                                                        <span class="fw-bold ">Timeliness: <span class="fst-italic" style="color:green"><?= $work['timeliness'] ?></span></span>
                                                    <?php elseif ($work['timeliness'] == "On Time") : ?>
                                                        <span class="fw-bold ">Timeliness: <span class="fst-italic" style="color:orange"><?= $work['timeliness'] ?></span></span>
                                                    <?php elseif ($work['timeliness'] == "Late") : ?>
                                                        <span class="fw-bold ">Timeliness: <span class="fst-italic" style="color:red"><?= $work['timeliness'] ?></span></span>
                                                    <?php else : ?>
                                                        <span class="fw-bold "><span class="fst-italic" style="color:none">No Target Date</span></span>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                    <!-- TAB FOR RECENTLY COMPLIED WORK QUEUES -->

                                    <!-- TAB FOR WORK QUEUES THAT ARE FOR UPDATE -->
                                    <div class="tab-pane fade" id="pills-update" role="tabpanel" aria-labelledby="pills-update-tab" tabindex="0">
                                        <?php foreach ($followUp as $work) : ?>
                                            <div class="row mb-2 border">
                                                <div class="col-12 my-1">
                                                    <div class="row mb-2 d-flex align-items-center justify-content-start">
                                                        <span class="fw-bold ">Subject: <span style="text-decoration: underline;"><?= $work['subject'] ?></span></span>
                                                    </div>
                                                    <div class="row mb-2 ">
                                                        <div class="col-3 d-flex align-items-center" style="width: fit-content;">
                                                            <span>Assigned to: </span>
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="row mb-1">
                                                                <?php foreach ($work['assignment'] as $assigned) : ?>
                                                                    <div class="col-1 me-3">
                                                                        <img class="border-dark border-2 rounded-1 border" src="/profile/<?php echo $assigned[1]['picture'] ?>" alt="" style=" border-radius:10px; height:50px; width:50px">
                                                                    </div>
                                                                <?php endforeach ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <span>Added by: <span class="fst-italic fw-bold"><?= $work['added_by'] ?></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                    <!-- TAB FOR WORK QUEUES THAT ARE FOR UPDATE -->

                                    <!-- TAB FOR WORK QUEUES THAT ARE NEAR DEADLINE -->
                                    <div class="tab-pane fade" id="pills-deadline" role="tabpanel" aria-labelledby="pills-deadline-tab" tabindex="0">
                                        <?php foreach ($deadline as $work) : ?>
                                            <div class="row mb-2 border">
                                                <div class="col-12 my-1">
                                                    <div class="row mb-2 d-flex align-items-center justify-content-start">
                                                        <span class="fw-bold ">Subject: <span style="color:red; text-decoration:underline"><?= $work['subject'] ?></span> </span>
                                                    </div>
                                                    <div class="row mb-2 ">
                                                        <div class="col-3 d-flex align-items-center" style="width: fit-content;">
                                                            <span>Assigned to: </span>
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="row mb-1">
                                                                <?php foreach ($work['assignment'] as $assigned) : ?>
                                                                    <div class="col-1 me-3">
                                                                        <img class="border-dark border-2 rounded-1 border" src="/profile/<?php echo $assigned[1]['picture'] ?>" alt="" style=" border-radius:10px; height:50px; width:50px">
                                                                    </div>
                                                                <?php endforeach ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <span>Added by: <span class="fst-italic fw-bold"><?= $work['added_by'] ?></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                    <!-- TAB FOR WORK QUEUES THAT ARE NEAR DEADLINE -->

                                    <!-- TAB FOR WORK QUEUES THAT ARE PENDING APPROVAL -->
                                    <div class="tab-pane fade" id="pills-approval" role="tabpanel" aria-labelledby="pills-approval-tab" tabindex="0">
                                        <?php foreach ($pending as $work) : ?>
                                            <div class="row mb-2 border">
                                                <div class="col-12 my-1">
                                                    <div class="row mb-2 d-flex align-items-center justify-content-start">
                                                        <span class="fw-bold ">Subject: <span style="text-decoration: underline;"><?= $work['subject'] ?></span></span>
                                                    </div>
                                                    <div class="row mb-2 ">
                                                        <div class="col-3 d-flex align-items-center">
                                                            <span>Assigned to: </span>
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="row mb-1">
                                                                <?php foreach ($work['assignment'] as $assigned) : ?>
                                                                    <div class="col-1 me-3">
                                                                        <img class="border-dark border-2 rounded-1 border" src="/profile/<?php echo $assigned[1]['picture'] ?>" alt="" style=" border-radius:10px; height:50px; width:50px">
                                                                    </div>
                                                                <?php endforeach ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <span>Added by: <span class="fst-italic fw-bold"><?= $work['added_by'] ?></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>

                                </div>
                            </div>
                            <!-- TABS -->
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row mb-2 pt-5">
                            <span class="fw-bold fs-6">Updates for Today:</span>
                        </div>
                        <div class="row overflow-y-scroll pe-1 ps-3 align-content-start" style="height:270px">
                            <?php foreach ($updatesToday as $update) : ?>
                                <div class="row border border-2 py-1 border align-content-start mb-2">
                                    <div class="col-9">
                                        <div class="row mb-1">
                                            <span class="fw-bold">Subject: <span><?= $update['mainWork'] ?></span> </span>
                                            <?php if ($update['subWork'] != "") : ?>
                                                <span> <span class="fw-bold"> For Sub-work: </span> <?= $update['subWork'] ?></span>
                                            <?php endif ?>


                                        </div>
                                        <div class="row mb-1">
                                            <span><span class="fw-bold">Remarks: </span><?= $update['remarks'] ?></span>
                                        </div>
                                        <div class="row">
                                            <span class="">Updated by: <span class="fw-bold fst-italic"><?= $update['name'] ?></span></span>
                                        </div>
                                    </div>
                                    <div class="col-3 d-flex align-items-center justify-content-center">
                                        <span class=" fst-italic" style="color:green"><?= $update['compliance'] ?></span>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<?php
include $this->resolve("partials/_footer.php");
?>