<?php
include $this->resolve("partials/_header.php");

?>
<!--  THIS IS USED TO LOAD PROFILE.JS -->
<script src="/assets/vehicle.js"></script>

<section class="mt-4">

    <div class="row mx-3">
        <div class="row mb-3">
            <span class="h1 text-center">DBFEE - DIRECTORATE FOR BASE FACILITIES AND EQUIPMENT</span>
        </div>
    </div>
    <div class="row mx-3">
        <div class="col-4">
            <div class="row text-center mb-2">
                <span class="fw-bold h3">VEHICLE RECORDS</span>
            </div>
            <div class="row mb-2">
                <div class="col-6 h5 fw-bold d-flex align-items-center">
                    <span>ADD VEHICLE: <button class="ms-3 btn btn-primary" id="addVehicleBut">ADD</button></span>
                </div>
                <div class="col-4">

                </div>
            </div>
            <div class="row overflow-y-scroll overflow-x-hidden px-3 align-content-start" id="vehicleListDiv" style="height:500px">
                <?php foreach ($allVehicles as $vehicle) : ?>
                    <button type="button" class="btn btn-light buttonzoom viewVehicleBut border border-2" style="margin-bottom: 2px; height:fit-content; width: 100%;" value="<?= $vehicle['id'] ?>">
                        <div class="row">
                            <h5 class="text-start fw-bold text-wrap fs-3"><?= $vehicle['descriptions'] ?> (<?= $vehicle['plate_number'] ?>)</h5>
                        </div>
                        <div class="row text-start">
                            <div class="col-4">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 20 20">
                                        <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                    </svg>Status: <?= $vehicle['veh_status'] ?></span>
                            </div>
                            <div class="col-7">
                                <span>Next Renewal Date: <?= $vehicle['renewalDate'] ?></span>
                            </div>
                        </div>
                    </button>
                <?php endforeach ?>
            </div>

        </div>
        <div class="col-8" id="vehicleDetailDiv">

        </div>
    </div>



</section>

<!-- Add vehicle Modal -->
<div class="modal fade" id="addVehicleModal" tabindex="-1" aria-labelledby="addVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" enctype="multipart/form-data" method="POST" id="addVehicleForm">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold" id="addVehicleModalLabel">Add Vehicle</h1>
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
                                        <option value="Headquarters">Headquarters</option>
                                        <option value="TOG 10">TOG 10</option>
                                        <option value="TOG 11">TOG 11</option>
                                    </select>
                                </div>
                                <div class="row mb-2">
                                    <label for="article" class="form-label">ARTICLE:</label>
                                    <select name="article" id="article" class="form-select ms-2" required>
                                        <option value="Motorcycle">Motorcycle</option>
                                        <option value="Special Purpose Vehicle">Special Purpose Vehicle</option>
                                        <option value="Multi Purpose Vehicle">Multi Purpose Vehicle</option>
                                        <option value="Troop Carrier">Troop Carrier</option>
                                        <option value="Truck">Truck</option>
                                    </select>
                                </div>
                                <div class="row mb-2">
                                    <label for="description" class="form-label">DESCRIPTION:</label>
                                    <input type="text" name="description" id="description" class="form-control ms-2" required>
                                </div>
                                <div class="row mb-2">
                                    <label for="plateNumber" class="form-label">PLATE NUMBER:</label>
                                    <input type="text" name="plateNumber" id="plateNumber" class="form-control ms-2" required>
                                </div>
                                <div class="row mb-2">
                                    <label for="engineNumber" class="form-label">ENGINE NUMBER:</label>
                                    <input type="text" name="engineNumber" id="engineNumber" class="form-control ms-2" required>
                                </div>
                                <div class="row mb-2">
                                    <label for="chassisNumber" class="form-label">CHASSIS NUMBER:</label>
                                    <input type="text" name="chassisNumber" id="chassisNumber" class="form-control ms-2" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="row mb-2">
                                    <label for="dateAcquired" class="form-label">DATE ACQUIRED:</label>
                                    <input type="date" name="dateAcquired" id="dateAcquired" class="form-control ms-2" required>
                                </div>
                                <div class="row mb-2">
                                    <label for="dateRenew" class="form-label">RENEWAL DATE:</label>
                                    <input type="date" name="dateRenew" id="dateRenew" class="form-control ms-2" required>
                                </div>
                                <div class="row mb-2">
                                    <label for="pictures" class="form-label">PICTURES:</label>
                                    <input type="file" name="pictures[]" id="pictures[]" class="form-control ms-2" accept=".jpg,.jpeg,.png" multiple required>
                                </div>
                                <div class="row mb-2">
                                    <label for="certOfReg" class="form-label">CERTIFICATE OF REGISTRATION:</label>
                                    <input type="file" name="certOfReg[]" id="certOfReg[]" class="form-control ms-2" accept=".jpg,.jpeg,.png,.pdf" required>
                                </div>
                                <div class="row mb-2">
                                    <label for="officialReceipt" class="form-label">OFFICIAL RECEIPT:</label>
                                    <input type="file" name="officialReceipt[]" id="officialReceipt[]" class="form-control ms-2" accept=".jpg,.jpeg,.png,.pdf" required>
                                </div>
                                <div class="row mb-2">
                                    <label for="insurance" class="form-label">INSURANCE POLICY:</label>
                                    <input type="file" name="insurance[]" id="insurance[]" class="form-control ms-2" accept=".jpg,.jpeg,.png,.pdf" required>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">ADD VEHICLE</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add vehicle Modal -->

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





<?php
include $this->resolve("partials/_footer.php");
?>