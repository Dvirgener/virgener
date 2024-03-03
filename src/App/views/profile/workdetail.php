<div class="row mb-2 ms-2 text-center fw-bold justify-content-between">
    <div class="col-12 col-md-11">
        <h2 class="text-center">WORK DETAILS</h2>
    </div>
    <div class="col-3 d-none d-md-inline col-md-1">
        <!-- BACK BUTTON TO WHERE THIS PAGE WAS REQUESTED FROM -->
        <a class="btn btn-secondary" href="/profile/return">
            BACK
        </a>
        <input type="hidden" value="<?= $viewedOn ?>" id="viewedOn">
    </div>
</div>
<div class="row border-bottom border-dark border-2 mx-1 mb-3">
</div>
<div class="row justify-content-center">
    <div class="col-12 col-md-6 d-grid">
        <div class="row-fluid overflow-y-scroll overflow-x-hidden align-content-start pe-0 pe-md-3" style="height:600px; width:100%">
            <div class="row mb-2">
                <div class="col-12">
                    <label for="" class="form-label fs-6 fw-bold text-wrap">SUBJECT:</label>
                    <input class="form-control" type="text" disabled value="<?= $workDetails['subject'] ?>">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 col-md-6 mb-2">
                    <label for="" class="form-label fs-6 fw-bold">ADDED BY:</label>
                    <input class="form-control" type="text" disabled value="<?= $workDetails['added_by_name'] ?>">
                </div>
                <div class="col-12 col-md-6 mb-2">
                    <label for="" class="form-label fs-6 fw-bold">WORK TYPE:</label>
                    <input class="form-control" type="text" disabled value="<?= $workDetails['type'] ?>">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <label for="" class="form-label fs-6 fw-bold">INSTRUCTIONS / REMARKS:</label>
                    <textarea class="form-control" name="" id="" cols="20" rows="5" disabled><?= $workDetails['instructions'] ?></textarea>
                </div>
            </div>
            <div class="row justify-content-between ps-2">
                <div class="col-12 col-md-4">
                    <div class="row">
                        <span for="" class="form-label fs-6 fw-bold">FILE REFERENCE/S:</span>
                    </div>
                    <div class="row overflow-y-scroll text-center d-flex justify-content-center" style="height: 100px;">

                        <!-- CHECK FOR FILES ON THE MAIN WORK QUEUE -->
                        <?php $fileNr = 1;
                        foreach ($workDetails['files'] as $file) : ?>
                            <div class="row mb-2 d-flex justify-content-center align-items-start">
                                <div class="col d-grid">
                                    <button class="btn btn-secondary viewFileBut" type="button" value="<?= $file ?>">File Number <?= $fileNr ?></button>
                                </div>
                            </div>
                        <?php $fileNr += 1;
                        endforeach ?>
                        <!-- CHECK FOR FILES ON THE MAIN WORK QUEUE -->

                    </div>
                </div>
                <div class="col-12 col-md-8">

                    <!-- CHECK WHERE THE WORK IS BEING VIEWED FROM -->
                    <?php if ($viewedFrom == "dashboard") : ?>
                    <?php elseif ($viewedFrom == "history") : ?>
                    <?php else : ?>

                        <!-- IF THE WORK IS VIEWED ON PROFILE, CHECK IF IT IS VIEWED ON WORK QUEUE OR ADDED QUEUE -->
                        <?php if ($viewedOn == "workqueue") : ?>
                            <div class="row text-start">
                                <span for="" class="form-label fs-6 fw-bold">ACTION:</span>
                            </div>
                            <div class="row-fluid mt-2">
                                <div class="row mb-3 justify-content-between text-center">

                                    <div class="row mb-2 justify-content-center">
                                        <div class="col-12 col-md-6 d-grid text-center">
                                            <button class="btn btn-success complyWorkBut" type="button" value="<?= $workDetails['id'] ?>">COMPLY</button>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-12 col-md-6 d-grid">
                                            <button class="btn btn-secondary updateWorkBut" type="button" value="<?= $workDetails['id'] ?>">UPDATE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif ($viewedOn == "addedqueue") : ?>
                            <div class="row text-start">
                                <span for="" class="form-label fs-6 fw-bold">ACTION:</span>
                            </div>
                            <div class="row-fluid mt-2">
                                <div class="row mb-3 justify-content-between text-center">
                                    <?php if ($workDetails['added_by'] == $_SESSION['user']['id']) : ?>
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-md-6 mb-2 d-grid">
                                                <button class="btn btn-primary editWorkBut" type="button" value="<?= $workDetails['id'] ?>">EDIT</button>
                                            </div>
                                            <div class="col-12 col-md-6 mb-2 d-grid">
                                                <button class="btn btn-danger deleteWorkBut" type="button" value="<?= $workDetails['id'] ?>">DELETE</button>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <?php if ($workDetails['status'] == "PENDING") : ?>
                                                <div class="col-12 col-md-12 d-grid">
                                                    <button class="btn btn-success approveBut" type="button" value="<?= $workDetails['id'] ?>">APPROVE / RETURN</button>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        <?php endif ?>
                        <!-- IF THE WORK IS VIEWED ON PROFILE, CHECK IF IT IS VIEWED ON WORK QUEUE OR ADDED QUEUE -->

                    <?php endif ?>
                    <!-- CHECK WHERE THE WORK IS BEING VIEWED FROM -->


                </div>
            </div>
            <div class="row mb-2" style="height:fit-content;">
                <div class="col-12 col-md-4 mb-2">
                    <label for="" class="form-label fs-6 fw-bold">DATE ADDED:</label>
                    <input class="form-control" type="text" disabled value="<?= $workDetails['created_at'] ?>">
                </div>
                <div class="col-12 col-md-4 mb-2 ">
                    <label for="" class="form-label fs-6 fw-bold">LAST UPDATE:</label>
                    <input class="form-control" type="text" disabled value="<?= $workDetails['updated_at'] ?>">
                </div>
                <div class="col-12 col-md-4 mb-2">
                    <label for="" class="form-label fs-6 fw-bold">TARGET DATE:</label>
                    <input class="form-control" type="text" disabled value="<?= $workDetails['date_target'] ?>">
                </div>
            </div>
            <div class="row mb-2">
                <span class="fw-bold">ASSIGNED TO:</span>
            </div>
            <div class="row">

                <!-- THIS PART WILL SHOW THE PICTURES OF THE PERSONNEL WHERE THE WORK WAS ASSIGNED TO -->
                <?php foreach ($workDetails['detailedAssignee'] as $assigned) : ?>
                    <!-- //* Display for CP -->
                    <div class="col-6 d-inline d-md-none justify-content-center">
                        <div class="row">
                            <div class="col-12">
                                <img class="border view_personnel_work img-fluid " type="button" id="view_personnel_work" src="/profile/<?= $assigned['picture'] ?>" alt="" style=" height: 100%; width: 100%">
                            </div>

                        </div>
                        <div class="row text-center">
                            <span class="" style="font-size:small;"><?= $assigned['name'] ?></span>
                        </div>
                    </div>
                    <!-- //* Display for Browser -->
                    <div class="col-6 col-md-2 mb-2 d-none d-md-inline">
                        <img class="border border-2 border-dark view_personnel_work img-fluid " type="button" id="view_personnel_work" src="/profile/<?= $assigned['picture'] ?>" alt="" style=" height: 50px; width: 50px">
                    </div>
                <?php endforeach ?>
                <!-- THIS PART WILL SHOW THE PICTURES OF THE PERSONNEL WHERE THE WORK WAS ASSIGNED TO -->

            </div>

            <div class="row-fluid me-2 overflow-y-scroll overflow-x-hidden align-content-start p-0" style="height:565px">
                <div class="row">
                    <div class="row mb-3 d-flex align-items-center">
                        <div class="col-3 ">
                            <span for="" class="form-label fs-6 fw-bold">SUB WORK:</span>
                        </div>
                        <div class="col-9">
                            <?php if ($viewedFrom == "dashboard") : ?>
                            <?php else : ?>
                                <?php if ($viewedOn == "addedqueue") : ?>
                                    <button class="btn btn-outline-primary" id="addSubWorkBut" name="addSubWorkBut">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 20 18">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                        </svg>
                                        ADD
                                    </button>
                                <?php endif ?>
                            <?php endif ?>

                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="row mb-2" style="width: 100%;">
                            <div class="row ps-3">

                                <!-- THIS PART WILL LIST DOWN ALL THE SUB WORK THAT WAS ADDED TO THE MAIN WORK QUEUE -->
                                <?php foreach ($subWorkDetails as $subwork) : ?>
                                    <div class="row-fluid border shadow rounded ms-2 mb-2" style="height: fit-content;">
                                        <div class="row mb-2">
                                            <div class="col-6 d-flex align-items-center">
                                                <span class="fw-bold">SUBJECT: <span class="fw-bold" style="color:green"><?= $subwork['comp']['bg'] ?></span></span>
                                            </div>
                                            <div class="col-6">
                                                <div class="row mt-1 me-4 justify-content-end">

                                                    <!-- CHECK IF THE WORK IS BEING VIEWED FROM THE DASHBOARD OR PROFILE -->
                                                    <?php if ($viewedFrom == "dashboard") : ?>
                                                    <?php else : ?>

                                                        <!-- CHECK WHERE THE SUB WORK IS VIEWED FROM WORKLIST OR ADDED WORK -->
                                                        <?php if ($viewedOn == "workqueue") : ?>
                                                        <?php elseif ($viewedOn == "addedqueue") : ?>
                                                            <div class="col-3 mb-2 d-grid">
                                                                <button class="editSubWork" type="button" style="background: none ; border:none;" value="<?= $subwork['id'] ?>">Edit</button>
                                                            </div>
                                                            <div class="col-2 mb-2 d-grid">
                                                                <button class="deleteSubWorkBut" type="button" style="background: none; border:none; color:red; " value="<?= $subwork['id'] ?>">Delete</button>
                                                            </div>
                                                        <?php endif ?>
                                                        <!-- CHECK WHERE THE SUB WORK IS VIEWED FROM WORKLIST OR ADDED WORK -->

                                                    <?php endif ?>
                                                    <!-- CHECK IF THE WORK IS BEING VIEWED FROM THE DASHBOARD OR PROFILE -->

                                                </div>



                                            </div>

                                        </div>
                                        <div class="row border-bottom mb-2">
                                            <div class="col">
                                                <span class=""><?= $subwork['sub_subject'] ?></span>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <span class="fw-bold">ASSIGNED TO:</span>
                                        </div>
                                        <div class="row d-flex mb-2 mx-2">

                                            <!-- THIS PART WILL SHOW THE PICTURE OF PERSONNEL THE SUB WORK IS SPECIFICALLY ASSIGNED TO -->
                                            <?php foreach ($subwork['assignedNames'] as $names) : ?>
                                                <div class="col-4" style="font-size: small;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 20 19">
                                                        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                                                    </svg>
                                                    <?= $names ?>
                                                </div>
                                            <?php endforeach ?>
                                            <!-- THIS PART WILL SHOW THE PICTURE OF PERSONNEL THE SUB WORK IS SPECIFICALLY ASSIGNED TO -->

                                        </div>
                                        <div class="row d-flex justify-content-start">



                                        </div>
                                    </div>
                                <?php endforeach ?>
                                <!-- THIS PART WILL LIST DOWN ALL THE SUB WORK THAT WAS ADDED TO THE MAIN WORK QUEUE -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="row my-2">
            <div class="col-3 d-flex align-items-center">
                <span class="fw-bold">UPDATES:</span>
            </div>
            <div class="col-8">
                <?php if ($viewedOn == "workqueue") : ?>
                    <select name="" id="selectUpdateView" class="form-select">
                        <option value="all" selected>All updates</option>
                        <option value="0">General Updates</option>

                        <!-- THIS IS THE OPTIONS FOR SELECTING SUB WORK QUEUE UPDATES -->
                        <?php foreach ($subWorkDetails as $sub) : ?>
                            <option value="<?= $sub['id'] ?>"><?= $sub['sub_subject'] ?></option>
                        <?php endforeach ?>
                        <!-- THIS IS THE OPTIONS FOR SELECTING SUB WORK QUEUE UPDATES -->
                    </select>
                <?php elseif ($viewedOn == "addedqueue") : ?>
                    <select name="" id="selectAddedUpdateView" class="form-select">
                        <option value="all" selected>All updates</option>
                        <option value="0">General Updates</option>

                        <!-- THIS IS THE OPTIONS FOR SELECTING SUB WORK QUEUE UPDATES -->
                        <?php foreach ($subWorkDetails as $sub) : ?>
                            <option value="<?= $sub['id'] ?>"><?= $sub['sub_subject'] ?></option>
                        <?php endforeach ?>
                        <!-- THIS IS THE OPTIONS FOR SELECTING SUB WORK QUEUE UPDATES -->
                    </select>
                <?php endif ?>

            </div>
        </div>
        <div class="row overflow-y-scroll mt-2" style="height: 540px;">
            <div class="col" id="updateCol">

                <!-- SCAN INDIVIDUAL UPDATES FOR THIS WORK QUEUE -->
                <?php foreach ($workDetails['updates'] as $update) : ?>
                    <div class="row border mx-1 mb-2">
                        <div class="col-4 border-end text-center d-flex align-items-center justify-content-center">
                            <span class="fw-bold"><?= $update['created_at'] ?></span>
                        </div>
                        <div class="col-7">

                            <!-- CHECK IF THE UPDATE IS FINAL OR NOT -->
                            <?php if ($update['final'] == "YES") : ?>

                                <!-- CHECK IF THE UPDATE BELONGS TO A SUB WORK QUEUE -->
                                <?php if ($update['sub_id'] != 0) : ?>
                                    <div class="row">
                                        <span><span class="fw-bold">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                                                </svg>
                                                Sub Work: </span><?= $update['sub_id'] ?><span style="font-size: small; color:green;" class="fst-italic"> <?= $update['complied'] ?></span></span>
                                    </div>
                                <?php else : ?>
                                    <div class="row">
                                        <span class="fst-italic" style="font-size: small; color:green;">Main work <?= $update['complied'] ?></span>
                                    </div>
                                <?php endif ?>
                                <!-- CHECK IF THE UPDATE BELONGS TO A SUB WORK QUEUE -->

                            <?php else : ?>
                                <?php if ($update['sub_id'] != 0) : ?>
                                    <div class="row">
                                        <span><span class="fw-bold">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                                                </svg>
                                                Sub Work: </span><?= $update['sub_id'] ?><span style="font-size: small; color:green;" class="fst-italic"> <?= $update['complied'] ?></span></span>
                                    </div>
                                <?php endif ?>
                            <?php endif ?>
                            <!-- CHECK IF THE UPDATE IS FINAL OR NOT -->

                            <div class="row mb-1">
                                <span><?= $update['remarks'] ?></span>
                            </div>
                            <div class="row mb-1">

                                <!-- CHECK FOR FILES -->
                                <?php foreach ($update['files'] as $file) : ?>
                                    <div class="col-4 d-grid">
                                        <button class="btn btn-secondary viewFileBut mb-1" type="button" value="<?= $file ?>">File</button>
                                    </div>
                                <?php endforeach ?>
                                <!-- CHECK FOR FILES -->

                            </div>
                            <div class="row">
                                <span class="fst-italic mt-2">- <?= $update['updated_by'] ?></span>
                            </div>
                        </div>
                        <div class="col-1 mt-1" style="font-size: smaller;">

                            <!-- CHECK WHERE THE WORK IS BEING VIEWED FROM -->
                            <?php if ($viewedFrom == "dashboard") : ?>
                            <?php elseif ($viewedFrom == "history") : ?>
                            <?php else : ?>

                                <!-- SHOW IF THE WORK IS BEING VIEW FROM ADDED QUEUE -->
                                <?php if ($viewedOn == "workqueue") : ?>
                                    <button type="button" class="editUpdateBut" style="background: none; border: none; color:blue" value="<?= $update['id'] ?>">Edit</button>
                                <?php elseif ($viewedOn == "addedqueue") : ?>
                                    <form action="" method="POST" id="deleteUpdateForm">
                                        <?php
                                        include $this->resolve("partials/_token.php");
                                        ?>
                                        <input type="hidden" value="<?= $update['main_id'] ?>" id="mainId" name="mainId">
                                        <input type="hidden" value="<?= $viewedOn ?>" id="viewedOn" name="viewedOn">
                                        <input type="hidden" value="<?= $update['id'] ?>" id="id" name="id">
                                        <button type="submit" class="btn-close" aria-label="Close"></button>
                                    </form>
                                <?php endif ?>
                                <!-- SHOW IF THE WORK IS BEING VIEW FROM ADDED QUEUE -->

                            <?php endif ?>
                            <!-- CHECK WHERE THE WORK IS BEING VIEWED FROM -->

                        </div>
                    </div>
                <?php endforeach ?>
                <!-- SCAN INDIVIDUAL UPDATES FOR THIS WORK QUEUE -->

            </div>
        </div>




    </div>
