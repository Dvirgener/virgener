<div class="row mb-2 ms-2 text-center fw-bold justify-content-between">
    <div class="col-12 col-md-11">
        <h2 class="text-center">VEHICLE DETAILS</h2>
    </div>
    <div class="col-3 d-none d-md-inline col-md-1">
        <!-- BACK BUTTON TO WHERE THIS PAGE WAS REQUESTED FROM -->
        <a class="btn btn-secondary" href="/profile/return">
            BACK
        </a>
    </div>
</div>

<div class="row border-bottom border-dark border-2 mx-1 mb-3">
</div>
<div class="row justify-content-center">
    <div class="col-12 col-md-7 d-grid">
        <div class="row overflow-y-scroll align-content-start" style="height: 550px;">
            <div class="row mb-2">
                <div class="col-6">
                    <label for="">Article:</label>
                    <input type="text" class="form-control" value="<?= $vehicle['article'] ?>" disabled>
                </div>
                <div class="col-6">
                    <label for="">Description:</label>
                    <input type="text" class="form-control" value="<?= $vehicle['descriptions'] ?>" disabled>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    <label for="">Unit:</label>
                    <input type="text" class="form-control" value="<?= $vehicle['unit'] ?>" disabled>
                </div>
                <div class="col-6">
                    <label for="">Plate Number:</label>
                    <input type="text" class="form-control" value="<?= $vehicle['plate_number'] ?>" disabled>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    <label for="">Engine Number:</label>
                    <input type="text" class="form-control" value="<?= $vehicle['engine_number'] ?>" disabled>
                </div>
                <div class="col-6">
                    <label for="">Chassis Number:</label>
                    <input type="text" class="form-control" value="<?= $vehicle['chassis_number'] ?>" disabled>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    <label for="">Date Acquired:</label>
                    <input type="text" class="form-control" value="<?= $vehicle['year_acquired'] ?>" disabled>
                </div>
                <div class="col-6">
                    <label for="">Renewal Date:</label>
                    <input type="text" class="form-control" value="<?= $vehicle['renewal_date'] ?>" disabled>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    <label for="">Status:</label>
                    <input type="text" class="form-control" value="<?= $vehicle['veh_status'] ?>" disabled>
                </div>
                <div class="col-6 d-flex align-items-end">
                    <button type="button" class="btn btn-secondary updateStatusBut" value="<?= $vehicle['id'] ?>">Update Status</button>
                </div>
            </div>
            <div class="row mb-2">
                <span>Remarks:</span>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <textarea name="" id="" cols="20" rows="5" class="form-control" disabled><?= $vehicle['remarks'] ?></textarea>
                </div>
            </div>
            <div class="row mb-2">
                <div class="row">
                    <span class="fw-bold">Pictures:</span>
                </div>
                <div class="row d-flex justify-content-around">
                    <?php foreach ($vehicle['pictures'] as $picture) : ?>
                        <div class="col text-center">
                            <img src="/profile/file/<?= $picture ?>" alt="" style="height: 200px; width:200px" class="border border-dark">
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    <div class="row ">
                        <span class="fw-bold">Files:</span>
                    </div>
                    <div class="row mb-2">
                        <div class="col-7 d-flex align-items-center">
                            <span class="align-items-center">Cert of Registration:</span>
                        </div>
                        <div class="col-5">
                            <button class="btn btn-primary viewFileBut" style="width:100%" value="<?= $vehicle['cert_reg'][0] ?>">CR</button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-7 d-flex align-items-center">
                            <span class="align-items-center">Official Receipt:</span>
                        </div>
                        <div class="col-5">
                            <button class="btn btn-primary viewFileBut" style="width:100%" value="<?= $vehicle['official_receipt'][0] ?>">OR</button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-7 d-flex align-items-center">
                            <span class="align-items-center">Insurance Policy:</span>
                        </div>
                        <div class="col-5">
                            <button class="btn btn-primary viewFileBut" style="width:100%" value="<?= $vehicle['insurance_policy'][0] ?>">Insurance</button>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row mb-3">
                        <span class="fw-bold">Action:</span>
                    </div>
                    <div class="row justify-content-center mb-2">
                        <?php if ($vehicle['needWork']) : ?>
                            <div class="col-6 mb-2">
                                <button type="button" class="btn btn-secondary addVehicleWorkBut" style="width: 100%;" value="<?= $vehicle['id'] ?>">ADD WORK</button>
                            </div>
                        <?php endif ?>
                        <?php if ($vehicle['forRenew']) : ?>
                            <div class="col-6 mb-2">
                                <button type="button" class="btn btn-secondary renewVehicleBut" style="width: 100%;" value="<?= $vehicle['id'] ?>">RENEW</button>
                            </div>
                        <?php endif ?>


                        <div class=" col-6 mb-2">
                            <button type="button" class="btn btn-primary editVehicleButton" style="width: 100%;" value="<?= $vehicle['id'] ?>">EDIT</button>
                        </div>
                        <div class="col-6 mb-2">
                            <button type="button" class="btn btn-danger deleteVehicleButton" style="width: 100%;" value="<?= $vehicle['id'] ?>">DELETE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5 d-grid">
        <div class="row">
            <span class="fw-bold h5 text-center">HISTORY</span>
        </div>
        <div class="row overflow-y-scroll mx-1 px-2 overflow-x-hidden align-content-start" style="height: 510px;">
            <?php foreach ($vehicleWorks as $vehicleWork) : ?>
                <?php if ($vehicleWork['vehWork']) : ?>
                    <button type="button" class="btn btn-light buttonzoom viewWorkBut border border-2" style="margin-bottom: 2px; height:fit-content; width: 100%;" value="<?= $vehicleWork['id'] ?>">
                        <div class="row">
                            <h5 class="text-start fw-bold text-wrap fs-6"><?= $vehicleWork['subject'] ?></h5>
                        </div>
                        <div class="row text-start fw-bold mb-2">
                            <span>STATUS: <?= $vehicleWork['status'] ?></span>
                        </div>
                        <div class="row text-start">
                            <div class="col">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 20 20">
                                        <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                    </svg> <?= $vehicleWork['addedBy'] ?> </span>
                            </div>
                            <div class="col text-end">
                                <span>Date: <?= $vehicleWork['date'] ?> </span>
                            </div>

                        </div>
                    </button>
                <?php else : ?>
                    <div class="btn btn-light buttonzoom border border-2" style="margin-bottom: 2px; height:fit-content; width: 100%; <?= $work['style'] ?>" value="<?= $vehicleWork['id'] ?>">
                        <div class="row">
                            <h5 class="text-start fw-bold text-wrap fs-6"><?= $vehicleWork['subject'] ?></h5>
                        </div>
                        <div class="row text-start">
                            <div class="col">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 20 20">
                                        <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                    </svg> <?= $vehicleWork['addedBy'] ?> </span>
                            </div>
                            <div class="col text-end">
                                <span>Date: <?= $vehicleWork['date'] ?> </span>
                            </div>
                        </div>
                    </div>

                <?php endif ?>

            <?php endforeach ?>
        </div>
    </div>

    <!-- UPDATE VEHICLE STATUS MODAL -->
    <div class="modal fade" id="updateVehicleStatusModal" tabindex="-1" aria-labelledby="updateVehicleStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateVehicleStatusModalLabel">Update Vehicle Status</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data" id="updateVehicleStatusForm">
                    <div class="modal-body" id="">
                        <?php
                        include $this->resolve("partials/_token.php");
                        ?>
                        <input type="hidden" name="vehicleId" id="vehicleId" value="<?= $vehicle['id'] ?>">
                        <div class="row mb-1">
                            <div class="col-8">
                                <label for="" class="form-label">Vehicle Status:</label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col">
                                <select name="vehStatus" id="vehStatus" class="form-select">
                                    <option value="IN">IN</option>
                                    <option value="OUT">OUT</option>
                                    <option value="BER">BER</option>
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
                                <textarea class="form-control" name="vehicleRemarks" id="vehicleRemarks" cols="15" rows="4" required></textarea>
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
    <!-- UPDATE VEHICLE STATUS MODAL -->

    <!-- EDIT VEHICLE MODAL -->
    <div class="modal fade" id="editVehicleModal" tabindex="-1" aria-labelledby="editVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" enctype="multipart/form-data" method="POST" id="updateVehicleForm">
                    <input type="hidden" id="id" name="id" value="<?= $vehicle['id'] ?>">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 fw-bold" id="editVehicleModalLabel">Edit Vehicle Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        include $this->resolve("partials/_token.php");
                        ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="row mb-2">
                                        <label for="" class="form-label">UNIT:</label>
                                        <select name="unit" id="unit" class="form-select ms-2" required>
                                            <option value="Headquarters" <?php echo ($vehicle['unit'] == "Headquarters" ? "selected" : "") ?>>Headquarters</option>
                                            <option value="TOG 10" <?php echo ($vehicle['unit'] == "TOG 10" ? "selected" : "") ?>>TOG 10</option>
                                            <option value="TOG 11" <?php echo ($vehicle['unit'] == "TOG 11" ? "selected" : "") ?>>TOG 11</option>
                                        </select>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="article" class="form-label">ARTICLE:</label>
                                        <select name="article" id="article" class="form-select ms-2" required>
                                            <option value="Motorcycle" <?php echo ($vehicle['unit'] == "Motorcycle" ? "selected" : "") ?>>Motorcycle</option>
                                            <option value="Special Purpose Vehicle" <?php echo ($vehicle['unit'] == "Special Purpose Vehicle" ? "selected" : "") ?>>Special Purpose Vehicle</option>
                                            <option value="Multi Purpose Vehicle" <?php echo ($vehicle['unit'] == "Multi Purpose Vehicle" ? "selected" : "") ?>>Multi Purpose Vehicle</option>
                                            <option value="Troop Carrier" <?php echo ($vehicle['unit'] == "Troop Carrier" ? "selected" : "") ?>>Troop Carrier</option>
                                            <option value="Truck" <?php echo ($vehicle['unit'] == "Truck" ? "selected" : "") ?>>Truck</option>
                                        </select>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="description" class="form-label">DESCRIPTION:</label>
                                        <input type="text" name="description" id="description" class="form-control ms-2" required value="<?= $vehicle['descriptions'] ?>">
                                    </div>
                                    <div class="row mb-2">
                                        <label for="plateNumber" class="form-label">PLATE NUMBER:</label>
                                        <input type="text" name="plateNumber" id="plateNumber" class="form-control ms-2" required value="<?= $vehicle['plate_number'] ?>">
                                    </div>
                                    <div class="row mb-2">
                                        <label for="engineNumber" class="form-label">ENGINE NUMBER:</label>
                                        <input type="text" name="engineNumber" id="engineNumber" class="form-control ms-2" required value="<?= $vehicle['engine_number'] ?>">
                                    </div>
                                    <div class="row mb-2">
                                        <label for="chassisNumber" class="form-label">CHASSIS NUMBER:</label>
                                        <input type="text" name="chassisNumber" id="chassisNumber" class="form-control ms-2" required value="<?= $vehicle['chassis_number'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="row mb-2">
                                        <label for="dateAcquired" class="form-label">DATE ACQUIRED:</label>
                                        <input type="date" name="dateAcquired" id="dateAcquired" class="form-control ms-2" required value="<?= $vehicle['formattedYearAcquired'] ?>">
                                    </div>
                                    <div class="row mb-2">
                                        <label for="dateRenew" class="form-label">RENEWAL DATE:</label>
                                        <input type="date" name="dateRenew" id="dateRenew" class="form-control ms-2" required value="<?= $vehicle['formattedRenewalDate'] ?>">
                                    </div>
                                    <div class="row mb-2">
                                        <label for="pictures" class="form-label">PICTURES:</label>
                                        <input type="file" name="pictures[]" id="pictures[]" class="form-control ms-2" accept=".jpg,.jpeg,.png" multiple>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="certOfReg" class="form-label">CERTIFICATE OF REGISTRATION:</label>
                                        <input type="file" name="certOfReg[]" id="certOfReg[]" class="form-control ms-2" accept=".jpg,.jpeg,.png,.pdf">
                                    </div>
                                    <div class="row mb-2">
                                        <label for="officialReceipt" class="form-label">OFFICIAL RECEIPT:</label>
                                        <input type="file" name="officialReceipt[]" id="officialReceipt[]" class="form-control ms-2" accept=".jpg,.jpeg,.png,.pdf">
                                    </div>
                                    <div class="row mb-2">
                                        <label for="insurance" class="form-label">INSURANCE POLICY:</label>
                                        <input type="file" name="insurance[]" id="insurance[]" class="form-control ms-2" accept=".jpg,.jpeg,.png,.pdf">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">UPDATE VEHICLE</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- EDIT VEHICLE MODAL -->

    <!-- DELETE VEHICLE MODAL -->
    <div class="modal fade" id="deleteVehicleModal" tabindex="-1" aria-labelledby="deleteVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteVehicleModalLabel">Delete Vehicle:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-6 text-center">
                            <button class="btn btn-primary confDeleteVehicle" style="width:80%" value="<?= $vehicle['id'] ?>">CONFIRM</button>
                        </div>
                        <div class="col-6 text-center">
                            <button class="btn btn-secondary" style="width:80%" data-bs-dismiss="modal">CANCEL</button>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    <!-- DELETE VEHICLE MODAL -->

    <!-- ADD WORK TO VEHICLE MODAL -->
    <div class="modal fade" id="addVehicleWorkModal" tabindex="-1" aria-labelledby="addVehicleWorkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" enctype="multipart/form-data" method="POST" id="addVehicleWorkForm">
                    <input type="hidden" id="id" name="id" value="<?= $vehicle['id'] ?>">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addVehicleWorkLabel">Add Work Queue</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="addedfrom" name="addedfrom" value="Vehicles">
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
                                <?php foreach ($users as $user) : ?>
                                    <!-- //* Display for Browser -->
                                    <div class="col-12 col-md-4 mb-2" id="allJuniorBrowser">
                                        <div class="row">
                                            <div class="col-2 d-flex align-items-center">
                                                <input class="form-check-input form-check-required ms-3" id="addto[]" name="addto[]" type="checkbox" value="<?= $user['id'] ?>" required>
                                            </div>
                                            <div class="col-10">
                                                <div class="row">
                                                    <div class="col-3 col-md-4">
                                                        <img src="/profile/<?php echo $user['picture'] ?>" style="height:100%; width:100%" alt="">
                                                    </div>
                                                    <div class="col-9 col-md-8 d-flex align-items-center">
                                                        <label for=""><?php echo $user['name'] ?></label>
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
                                            <option value="Procurement">Procurement</option>
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
    <!-- ADD WORK TO VEHICLE MODAL -->

    <!-- RENEW VEHICLE MODAL -->
    <div class="modal fade" id="renewVehicleModal" tabindex="-1" aria-labelledby="renewVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="renewVehicleModalLabel">Renew Vehicle:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="renewVehicleForm">
                        <?php
                        include $this->resolve("partials/_token.php");
                        ?>
                        <input type="hidden" id="id" name="id" value="<?= $vehicle['id'] ?>">
                        <div class="row">
                            <div class="row mb-2">
                                <div class="col-4 col-md-2">
                                    <span class="fw-bold">ASSIGN TO:</span>
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
                                <?php foreach ($users as $user) : ?>
                                    <!-- //* Display for Browser -->
                                    <div class="col-12 col-md-4 mb-2" id="allJuniorBrowser">
                                        <div class="row">
                                            <div class="col-2 d-flex align-items-center">
                                                <input class="form-check-input form-check-required ms-3" id="addto[]" name="addto[]" type="checkbox" value="<?= $user['id'] ?>" required>
                                            </div>
                                            <div class="col-10">
                                                <div class="row">
                                                    <div class="col-3 col-md-4">
                                                        <img src="/profile/<?php echo $user['picture'] ?>" style="height:100%; width:100%" alt="">
                                                    </div>
                                                    <div class="col-9 col-md-8 d-flex align-items-center">
                                                        <label for=""><?php echo $user['name'] ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">ADD RENEWAL WORK</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                    </form>
                </div>

                </form>
            </div>
        </div>
    </div>
    <!-- RENEW VEHICLE MODAL -->