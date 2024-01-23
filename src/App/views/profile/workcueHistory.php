<?php
include $this->resolve("partials/_header.php");
?>
<section class="mt-4">

    <div class="row mx-3">
        <div class="col-4">
            <?php
            include $this->resolve("partials/_profile.php");
            ?>
        </div>

        <div class="col-8">
            <div class="row ms-2 text-center fw-bold">
                <div class="col-11">
                    <h2>COMPLIED WORK DETAILS</h2>
                </div>
                <div class="col-1">
                    <a class="btn btn-secondary" href="/history">
                        BACK
                    </a>

                </div>

            </div>
            <div class="row border-bottom border-dark border-2 mx-2 mb-3">

            </div>
            <div class="row">
                <div class="col-6 d-grid">
                    <div class="row mx-2 text-center">
                        <h4>MAIN WORK</h4>
                    </div>
                    <div class="row overflow-y-scroll overflow-x-hidden align-content-start pe-0" style="height:560px; width:100%">
                        <div class="row mb-2 position-sticky">
                            <div class="col">
                                <label for="" class="form-label fs-6 fw-bold">SUBJECT:</label>
                                <input class="form-control" type="text" disabled value="<?= $workDetails['subject'] ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label fs-6 fw-bold">ADDED BY:</label>
                                <input class="form-control" type="text" disabled value="<?= $workDetails['added_by_name'] ?>">
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label fs-6 fw-bold">WORK TYPE:</label>
                                <input class="form-control" type="text" disabled value="<?= $workDetails['type'] ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="" class="form-label fs-6 fw-bold">INSTRUCTIONS / REMARKS:</label>
                                <textarea class="form-control" name="" id="" cols="20" rows="5" disabled><?= $workDetails['instructions'] ?></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-between ps-2">
                            <div class="col-4">
                                <div class="row">
                                    <span for="" class="form-label fs-6 fw-bold">FILE REFERENCE/S:</span>
                                </div>
                                <div class="row overflow-y-scroll text-center d-flex justify-content-center" style="height: 100px;">
                                    <?php $fileNr = 1;
                                    foreach ($workDetails['files'] as $file) : ?>
                                        <div class="row mb-2 d-flex justify-content-center align-items-start">
                                            <div class="col d-grid">
                                                <button class="btn btn-secondary viewFileBut" type="button" value="<?= $file ?>">File Number <?= $fileNr ?></button>
                                            </div>
                                        </div>
                                    <?php $fileNr += 1;
                                    endforeach ?>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="row text-start">
                                    <span for="" class="form-label fs-6 fw-bold">TIMELINESS:</span>
                                </div>
                                <div class="row d-flex mt-2 mx-2 justify-content-center align-items-start pt-3" style="height: 100%;">
                                    <?php
                                    $style = "";
                                    switch ($workDetails['timeliness']) {
                                        case "Early":
                                            $style = "style='background-color: green; color:white'";
                                            break;
                                        case "On time":
                                            $style = "style='background-color: skyblue; color:black'";
                                            break;
                                        case "Late":
                                            $style = "style='background-color: red; color:white'";
                                            break;
                                    }
                                    ?>
                                    <div class="col text-center align-items-center" <?= $style ?>>
                                        <span class="fw-bold fs-4 text-decoration-underline"><?= $workDetails['timeliness'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2" style="height:fit-content;">
                            <div class="col-6">
                                <label for="" class="form-label fs-6 fw-bold">DATE ADDED:</label>
                                <input class="form-control" type="text" disabled value="<?= $workDetails['created_at'] ?>">
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label fs-6 fw-bold">LAST UPDATE:</label>
                                <input class="form-control" type="text" disabled value="<?= $workDetails['updated_at'] ?>">
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label fs-6 fw-bold">TARGET DATE:</label>
                                <input class="form-control" type="text" disabled value="<?= $workDetails['date_target'] ?>">
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label fs-6 fw-bold">DATE COMPLIED:</label>
                                <input class="form-control" type="text" disabled value="<?= $workDetails['date_complied'] ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <span class="fw-bold">ASSIGNED TO:</span>
                        </div>
                        <div class="row">
                            <?php foreach ($workDetails['detailedAssignee'] as $assigned) : ?>
                                <div class="col-4">
                                    <div class="row mb-3 align-content-start">
                                        <div class="col-5">
                                            <img class="border view_personnel_work img-fluid " type="button" id="view_personnel_work" src="/profile/<?= $assigned['picture'] ?>" onerror="this.src='../pictures/generic/imageplaceholder.png';" alt="" style=" height: 50px; width: 50px;">
                                        </div>
                                        <div class="col-7 d-grid align-items-center">
                                            <span class="" style="font-size:small;"><?= $assigned['name'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>

                        <div class="row">
                            <div class="row mb-3 d-flex align-items-center">
                                <div class="col-3 ">
                                    <span for="" class="form-label fs-6 fw-bold">SUB WORK:</span>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="row-fluid overflow-y-scroll ps-1 overflow-x-hidden align-content-start mb-5" style="height: 410px;">
                                    <div class="row mb-2">
                                        <div class="row">
                                            <?php foreach ($subWorkDetails as $subwork) : ?>
                                                <div class="row-fluid border shadow rounded mx-2 mb-2" style="height: fit-content;">
                                                    <div class="row mb-2">
                                                        <span class="fw-bold">SUBJECT:</span>
                                                    </div>
                                                    <div class="row border-bottom mx-2 mb-2">
                                                        <div class="col">
                                                            <span class="fs-5"><?= $subwork['sub_subject'] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-1">
                                                        <span class="fw-bold">ASSIGNED TO:</span>
                                                    </div>
                                                    <div class="row d-flex mb-2 mx-2">
                                                        <?php foreach ($subwork['assignedNames'] as $names) : ?>
                                                            <div class="col-4" style="font-size: small;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 20 19">
                                                                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                                                                </svg>
                                                                <?= $names ?>
                                                            </div>
                                                        <?php endforeach ?>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row mx-2 text-center">
                        <h4>UPDATES</h4>
                    </div>
                    <div class="row me-2 overflow-y-scroll overflow-x-hidden rounded align-content-start" style="height:560px">
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
                                <div class="collapse" id="generalupdate">
                                    <div class="row overflow-y-scroll overflow-x-hidden pe-4 pt-2" style="height: 400px;">
                                        <?php foreach ($workDetails['updates'] as $update) : ?>
                                            <div class="row border shadow rounded ms-2 ps-3 pt-2 mb-3" style="height: fit-content;">
                                                <div class="row border-bottom pb-2 mb-2">
                                                    <div class="row">
                                                        <span class="fw-bold">Remarks:</span>
                                                    </div>
                                                    <p><?= $update['remarks'] ?></p>
                                                    <div class="row">
                                                        <div class="col">
                                                            <span class="fw-bold">File/s:</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 text-center justify-content-start">
                                                        <?php $subWorkUpdatesNr = 1;
                                                        foreach ($update['files'] as $file) : ?>
                                                            <div class="col-4 d-grid">
                                                                <button class="btn btn-secondary viewFileBut" type="button" value="<?= $file ?>" style="font-size: small;">File Number <?= $subWorkUpdatesNr ?></button>
                                                            </div>
                                                        <?php
                                                            $subWorkUpdatesNr += 1;
                                                        endforeach ?>

                                                    </div>
                                                    <span><span class="fw-bold">Updated by:</span> <?= $update['updated_by'] ?></span>
                                                </div>
                                                <div class="row mb-2">
                                                    <span><span class="fw-bold">Date:</span> <?= $update['created_at'] ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>


                            <?php $id = 1;
                            foreach ($subWorkDetails as $sub_work) : ?>
                                <div class="row mt-3 ps-2 d-grid align-items-start">
                                    <div class="row mb-2">
                                        <div class="col-3" style="color:red">
                                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?= $id ?>" aria-expanded="false" aria-controls="collapseExample<?= $id ?>">
                                                View
                                            </button>
                                        </div>
                                        <div class="col-9 d-flex align-items-center">
                                            <span class="fs-6 fw-bold"><?= $sub_work['sub_subject'] ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="collapse " id="collapseExample<?= $id ?>">
                                        <div class="row overflow-y-scroll overflow-x-hidden pt-2 pe-4" style="height: 400px;">
                                            <?php foreach ($sub_work['updates'] as $updates) : ?>

                                                <div class="row border shadow rounded ms-2 ps-3 pt-2 mb-3" style="height: fit-content;">
                                                    <div class="row border-bottom pb-2 mb-2">
                                                        <div class="row">
                                                            <span class="fw-bold">Remarks:</span>
                                                        </div>
                                                        <p><?= $updates['remarks'] ?></p>
                                                        <div class="row">
                                                            <div class="col">
                                                                <span class="fw-bold">File/s:</span>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2 text-center justify-content-start">
                                                            <?php $subWorkUpdatesNr = 1;
                                                            foreach ($updates['files'] as $file) : ?>
                                                                <div class="col-4 d-grid">
                                                                    <button class="btn btn-secondary viewFileBut" type="button" value="<?= $file ?>" style="font-size: small;">File Number <?= $subWorkUpdatesNr ?></button>
                                                                </div>
                                                            <?php
                                                                $subWorkUpdatesNr += 1;
                                                            endforeach ?>

                                                        </div>
                                                        <span><span class="fw-bold">Updated by:</span> <?= $updates['updated_by'] ?></span>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <span><span class="fw-bold">Date:</span> <?= $updates['created_at'] ?></span>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                $id += 1;
                            endforeach ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include $this->resolve("partials/_modals.php");
include $this->resolve("partials/_footer.php");
?>