</div>

<!-- UPDATE WORK MODAL -->
<div class="modal fade" id="updateWorkModal" tabindex="-1" aria-labelledby="updateWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateWorkModalLabel">Update Work</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/profile/details/update" method="POST" enctype="multipart/form-data" id="updateWorkForm">
                <div class="modal-body" id="updateWorkDiv">
                    <?php
                    include $this->resolve("partials/_token.php");
                    ?>
                    <input type="hidden" name="main_id" id="main_id" value="<?= $workDetails['id'] ?>">
                    <div class="row mb-1">
                        <div class="col-8">
                            <label for="" class="form-label">Update for:</label>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            <select name="updateId" id="updateId" class="form-select">
                                <option value="0">General Work</option>
                                <!-- THIS IS THE OPTIONS FOR SELECTING SUB WORK QUEUE UPDATES -->
                                <?php foreach ($subWorkDetails as $sub) : ?>
                                    <?php if ($sub['status'] != "COMPLIED") : ?>
                                        <?php if ($sub['authBut'] == "do") : ?>
                                            <option value="<?= $sub['id'] ?>"><?= $sub['sub_subject'] ?></option>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <!-- THIS IS THE OPTIONS FOR SELECTING SUB WORK QUEUE UPDATES -->
                            </select>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-8">
                            <label for="" class="form-label">Remarks:</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <textarea class="form-control" name="updateRemarks" id="updateRemarks" cols="15" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-8">
                            <label for="" class="form-label">File/s:</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input class="form-control text-center" type="file" name="workfiles[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- UPDATE WORK MODAL -->

