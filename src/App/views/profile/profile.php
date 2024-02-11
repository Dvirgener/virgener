<?php
include $this->resolve("partials/_header.php");

?>

<!-- THIS IS THE SCRIPT TO LOAD GOOGLE CHARTS API -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- THIS IS THE SCRIPT FOR THE USER STATISTICS -->
<script type="text/javascript">
    google.charts.load("current", {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Element", "Density", {
                role: "style"
            }],
            ["No TD", <?= $workTimeliness['noTD'] ?>, "#b87333"],
            ["Early", <?= $workTimeliness['early'] ?>, "green"],
            ["On Time", <?= $workTimeliness['onTime'] ?>, "gold"],
            ["Late", <?= $workTimeliness['late'] ?>, "red"]
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            },
            2
        ]);

        var options = {
            title: "",
            width: 600,
            height: 300,
            chartArea: {
                left: 50,
                top: 50,
                width: '100%',
                height: '55%'
            },
            bar: {
                groupWidth: "90%"
            },
            legend: {
                position: "none"
            },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }
</script>
<!-- THIS IS THE SCRIPT FOR THE USER STATISTICS -->


<!--  THIS IS USED TO LOAD PROFILE.JS -->
<script src="/assets/profile.js"></script>

<!-- THIS ARE HIDDEN INPUTS USED TO IDENTIFY USER BEING VIEWED AND WHERE THE PROFILE IS BEING VIEWED -->
<input type="hidden" id="profileId" value="<?= $user['id'] ?>">
<input type="hidden" id="viewedFrom" value="<?= $viewedFrom ?>">


