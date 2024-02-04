<!-- Add Work Modal -->
<div class="modal fade" id="addWorkModal" tabindex="-1" aria-labelledby="addWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/profile/addwork" enctype="multipart/form-data" method="POST" id="addWorkForm">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addWorkModalLabel">Add Work Queue</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="addedfrom" name="addedfrom" value="Directed">
                    <?php
                    include $this->resolve("partials/_token.php");
                    ?>
                    <div class="row">
                        <div class="row mb-2">
                            <div class="col-4 col-md-2">
                                <span class="fw-bold">ADD TO:</span>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-1">
                                        <input class="form-check-input form-check-required" type="checkbox" name="checkall" id="checkall" value="" required>
                                    </div>
                                    <div class="col-9">
                                        <label for="checkall" class="form-label">Select All</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row overflow-y-scroll mb-2">
                            <?php foreach ($juniors as $junior) : ?>
                                <!-- //* Display for CP -->
                                <div class="col-6 d-inline d-md-none">
                                    <div class="row">
                                        <div class="col-3 d-flex align-items-center">
                                            <input class="form-check-input form-check-required ms-3" id="addto[]" name="addto[]" type="checkbox" value="<?= $junior['id'] ?>" required>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <div class="">
                                                    <img src="/profile/<?php echo $junior['picture'] ?>" style="height:100%; width:100%" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="" class="text-center" style="font-size: small;"><?php echo $junior['actual_rank'] . " " . $junior['last_name'] . " " . " PAF" ?></label>
                                    </div>
                                </div>
                                <!-- //* Display for Browser -->
                                <div class="col-6 col-md-4 mb-2 d-none d-md-inline">
                                    <div class="row">
                                        <div class="col-2 d-flex align-items-center">
                                            <input class="form-check-input form-check-required ms-3" id="addto[]" name="addto[]" type="checkbox" value="<?= $junior['id'] ?>" required>
                                        </div>
                                        <div class="col-10">
                                            <div class="row">
                                                <div class="col-10 col-md-4">
                                                    <img src="/profile/<?php echo $junior['picture'] ?>" style="height:100%; width:100%" alt="">
                                                </div>
                                                <div class="col-12 col-md-8 d-flex align-items-center">
                                                    <label for=""><?php echo $junior['actual_rank'] . " " . $junior['last_name'] . " " . " PAF" ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="row">
                            <span class="fw-bold">DETAILS:</span>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 pe-md-3">
                                <div class="row mb-2">
                                    <label for="subject" class="form-label">Subject:</label>
                                    <input type="text" class="form-control ms-2" id="subject" name="subject" required>
                                </div>
                                <div class="row mb-2">
                                    <label class="form-label" for="addworktype">Type:</label>
                                    <select class="form-select ms-2" aria-label="Default select example" name="addworktype" id="addworktype" required>
                                        <option value="" selected></option>
                                        <option value="Compliance">Compliance</option>
                                        <option value="Errand">Errand</option>
                                        <option value="Financial">Financial</option>
                                        <option value="Request">Request</option>
                                        <option value="Follow up">Follow up</option>
                                        <option value="Routine">Routine</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row mb-2">
                                    <label class="form-label" for="addworktargetdate">Target Date:</label>
                                    <input class="form-control ms-2" type="date" name="addworktargetdate" id="addworktargetdate" value="">
                                </div>
                                <div class="row mb-2">
                                    <label class="form-label">Upload Files:</label>
                                    <input class="form-control text-center ms-2" type="file" name="workfiles[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="form-label" for="addworkintremarks">Work Instructions / Remarks:</label>
                            <textarea class="form-control ms-2" name="addworkintremarks" id="addworkintremarks" rows="4" required></textarea>
                        </div>
                        <div class="row mb-2">
                            <div class="row">
                                <div class="col-6 col-md-2 d-flex align-items-center">
                                    <span class="fw-bold">SUB WORK:</span>
                                </div>
                                <div class="col-6 col-md-9">
                                    <button type="button" class="btn btn-outline-primary addSub" id="addSub">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 20 18">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                        </svg>
                                        ADD
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-fluid overflow-y-scroll subWorkGroup align-content-start" id="subWorkGroupID" style="height: 150px">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">ADD WORK QUEUE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Work Modal -->

<!-- VIEW FILE MODAL -->
<div class="modal fade" id="viewFileModal" tabindex="-1" aria-labelledby="viewFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="viewFileModalLabel">File Uploaded:</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center" id="viewFiles">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- VIEW FILE MODAL -->

<!-- EDIT FILE MODAL -->
<div class="modal fade" id="editWorkModal" tabindex="-1" aria-labelledby="editWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editWorkModalLabel">Edit Work Queue</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/profile/editwork" enctype="multipart/form-data" method="POST" id="editWorkForm">
                <div class="modal-body">

                    <input type="hidden" id="addedfrom" name="addedfrom" value="directed">

                    <?php
                    include $this->resolve("partials/_token.php");
                    ?>
                    <div class="row" id="editWorkFormDiv">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- EDIT FILE MODAL -->