<!-- COMPLY WORK MODAL -->
<div class="modal fade" id="complyWorkModal" tabindex="-1" aria-labelledby="complyWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="complyWorkModalLabel">Comply Work</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/profile/details/comply" method="POST" enctype="multipart/form-data" id="complyWorkForm">
                <div class="modal-body" id="updateWorkDiv">
                    <?php
                    include $this->resolve("partials/_token.php");
                    ?>
                    <input type="hidden" name="main_id" id="main_id" value="<?= $workDetails['id'] ?>">
                    <div class="row mb-1">
                        <div class="col-8">
                            <label for="" class="form-label">Compliance for:</label>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            <select name="complyId" id="complyId" class="form-select">
                                <?php if ($workDetails['subWorkComplied'] == true) : ?>
                                    <option value="0">Work Queue</option>
                                <?php endif ?>
                                <!-- THIS IS THE OPTIONS FOR SELECTING SUB WORK QUEUE UPDATES -->
                                <?php foreach ($subWorkDetails as $sub) : ?>
                                    <?php if ($sub['status'] != "COMPLIED") : ?>
                                        <?php if ($sub['authBut'] == "do") : ?>
                                            <option value="<?= $sub['id'] ?>"><?= $sub['sub_subject'] ?></option>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <!-- THIS IS THE OPTIONS FOR SELECTING SUB WORK QUEUE UPDATES -->
                            </select>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-8">
                            <label for="" class="form-label">Remarks:</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <textarea class="form-control" name="complyRemarks" id="complyRemarks" cols="15" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-8">
                            <label for="" class="form-label">File:</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input class="form-control text-center" type="file" name="workfiles[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Comply</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- COMPLY WORK MODAL -->

