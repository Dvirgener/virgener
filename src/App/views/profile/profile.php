<?php

use App\config\paths;

include $this->resolve("partials/_header.php");
?>
<section class="m-2">
    <div class="row m-2 justify-content-between">
        <div class="col-3">
            <div class="row">
                <h3 class="text-center">USER PROFILE</h3>
            </div>
            <div class="row text-center border shadow-lg rounded px-2 mx-2 justify-content-center align-content-start" style="height: 830px;">
                <div class="row-fluid justify-content-center mt-2 ">
                    <img class="border rounded" src="/profile/<?php echo $user['picture'] ?>" alt="" style=" border-radius:10px; height:200px; width:200px">
                    <img src="C:/xampp/htdocs/virgener/storage/ProfPic/aw.png" alt="">
                </div>
                <div class="row text-center mt-2">
                    <span class="fw-bold fs-5"><?= $fullName ?></span>
                </div>
                <div class="row text-center mt-2">
                    <?php
                    $statusBG = "red";
                    if ($user['status'] == "ON DUTY") {
                        $statusBG = "green";
                    }

                    ?>
                    <span>Duty Status: <span class="fw-bold" style="color:<?= $statusBG ?>"><?php echo $user['status'] ?></span></span>
                </div>
                <div class="row text-center mt-2">
                    <div class="row">
                        <u class="">Active Work Queue</u>
                    </div>
                    <div class="row">
                        <h5 class="fw-bold">6</h5>
                    </div>
                    <div class="row">
                        <u class="">For Update</u>
                    </div>
                    <div class="row">
                        <h5 class="fw-bold">3</h5>
                    </div>
                    <div class="row">
                        <u class="">Deadline</u>
                    </div>
                    <div class="row">
                        <h5 class="fw-bold">2</h5>
                    </div>
                </div>
                <div class="row mb-4 text-center">
                    <div class="row mb-2 ps-4">
                        <span class="fw-bold">Office Designation:</span>
                    </div>
                    <div class="row overflow-y-scroll me-5" style="height:70px ">
                        <?php
                        $section = unserialize($user['section']);
                        foreach ($finalSec as $key => $value) :
                        ?>
                            <div class=" row text-start">
                                <span><span class="fw-bold"><?= $key ?></span> - <?= $value ?></span>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="row text-center justify-content-center">
                    <div class="row mb-3 px-4">
                        <button class="btn btn-primary buttonzoom clicked" id="myworkqueuebut" value="myworkqueuebut">Add Work Queue</button>
                    </div>
                    <div class="row mb-3 px-4">
                        <button class="btn btn-primary buttonzoom clicked" id="myworkqueuebut" value="myworkqueuebut">Duty Status</button>
                    </div>
                    <div class="row mb-3 px-4">
                        <button class="btn btn-primary buttonzoom clicked" id="myworkqueuebut" value="myworkqueuebut">Add Work Queue</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 ">
            <div class="row  justify-content-center ">
                <div class="row">
                    <h3 class="text-center">DIRECTED WORK</h3>
                </div>
                <div class="row mx-2 py-4 pe-4 overflow-y-scroll overflow-x-hidden border shadow-lg rounded" style="height: 400px;">
                    <?php for ($x = 1; $x < 4; $x++) : ?>
                        <div class="card shadow m-2" style="width: 100%; background-color:red; color:white">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    <?php endfor ?>
                    <?php for ($x = 1; $x < 4; $x++) : ?>
                        <div class="card shadow m-2" style="width: 100%; background-color:orange; color:black">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    <?php endfor ?>
                </div>
                <div class="row">
                    <h3 class="text-center">SECTION WORK</h3>
                </div>
                <div class="row mx-2 py-4 pe-4 overflow-y-scroll overflow-x-hidden border shadow-lg rounded" style="height: 390px;">
                    <?php for ($x = 1; $x < 4; $x++) : ?>
                        <div class="card shadow m-2" style="width: 100%; background-color:red; color:white">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    <?php endfor ?>
                    <?php for ($x = 1; $x < 4; $x++) : ?>
                        <div class="card shadow m-2" style="width: 100%; background-color:orange; color:black">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    <?php endfor ?>
                </div>
            </div>
        </div>
        <div class="col-4">

            <div class=" pe-2 row  justify-content-center ">
                <div class="row">
                    <h3 class="text-center">ADDED WORK</h3>
                </div>
                <div class="row mx-2 py-4 pe-4 overflow-y-scroll overflow-x-hidden border shadow-lg rounded" style="height: 400px;">
                    <?php for ($x = 1; $x < 4; $x++) : ?>
                        <div class="card shadow m-2" style="width: 100%; background-color:red; color:white">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    <?php endfor ?>
                    <?php for ($x = 1; $x < 4; $x++) : ?>
                        <div class="card shadow m-2" style="width: 100%; background-color:orange; color:black">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    <?php endfor ?>
                </div>
                <div class="row">
                    <h3 class="text-center">HISTORY</h3>
                </div>
                <div class="row mx-2 py-4 pe-4 overflow-y-scroll overflow-x-hidden border shadow-lg rounded" style="height: 390px;">
                    <?php for ($x = 1; $x < 4; $x++) : ?>
                        <div class="card shadow m-2" style="width: 100%; background-color:red; color:white">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    <?php endfor ?>
                    <?php for ($x = 1; $x < 4; $x++) : ?>
                        <div class="card shadow m-2" style="width: 100%; background-color:orange; color:black">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    <?php endfor ?>
                </div>
            </div>

        </div>

    </div>
</section>

<?php
include $this->resolve("partials/_footer.php");
?>