<!-- DELETE FILE MODAL -->
<div class="modal fade" id="deleteWorkModal" tabindex="-1" aria-labelledby="deleteWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteWorkModalLabel">Delete Work Queue</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/confirmdeletework" method="POST" id="deleteWorkForm">

            </form>
        </div>
    </div>
</div>
<!-- DELETE FILE MODAL -->

<!-- ADD SUBWORK MODAL -->
<div class="modal fade" id="addSubWorkModal" tabindex="-1" aria-labelledby="addSubWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addSubWorkModalLabel">Add Sub-work</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/addsubwork" method="POST" id="addSubWork">
                <div class="modal-body">
                    <input type="hidden" id="addedfrom" name="addedfrom" value="directed">
                    <?php
                    include $this->resolve("partials/_token.php");
                    ?>
                    <div class="row mb-2">
                        <div class="col">
                            <input type="hidden" name="mainId" value="<?= $workDetails['id'] ?>">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ADD SUBWORK MODAL -->

<!-- EDIT SUBWORK MODAL -->
<div class="modal fade" id="editSubWorkModal" tabindex="-1" aria-labelledby="editSubWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editSubWorkModalLabel">Edit Sub-work</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/editsubwork" method="POST" id="editSubWorkForm">
                <div class="modal-body" id="editSubWorkDiv">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- EDIT SUBWORK MODAL -->

<!-- DELETE SUB WORK MODAL -->
<div class="modal fade" id="deleteSubWorkModal" tabindex="-1" aria-labelledby="deleteSubWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteSubWorkModalLabel">Delete Sub Work Queue</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/confirmdeletesubwork" method="POST" id="deleteSubWorkForm">

            </form>
        </div>
    </div>
</div>
<!-- DELETE FILE MODAL -->

<!-- UPDATE WORK MODAL -->
<div class="modal fade" id="updateWorkModal" tabindex="-1" aria-labelledby="updateWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateWorkModalLabel">Update Work</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/updatework" method="POST" enctype="multipart/form-data" id="updateWorkForm">
                <div class="modal-body" id="updateWorkDiv">
                    <?php
                    include $this->resolve("partials/_token.php");
                    ?>
                    <input type="hidden" name="idToUpdate" id="idToUpdate">
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
                            <label for="" class="form-label">File:</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input class="form-control text-center" type="file" name="updateWorkFiles[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- UPDATE WORK MODAL -->

<!-- UPDATE SUBWORK MODAL -->
<div class="modal fade" id="updateSubWorkModal" tabindex="-1" aria-labelledby="updateSubWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateSubWorkModalLabel">Update Sub-Work</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/updatesubwork" method="POST" enctype="multipart/form-data" id="updateSubWorkForm">
                <div class="modal-body" id="updateWorkDiv">
                    <?php
                    include $this->resolve("partials/_token.php");
                    ?>
                    <input type="hidden" name="subIdToUpdate" id="subIdToUpdate">
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
                            <label for="" class="form-label">File:</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <input class="form-control text-center" type="file" name="updateWorkFiles[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- UPDATE SUBWORK MODAL -->

<!-- COMPLY SUBWORK MODAL -->
<div class="modal fade" id="complySubWorkModal" tabindex="-1" aria-labelledby="complySubWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="complySubWorkModalLabel">Comply Sub-Work</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/complysubwork" method="POST" enctype="multipart/form-data" id="complySubWorkForm">
                <div class="modal-body" id="updateWorkDiv">
                    <?php
                    include $this->resolve("partials/_token.php");
                    ?>
                    <input type="hidden" name="subIdToComply" id="subIdToComply">
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
                            <input class="form-control text-center" type="file" name="complyWorkFiles[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- COMPLY SUBWORK MODAL -->

<!-- COMPLY WORK MODAL -->
<div class="modal fade" id="complyWorkModal" tabindex="-1" aria-labelledby="complyWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="complyWorkModalLabel">Comply Work</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/complywork" method="POST" enctype="multipart/form-data" id="complyWorkForm">
                <div class="modal-body" id="updateWorkDiv">
                    <?php
                    include $this->resolve("partials/_token.php");
                    ?>
                    <input type="hidden" name="IdToComply" id="IdToComply">
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
                            <input class="form-control text-center" type="file" name="complyWorkFiles[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- COMPLY WORK MODAL -->

<!-- CONFIRM COMPLIANCE MODAL -->
<div class="modal fade" id="confirmWorkModal" tabindex="-1" aria-labelledby="confirmWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="confirmWorkModalLabel">Confirm Compliance</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row my-3" id="approveOrNotDiv">

            </div>

        </div>
    </div>
</div>
<!-- CONFIRM COMPLIANCE MODAL -->