<!-- ADD SUBWORK MODAL -->
<div class="modal fade" id="addSubWorkModal" tabindex="-1" aria-labelledby="addSubWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addSubWorkModalLabel">Add Sub-work</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/profile/details/add/sub" method="POST" id="addSubWorkForm">
                <div class="modal-body">
                    <input type="hidden" id="addedfrom" name="addedfrom" value="directed">
                    <?php
                    include $this->resolve("partials/_token.php");
                    ?>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="hidden" name="mainId" id="mainId" value="<?= $workDetails['id'] ?>">
                            <label for="addSubSubject" class="form-label fw-bold">SUB WORK SUBJECT:</label>
                            <input class="form-control" type="text" id="addSubSubject" name="addSubSubject">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <span class="fw-bold">ASSIGN TO:</span>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($workDetails['detailedAssignee'] as $assigned) : ?>
                            <div class="col-4 mb-2">
                                <div class="row">
                                    <div class="col-2 d-flex align-items-center">
                                        <input class="form-check-input ms-3" id="addSubto[]" name="addSubto[]" type="checkbox" value="<?= $assigned['id'] ?>">
                                    </div>
                                    <div class="col-10">
                                        <div class="row">
                                            <div class="col-4">
                                                <img src="/profile/<?php echo $assigned['picture'] ?>" style="height:50px; width:50px" alt="">
                                            </div>
                                            <div class="col-8 d-flex align-items-center">
                                                <label for=""><?php echo $assigned['name'] ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ADD SUBWORK MODAL -->

<!-- CONFIRM COMPLIANCE MODAL -->
<div class="modal fade" id="confirmWorkModal" tabindex="-1" aria-labelledby="confirmWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="confirmWorkModalLabel">Confirm Compliance</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row my-3" id="approveOrNotDiv">
                <div class="col-6 d-flex justify-content-center">
                    <button class="btn btn-primary" type="button" id="confCompliance" value="<?= $workDetails['id'] ?>">Confirm</button>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <button class="btn btn-secondary" type="button" id="returnCompliance" value="<?= $workDetails['id'] ?>">Return</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CONFIRM COMPLIANCE MODAL -->

<!-- EDIT UPDATE MODAL -->
<div class="modal fade" id="editUpdateModal" tabindex="-1" aria-labelledby="editUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editUpdateModalLabel">Edit Update</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" id="updateWorkUpdateForm">
                <input type="hidden" name="main_id" id="main_id" value="<?= $workDetails['id'] ?>">
                <div class="modal-body" id="editUpdateDiv">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- EDIT UPDATE MODAL -->