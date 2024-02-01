<?php
include $this->resolve("partials/_header.php");

?>
<section class="mt-4">

    <div class="row mx-3">
        <div class="col-12 col-md-4">
            <?php
            include $this->resolve("partials/_profile.php");
            ?>
        </div>
        <div class="col-12 col-md-8">
            <div class="row mb-2 ms-2 text-center fw-bold justify-content-between">
                <div class="col-12 col-md-11">
                    <h2 class="text-center">WORK DETAILS</h2>
                </div>
                <div class="col-3 d-none d-md-inline col-md-1">
                    <a class="btn btn-secondary" href="/profile">
                        BACK
                    </a>
                </div>
            </div>
            <div class="row border-bottom border-dark border-2 mx-1 mb-3">
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 d-grid">
                    <div class="row mx-2 text-center">
                        <h4>MAIN WORK</h4>
                    </div>
                    <div class="row-fluid overflow-y-scroll overflow-x-hidden align-content-start pe-0 pe-md-3" style="height:560px; width:100%">
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
                            <div class="col-12 col-md-8">
                                <div class="row text-start">
                                    <span for="" class="form-label fs-6 fw-bold">ACTION:</span>
                                </div>
                                <div class="row-fluid mt-2">
                                    <div class="row mb-3 justify-content-between text-center">
                                        <?php if ($workDetails['added_by'] == $_SESSION['user']['id']) : ?>
                                            <div class="col-12 col-md-6 mb-2 d-grid">
                                                <?php if ($workDetails['subWorkComplied']) : ?>
                                                    <button class="btn btn-success complyWorkBut" type="button" value="<?= $workDetails['id'] ?>">COMPLY</button>
                                                <?php else : ?>
                                                    <button disabled class="btn btn-success complyWorkBut" type="button" value="<?= $workDetails['id'] ?>">COMPLY</button>
                                                <?php endif ?>
                                            </div>
                                            <div class="col-12 col-md-6 mb-2 d-grid">
                                                <button class="btn btn-secondary updateWorkBut" type="button" value="<?= $workDetails['id'] ?>">UPDATE</button>
                                            </div>

                                            <div class="col-12 col-md-6 mb-2 d-grid">
                                                <button class="btn btn-primary editWorkBut" type="button" value="<?= $workDetails['id'] ?>">EDIT</button>
                                            </div>
                                            <div class="col-12 col-md-6 mb-2 d-grid">
                                                <button class="btn btn-danger deleteWorkBut" type="button" value="<?= $workDetails['id'] ?>">DELETE</button>
                                            </div>
                                            <?php if ($workDetails['status'] == "PENDING") : ?>
                                                <div class="col-12 col-md-12 d-grid">
                                                    <button class="btn btn-success approveBut" type="button" value="<?= $workDetails['id'] ?>">APPROVE / RETURN</button>
                                                </div>
                                            <?php endif ?>


                                        <?php else : ?>
                                            <div class="row mb-2 justify-content-center">
                                                <div class="col-12 col-md-6 d-grid text-center">
                                                    <?php if ($workDetails['subWorkComplied']) : ?>
                                                        <button class="btn btn-success complyWorkBut" type="button" value="<?= $workDetails['id'] ?>">COMPLY</button>
                                                    <?php else : ?>
                                                        <button disabled class="btn btn-success complyWorkBut" type="button" value="<?= $workDetails['id'] ?>">COMPLY</button>
                                                    <?php endif ?>
                                                </div>

                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-12 col-md-6 d-grid">
                                                    <button class="btn btn-secondary updateWorkBut" type="button" value="<?= $workDetails['id'] ?>">UPDATE</button>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
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
                                <div class="col-6 col-md-4 mb-2 d-none d-md-inline">
                                    <div class="row">
                                        <div class="col-5">
                                            <img class="border view_personnel_work img-fluid " type="button" id="view_personnel_work" src="/profile/<?= $assigned['picture'] ?>" onerror="this.src='../pictures/generic/imageplaceholder.png';" alt="" style=" height: 100%; width: 100%">
                                        </div>
                                        <div class="col-7 d-grid align-items-center">
                                            <span class="" style="font-size:small;"><?= $assigned['name'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="row mb-2">
                            <span class="fw-bold">UPDATES:</span>
                        </div>
                        <div class="row overflow-y-scroll" style="height: 400px;">
                            <div class="col">
                                <?php foreach ($workDetails['updates'] as $update) : ?>
                                    <div class="row border mx-1 mb-2">
                                        <div class="col-4 border-end text-center d-flex align-items-center justify-content-center">
                                            <span class="fw-bold"><?= $update['created_at'] ?></span>
                                        </div>
                                        <div class="col-8">
                                            <?php if ($update['final'] == "YES") : ?>
                                                <?php if ($update['sub_id'] != 0) : ?>
                                                    <div class="row border-bottom">
                                                        <span><span class="fw-bold">Sub Work: </span><?= $update['sub_id'] ?><span style="font-size: small; color:green;" class="fst-italic"> <?= $update['complied'] ?></span></span>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="row border-bottom">
                                                        <span class="fst-italic" style="font-size: small; color:green;">Main work <?= $update['complied'] ?></span>
                                                    </div>
                                                <?php endif ?>
                                            <?php endif ?>

                                            <div class="row mb-1">
                                                <span><?= $update['remarks'] ?></span>
                                                <span class="fst-italic">- <?= $update['updated_by'] ?></span>
                                            </div>
                                            <div class="row mb-1">
                                                <?php foreach ($update['files'] as $file) : ?>
                                                    <div class="col-4 d-grid">
                                                        <button class="btn btn-secondary viewFileBut" type="button" value="<?= $file ?>">File</button>
                                                    </div>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="col-12 col-md-6">
                    <div class="row mx-2 text-center">
                        <h4>SUB WORK</h4>
                    </div>
                    <div class="row me-2 overflow-y-scroll overflow-x-hidden rounded align-content-start" style="height:560px">

                        <div class="row">
                            <div class="row mb-3 d-flex align-items-center">
                                <div class="col-3 ">
                                    <span for="" class="form-label fs-6 fw-bold">SUB WORK:</span>
                                </div>
                                <div class="col-9">
                                    <?php if ($workDetails['added_by'] == $_SESSION['user']['id']) : ?>
                                        <button class="btn btn-outline-primary" id="addSubWorkBut" name="addSubWorkBut">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 20 18">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                            </svg>
                                            ADD
                                        </button>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="row-fluid">

                                <div class="row mb-2">
                                    <div class="row">
                                        <?php foreach ($subWorkDetails as $subwork) : ?>
                                            <div class="row-fluid border shadow rounded mx-2 mb-2" style="height: fit-content;">
                                                <div class="row mb-2">
                                                    <span class="fw-bold">SUBJECT: <span class="fw-bold" style="color:red"><?= $subwork['comp']['bg'] ?></span></span>
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
                                                <div class="row d-flex justify-content-start">
                                                    <?php if ($workDetails['added_by'] == $_SESSION['user']['id']) : ?>
                                                        <div class="col-3 mb-2 d-grid">
                                                            <button class="btn btn-success complySubWorkBut" type="button" value="<?= $subwork['id'] ?>" <?= $subwork['authBut'] ?> <?= $subwork['comp']['compBut'] ?>>Comply</button>
                                                        </div>
                                                        <div class="col-3 mb-2 d-grid">
                                                            <button class="btn btn-secondary updateSubWorkBut" type="button" value="<?= $subwork['id'] ?>" <?= $subwork['authBut'] ?> <?= $subwork['comp']['compBut'] ?>>Update</button>
                                                        </div>
                                                        <div class="col-3 mb-2 d-grid">
                                                            <button class="btn btn-primary editSubWork" type="button" value="<?= $subwork['id'] ?>">Edit</button>
                                                        </div>
                                                        <div class="col-3 mb-2 d-grid">
                                                            <button class="btn btn-danger deleteSubWorkBut" type="button" value="<?= $subwork['id'] ?>">Delete</button>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="col mb-2 d-grid">
                                                            <button class="btn btn-success complySubWorkBut" type="button" value="<?= $subwork['id'] ?>" <?= $subwork['authBut'] ?> <?= $subwork['comp']['compBut'] ?>>Comply</button>
                                                        </div>
                                                        <div class="col mb-2 d-grid">
                                                            <button class="btn btn-secondary updateSubWorkBut" type="button" value="<?= $subwork['id'] ?>" <?= $subwork['authBut'] ?> <?= $subwork['comp']['compBut'] ?>>Update</button>
                                                        </div>
                                                    <?php endif ?>
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
        </div>
    </div>
</section>
<?php
include $this->resolve("partials/_modals.php");
include $this->resolve("partials/_footer.php");
?>