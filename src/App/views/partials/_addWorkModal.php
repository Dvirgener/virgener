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