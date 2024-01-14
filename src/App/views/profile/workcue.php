<?php
include $this->resolve("partials/_header.php");

?>
<section class="m-2">
    <div class="row m-2">
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
        <div class="col-9 ">
            <div class="row">
                <h3 class="text-center">WORK DETAILS</h3>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row border shadow-lg rounded px-2 mx-2 justify-content-center overflow-y-scroll overflow-x-hidden" style="height: 830px;">
                        <div class="row mb-2" style="height:fit-content;">
                            <div class="col-7">
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="" class="form-label fs-5">Subject:</label>
                                        <input class="form-control" type="text" disabled value="This is Jus a Sample Work Queue">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label for="" class="form-label fs-5">Added by:</label>
                                        <input class="form-control" type="text" disabled value="Sgt Naya PAF">
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label fs-5">Work Type:</label>
                                        <input class="form-control" type="text" disabled value="Routine">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="" class="form-label fs-5">Remarks:</label>
                                        <textarea class="form-control" name="" id="" cols="20" rows="5" disabled>This is a text sample of a remarks</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="row">
                                    <span class="fs-5">Added to:</span>
                                </div>
                                <div class="row overflow-y-scroll" style="height: 320px;">
                                    <?php for ($y = 1; $y < 5; $y++) : ?>
                                        <div class="row mb-2">
                                            <div class="col-4">
                                                <img class="border view_personnel_work img-fluid " type="button" id="view_personnel_work" src="data:image/jpeg;base64,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" onerror="this.src='../pictures/generic/imageplaceholder.png';" alt="" style=" height: 60px; width: 60px;">
                                            </div>
                                            <div class="col-8 d-grid align-items-center">
                                                <span>Sgt Naya PAF</span>
                                            </div>
                                        </div>
                                    <?php endfor ?>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2" style="height:fit-content;">
                            <div class="col-4">
                                <label for="" class="form-label fs-5">Date Added:</label>
                                <input class="form-control" type="text" disabled value="24-January-2024">
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label fs-5">Last Update:</label>
                                <input class="form-control" type="text" disabled value="25-January-2024">
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label fs-5">Target Date:</label>
                                <input class="form-control" type="text" disabled value="29-January-2024">
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-4">
                                <div class="row">
                                    <span for="" class="form-label fs-5">File Reference/s:</span>
                                </div>
                                <div class="row overflow-y-scroll text-center" style="height: 100px;">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <button class="btn btn-secondary" type="button" value="">File Number 1</button>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <button class="btn btn-secondary" type="button" value="">File Number 2</button>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <button class="btn btn-secondary" type="button" value="">File Number 3</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <span for="" class="form-label fs-5">Actions:</span>
                                </div>
                                <div class="row mt-2">
                                    <div class="row mb-3 justify-content-center text-center">
                                        <div class="col-6 mb-2 d-grid">
                                            <button class="btn btn-success" type="button" value="" disabled>Comply</button>
                                        </div>
                                        <div class="col-6 mb-2 d-grid">
                                            <button class="btn btn-secondary" type="button" value="">Update</button>
                                        </div>
                                        <div class="col-6 d-grid">
                                            <button class="btn btn-primary" type="button" value="">Edit</button>
                                        </div>
                                        <div class="col-6 d-grid">
                                            <button class="btn btn-danger" type="button" value="">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row">
                                <span for="" class="form-label fs-5">Sub Work:</span>
                            </div>
                            <div class="row-fluid">
                                <div class="row overflow-y-scroll pe-5 overflow-x-hidden align-content-start" style="height: 300px;">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="row">
                                                <?php for ($zf = 0; $zf < 5; $zf++) : ?>

                                                    <div class="row border shadow-lg rounded mx-4 mb-2" style="height: fit-content;">
                                                        <div class="row">
                                                            <div class="col">
                                                                <span class="fs-5 fw-bold">This is just a sample Sub-work</span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <span>Assigned to:</span>
                                                        </div>
                                                        <div class="row d-flex mb-2">
                                                            <div class="col">Sgt Naya PAF</div>
                                                            <div class="col">Sgt Naya PAF</div>
                                                            <div class="col">Sgt Naya PAF</div>
                                                            <div class="col">Sgt Naya PAF</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3 mb-2 d-grid">
                                                                <button class="btn btn-success" type="button" value="" disabled>Comply</button>
                                                            </div>
                                                            <div class="col-3 mb-2 d-grid">
                                                                <button class="btn btn-secondary" type="button" value="">Update</button>
                                                            </div>
                                                            <div class="col-3 mb-2 d-grid">
                                                                <button class="btn btn-primary" type="button" value="">Edit</button>
                                                            </div>
                                                            <div class="col-3 mb-2 d-grid">
                                                                <button class="btn btn-danger" type="button" value="">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endfor ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-6">
                    <div class="row border shadow-lg rounded ps-1 mx-2 justify-content-center overflow-y-scroll overflow-x-hidden" style="height: 770px;">

                        <div class="row pt-4 align-content-start">
                            <div class="row ps-2 d-grid align-items-start">
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#generalupdate" aria-expanded="false" aria-controls="generalupdate">
                                            View
                                        </button>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <span class="fs-6 fw-bold">General Work Updates:</span>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse border rounded" id="generalupdate">
                                    <div class="row overflow-y-scroll overflow-x-hidden pe-4" style="height: 400px;">
                                        <?php for ($z = 0; $z < 5; $z++) : ?>
                                            <div class="row border shadow-lg rounded ms-2 ps-3 pt-2 mb-3" style="height: fit-content;">
                                                <div class="row">
                                                    <span class="fw-bold">Sub Work: This is a Sample Sub Work</span>
                                                </div>
                                                <div class="row border-bottom pb-2 mb-2">
                                                    <p>This is just a Sample Remarks</p>
                                                    <div class="row">
                                                        <div class="col">
                                                            <span>File/s:</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 text-center justify-content-center">
                                                        <div class="col-4 d-grid">
                                                            <button class="btn btn-secondary" type="button" value="">1</button>
                                                        </div>
                                                        <div class="col-4 d-grid">
                                                            <button class="btn btn-secondary" type="button" value="">1</button>
                                                        </div>
                                                        <div class="col-4 d-grid">
                                                            <button class="btn btn-secondary" type="button" value="">1</button>
                                                        </div>
                                                    </div>
                                                    <span>Updated by: Sgt Naya PAF</span>
                                                </div>
                                                <div class="row mb-2">
                                                    <span>Date: 24 January 2024</span>
                                                </div>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3 ps-2 d-grid align-items-start">
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample1">
                                            View
                                        </button>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <span class="fs-6 fw-bold">This is a sample Sub Work:</span>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse border rounded" id="collapseExample1">
                                    <div class="row overflow-y-scroll overflow-x-hidden pe-4" style="height: 400px;">
                                        <?php for ($z = 0; $z < 5; $z++) : ?>
                                            <div class="row border shadow-lg rounded ms-2 ps-3 pt-2 mb-3" style="height: fit-content;">
                                                <div class="row border-bottom pb-2 mb-2">
                                                    <p>This is just a Sample Remarks</p>
                                                    <div class="row">
                                                        <div class="col">
                                                            <span>File/s:</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 text-center justify-content-center">
                                                        <div class="col-4 d-grid">
                                                            <button class="btn btn-secondary" type="button" value="">1</button>
                                                        </div>
                                                        <div class="col-4 d-grid">
                                                            <button class="btn btn-secondary" type="button" value="">1</button>
                                                        </div>
                                                        <div class="col-4 d-grid">
                                                            <button class="btn btn-secondary" type="button" value="">1</button>
                                                        </div>
                                                    </div>
                                                    <span>Updated by: Sgt Naya PAF</span>
                                                </div>
                                                <div class="row mb-2">
                                                    <span>Date: 24 January 2024</span>
                                                </div>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-3 ps-2 d-grid align-items-start">
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
                                            View
                                        </button>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <span class="fs-6 fw-bold">Procurement of CG's Gift and memento:</span>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse border rounded" id="collapseExample2">
                                    <div class="row overflow-y-scroll overflow-x-hidden pe-4" style="height: 400px;">
                                        <?php for ($z = 0; $z < 5; $z++) : ?>
                                            <div class="row border shadow-lg rounded ms-2 ps-3 pt-2 mb-3" style="height: fit-content;">
                                                <div class="row border-bottom pb-2 mb-2">
                                                    <p>This is just a Sample Remarks</p>
                                                    <div class="row">
                                                        <div class="col">
                                                            <span>File/s:</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 text-center justify-content-center">
                                                        <div class="col-4 d-grid">
                                                            <button class="btn btn-secondary" type="button" value="">1</button>
                                                        </div>
                                                        <div class="col-4 d-grid">
                                                            <button class="btn btn-secondary" type="button" value="">1</button>
                                                        </div>
                                                        <div class="col-4 d-grid">
                                                            <button class="btn btn-secondary" type="button" value="">1</button>
                                                        </div>
                                                    </div>
                                                    <span>Updated by: Sgt Naya PAF</span>
                                                </div>
                                                <div class="row mb-2">
                                                    <span>Date: 24 January 2024</span>
                                                </div>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row px-4 mt-4">
                        <a class="btn btn-primary" href="/profile">BACK</a>
                    </div>
                </div>
            </div>

        </div>


    </div>
</section>

<?php
include $this->resolve("partials/_footer.php");
?>