<section class="mt-4">
    <div class="row mx-3">
        <div class="col-12 col-md-4">
            <div class="row">
                <div class="border p-2 bg-light border-2 border-dark shadow rounded-4">

                    <!-- THIS IS FOR THE USER DETAILS ROW -->
                    <div class="row">
                        <div class="col-12 col-md-4 text-center text-md-start">
                            <img class="border-dark border-2 rounded-4" src="/profile/<?php echo $user['picture'] ?>" alt="" style=" border-radius:10px; height:100%; width:100%">
                        </div>
                        <div class="col-12 col-md-8 text-center text-md-start">

                            <!-- DISPLAY FULL NAME OF THE USER -->
                            <div class="row">
                                <span class="fs-5 fw-bold"> <?= $fullName ?></span>
                            </div>
                            <div class="row border-bottom border-dark ms-0 me-4">
                            </div>

                            <!-- DISPLAY OFFICE OF THE USER (CAN BE DYNAMIC IN THE FUTURE) -->
                            <div class="row">
                                <span class="fw-bold">Office of the Directorate for Logistics</span>
                            </div>

                            <!-- DISPLAY THE DUTY STATUS OF THE USER -->
                            <div class="row mb-4">
                                <?php
                                $statusBG = "red";
                                if ($user['status'] == "ON DUTY") {
                                    $statusBG = "green";
                                }
                                ?>
                                <span>Duty Status: <span class="fw-bold" style="color:<?= $statusBG ?>"><?php echo $user['status'] ?></span></span>
                            </div>
                            <!-- DISPLAY THE DUTY STATUS OF THE USER -->

                            <div class="row mb-1">
                                <span class="fw-bold text-start">Office Designation:</span>
                            </div>

                            <!-- IF STATEMENT TO DETERMINE WHERE THE PROFILE IS BEING VIEWED -->
                            <?php if ($viewedFrom == "dashboard") : ?>

                                <!-- IF THE PROFILE IS BEING VIEWED ON THE DASHBOARD, DISPLAY USER'S SECTION -->
                                <div class="row">
                                    <?php
                                    foreach ($user['finalsec'] as $key => $value) :
                                    ?>
                                        <div class=" row text-start">
                                            <span><span class="fw-bold"><?= $key ?></span> - <?= $value ?></span>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                                <!-- IF THE PROFILE IS BEING VIEWED ON THE DASHBOARD, DISPLAY USER'S SECTION -->

                            <?php elseif ($viewedFrom == "profile") : ?>

                                <!-- IF THE PROFILE IS BEING VIEWED ON THE PROFILE PAGE, CHECK FOR THE POSITION OF THE LOGGED USER -->
                                <?php if ($_SESSION['user']['position'] == "OIC") : ?>
                                    <div class="row">
                                        <span>DIRECTOR FOR LOGISTICS</span>
                                    </div>
                                <?php elseif ($_SESSION['user']['position'] == "AOIC") : ?>
                                    <div class="row">
                                        <span>ASST DIRECTOR FOR LOGISTICS</span>
                                    </div>
                                <?php else : ?>
                                    <div class="row">
                                        <?php
                                        foreach ($user['finalsec'] as $key => $value) :
                                        ?>
                                            <div class=" row text-start">
                                                <span><span class="fw-bold"><?= $key ?></span> - <?= $value ?></span>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>
                                <!-- IF THE PROFILE IS BEING VIEWED ON THE PROFILE PAGE, CHECK FOR THE POSITION OF THE LOGGED USER -->

                            <?php endif ?>
                            <!-- IF STATEMENT TO DETERMINE WHERE THE PROFILE IS BEING VIEWED -->

                        </div>
                    </div>
                    <!-- THIS IS FOR THE USER DETAILS ROW -->

                    <div class="row border-bottom border-dark border-2 mx-1 mt-1">
                    </div>

                    <!-- THIS IS FOR THE USER'S WORK QUEUE NUMBERS -->
                    <div class="row">
                        <div class="col-6">
                            <div class="row text-start">
                                <span class="fw-bold fs-6">Personal Work</span>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <span class="fs-6">Active Work</span>
                                </div>
                                <div class="col-1">
                                    <span>:</span>
                                </div>
                                <div class="col-3 text-center">
                                    <span class="fw-bold"><?= $workCount['active'] ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <span class="fs-6">Pending Approval</span>
                                </div>
                                <div class="col-1">
                                    <span class="fs-6">:</span>
                                </div>
                                <div class="col-3 text-center">
                                    <span class="fw-bold"><?= $pending ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <span class="fs-6 text-secondary">Needs Update</span>
                                </div>
                                <div class="col-1">
                                    <span class="fs-6 text-secondary">:</span>
                                </div>
                                <div class="col-3 text-center">
                                    <span class="fw-bold"><?= $workCount['unupdated'] ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <span class="fs-6 text-danger">Near Deadline</span>
                                </div>
                                <div class="col-1">
                                    <span class="fs-6 text-danger">:</span>
                                </div>
                                <div class="col-3 text-center">
                                    <span class="fw-bold text-danger"><?= $workCount['danger'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row text-start">
                                <span class="fw-bold fs-6">Added Work</span>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <span class="fs-6">Active</span>
                                </div>
                                <div class="col-1">
                                    <span>:</span>
                                </div>
                                <div class="col-4 text-center">
                                    <span class="fw-bold"><?= $addedWorkCount['active'] ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <span class="fs-6 text-secondary">Needs Update</span>
                                </div>
                                <div class="col-1">
                                    <span class="fs-6 text-secondary">:</span>
                                </div>
                                <div class="col-4 text-center">
                                    <span class="fw-bold"><?= $addedWorkCount['unupdated'] ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <span class="fs-6 text-danger">Near Deadline</span>
                                </div>
                                <div class="col-1">
                                    <span class="fs-6 text-danger">:</span>
                                </div>
                                <div class="col-4 text-center">
                                    <span class="fw-bold text-danger"><?= $addedWorkCount['danger'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- THIS IS FOR THE USER'S WORK QUEUE NUMBERS -->

                </div>
            </div>

            <!-- CHECK WHERE THE PROFILE IS BEING VIEWED -->
            <?php if ($viewedFrom == "dashboard") : ?>
                <div class="row mt-3">
                    <div class="col-12 col-md-4">
                        <a class="btn btn-secondary" href="/">BACK</a>
                    </div>
                    <div class="row">
                        <div class="row mt-2 ">
                            <span class="fw-bold">TIMELINESS OF WORK COMPLIANCE:</span>
                        </div>
                        <div class="row">
                            <div id="columnchart_values" style="width: 900px; height: 300px;"></div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <!-- // * ADD WORK QUEUE AND ACTIVITIES BUTTONS -->
                <div class="row mt-3 mb-3">
                    <div class="col-6 d-grid ">
                        <button class="btn btn-outline-primary shadow text-start" data-bs-toggle="modal" data-bs-target="#addWorkModal">
                            <div class="row">
                                <div class="text-center col-12 col-md-2">
                                    <svg xmlns=" http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="-2 0 20 18">
                                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0" />
                                    </svg>
                                </div>
                                <div class="text-center col-12 col-md-9 d-flex align-items-center justify-content-center d-inline d-md-none">
                                    <span style="font-size:x-small">ADD WORK QUEUE</span>
                                </div>
                                <div class="text-start col-md-9  align-items-center d-none d-md-flex">
                                    <span style="font-size:medium">ADD WORK QUEUE</span>
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="col-6 d-grid ">
                        <button class="btn btn-outline-primary shadow text-start" data-bs-toggle="modal" data-bs-target="#addWorkModal">
                            <div class="row">
                                <div class="text-center col-12 col-md-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-calendar-plus-fill" viewBox="-2 0 20 18">
                                        <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M8.5 8.5V10H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V11H6a.5.5 0 0 1 0-1h1.5V8.5a.5.5 0 0 1 1 0" />
                                    </svg>
                                </div>
                                <div class="text-center col-12 col-md-9 d-flex align-items-center justify-content-center d-inline d-md-none">
                                    <span style="font-size:x-small">ADD ACTIVITY</span>
                                </div>
                                <div class="text-start col-md-9  align-items-center d-none d-md-flex">
                                    <span style="font-size:medium">ADD ACTIVITY</span>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- // * WORK QUEUE AND ACTIVITIES BUTTONS -->
                <div class="row mb-3">
                    <div class="col-6 d-grid ">
                        <a class="btn btn-outline-primary shadow text-start" href="/profile">
                            <div class="row">
                                <div class="text-center col-12 col-md-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-file-earmark-fill" viewBox="-2 0 20 18">
                                        <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2z" />
                                    </svg>
                                </div>
                                <div class="text-center col-12 col-md-9 d-flex align-items-center justify-content-center d-inline d-md-none">
                                    <span style="font-size:x-small">WORK QUEUE</span>
                                </div>
                                <div class="text-start col-md-9  align-items-center d-none d-md-flex">
                                    <span style="font-size:medium">WORK QUEUE</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 d-grid ">
                        <a class="btn btn-outline-primary shadow text-start" href="#">
                            <div class="row">
                                <div class="text-center col-12 col-md-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-calendar-event-fill" viewBox="-2 0 20 18">
                                        <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-3.5-7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                </div>
                                <div class="text-center col-12 col-md-9 d-flex align-items-center justify-content-center d-inline d-md-none">
                                    <span style="font-size:x-small">ACTIVITIES</span>
                                </div>
                                <div class="text-start col-md-9  align-items-center d-none d-md-flex">
                                    <span style="font-size:medium">ACTIVITIES</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- // * WORK AND ACTIVITIES HISTORY BUTTONS -->
                <div class="row mb-3">
                    <div class="col-6 d-grid ">
                        <a class="btn btn-outline-primary shadow text-start" href="/history">
                            <div class="row">
                                <div class="text-center col-12 col-md-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-clock-history" viewBox="-2 0 20 18">
                                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                                        <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                </div>
                                <div class="text-center col-12 col-md-9 d-flex align-items-center justify-content-center d-inline d-md-none">
                                    <span style="font-size:x-small">WORK HISTORY</span>
                                </div>
                                <div class="text-start col-md-9  align-items-center d-none d-md-flex">
                                    <span style="font-size:medium">WORK HISTORY</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 d-grid ">
                        <a class="btn btn-outline-primary shadow text-start" href="/history">
                            <div class="row">
                                <div class="text-center col-12 col-md-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 20 18">
                                        <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                    </svg>
                                </div>
                                <div class="text-center col-12 col-md-9 d-flex align-items-center justify-content-center d-inline d-md-none">
                                    <span style="font-size:x-small">ACTIVITIES HISTORY</span>
                                </div>
                                <div class="text-start col-md-9  align-items-center d-none d-md-flex">
                                    <span style="font-size:medium">ACTIVITIES HISTORY</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- // * DUTY STATUS AND PROFILE SETTINGS BUTTONS -->
                <div class="row mb-3">
                    <div class="col-6 d-grid ">
                        <a class="btn btn-outline-primary shadow text-start" href="#">
                            <div class="row">
                                <div class="text-center col-12 col-md-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-airplane" viewBox="-2 0 20 18">
                                        <path d="M6.428 1.151C6.708.591 7.213 0 8 0s1.292.592 1.572 1.151C9.861 1.73 10 2.431 10 3v3.691l5.17 2.585a1.5 1.5 0 0 1 .83 1.342V12a.5.5 0 0 1-.582.493l-5.507-.918-.375 2.253 1.318 1.318A.5.5 0 0 1 10.5 16h-5a.5.5 0 0 1-.354-.854l1.319-1.318-.376-2.253-5.507.918A.5.5 0 0 1 0 12v-1.382a1.5 1.5 0 0 1 .83-1.342L6 6.691V3c0-.568.14-1.271.428-1.849m.894.448C7.111 2.02 7 2.569 7 3v4a.5.5 0 0 1-.276.447l-5.448 2.724a.5.5 0 0 0-.276.447v.792l5.418-.903a.5.5 0 0 1 .575.41l.5 3a.5.5 0 0 1-.14.437L6.708 15h2.586l-.647-.646a.5.5 0 0 1-.14-.436l.5-3a.5.5 0 0 1 .576-.411L15 11.41v-.792a.5.5 0 0 0-.276-.447L9.276 7.447A.5.5 0 0 1 9 7V3c0-.432-.11-.979-.322-1.401C8.458 1.159 8.213 1 8 1s-.458.158-.678.599" />
                                    </svg>
                                </div>
                                <div class="text-center col-12 col-md-9 d-flex align-items-center justify-content-center d-inline d-md-none">
                                    <span style="font-size:x-small">DUTY STATUS</span>
                                </div>
                                <div class="text-start col-md-9  align-items-center d-none d-md-flex">
                                    <span style="font-size:medium">DUTY STATUS</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 d-grid ">
                        <a class="btn btn-outline-primary shadow text-start" href="/settings">
                            <div class="row">
                                <div class="text-center col-12 col-md-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-gear-fill" viewBox="-2 0 20 18">
                                        <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                                    </svg>
                                </div>
                                <div class="text-center col-12 col-md-9 d-flex align-items-center justify-content-center d-inline d-md-none">
                                    <span style="font-size:x-small">PROFILE SETTINGS</span>
                                </div>
                                <div class="text-start col-md-9  align-items-center d-none d-md-flex">
                                    <span style="font-size:medium">PROFILE SETTINGS</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- // * TOP SPEED AND EDFS BUTTONS -->
                <div class="row mb-3">
                    <div class="col-6 d-grid ">
                        <a class="btn btn-outline-primary shadow text-start" href="#">
                            <div class="row">
                                <div class="text-center col-12 col-md-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-envelope" viewBox="0 0 20 18">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                    </svg>
                                </div>
                                <div class="text-center col-12 col-md-9 d-flex align-items-center justify-content-center d-inline d-md-none">
                                    <span style="font-size:x-small">PAF TOP SPEED</span>
                                </div>
                                <div class="text-start col-md-9  align-items-center d-none d-md-flex">
                                    <span style="font-size:medium">PAF TOP SPEED</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 d-grid ">
                        <a class="btn btn-outline-primary shadow text-start" href="#">
                            <div class="row">
                                <div class="text-center col-12 col-md-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-file-earmark-diff-fill" viewBox="-2 0 20 18">
                                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M8 6a.5.5 0 0 1 .5.5V8H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V9H6a.5.5 0 0 1 0-1h1.5V6.5A.5.5 0 0 1 8 6m-2.5 6.5A.5.5 0 0 1 6 12h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5" />
                                    </svg>
                                </div>
                                <div class="text-center col-12 col-md-9 d-flex align-items-center justify-content-center d-inline d-md-none">
                                    <span style="font-size:x-small">PAF EDFS</span>
                                </div>
                                <div class="text-start col-md-9  align-items-center d-none d-md-flex">
                                    <span style="font-size:medium">PAF EDFS</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endif ?>
            <!-- CHECK WHERE THE PROFILE IS BEING VIEWED -->

        </div>

        <!-- THIS IS FOR THE WORK LIST PORTION THIS IS WHERE WORK LIST ARE LOADED  -->
        <div class="col-12 col-md-8" id="pageLoader">
        </div>
        <!-- THIS IS FOR THE WORK LIST PORTION THIS IS WHERE WORK LIST ARE LOADED  -->

    </div>
</section>
<?php
include $this->resolve("partials/_modals.php");
include $this->resolve("partials/_footer.php");
?>