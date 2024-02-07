<?php include $this->resolve("partials/_header.php"); ?>

<?php

$errorMsg = '';
if (isset($errors['email'][0])) {
    $errorMsg = $errors['email'][0];
}

$passwordErrorMsg = '';
if (isset($errors['password'][0])) {
    $passwordErrorMsg = $errors['password'][0];
}

echo $_SESSION['user']['number_rank'];

?>
<section class="container-fluid my-5">
    <div class="row justify-content-center">
        <h1 class="text-center">SETTINGS</h1>
    </div>
    <div class="row justify-content-center mt-4">
        <form action="/settings/save" method="POST" enctype="multipart/form-data" id="userSettingsForm">
            <?php include $this->resolve("partials/_token.php"); ?>
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-3">
                    <div class="row mb-2">
                        <label class="form-label fw-bold" for="firstName">First Name:</label>
                        <input class="form-control" type="text" value="<?= $user['first_name'] ?>" id="firstName" name="firstName">
                    </div>
                    <div class="row mb-2">
                        <label class="form-label fw-bold" for="firstName">Last Name:</label>
                        <input class="form-control" type="text" value="<?= $user['last_name'] ?>" id="lastName" name="lastName">
                    </div>
                    <div class="row mb-2">
                        <label class="form-label fw-bold" for="firstName">Rank:</label>
                        <select name="rank" id="rank" class="form-select">
                            <option value="0"></option>
                            <option value="1" <?php echo ($user['number_rank'] == "1" ? "selected" : ''); ?>>AM</option>
                            <option value="2" <?php echo ($user['number_rank'] == "2" ? "selected" : ''); ?>>A2C</option>
                            <option value="3" <?php echo ($user['number_rank'] == "3" ? "selected" : ''); ?>>A1C</option>
                            <option value="4" <?php echo ($user['number_rank'] == "4" ? "selected" : ''); ?>>SGT</option>
                            <option value="5" <?php echo ($user['number_rank'] == "5" ? "selected" : ''); ?>>SSG</option>
                            <option value="6" <?php echo ($user['number_rank'] == "6" ? "selected" : ''); ?>>TSG</option>
                            <option value="7" <?php echo ($user['number_rank'] == "7" ? "selected" : ''); ?>>MSG</option>
                            <option value="8" <?php echo ($user['number_rank'] == "8" ? "selected" : ''); ?>>2LT</option>
                            <option value="9" <?php echo ($user['number_rank'] == "9" ? "selected" : ''); ?>>1LT</option>
                            <option value="10" <?php echo ($user['number_rank'] == "10" ? "selected" : ''); ?>>CPT</option>
                            <option value="11" <?php echo ($user['number_rank'] == "11" ? "selected" : ''); ?>>MAJ</option>
                            <option value="12" <?php echo ($user['number_rank'] == "12" ? "selected" : ''); ?>>LTC</option>
                        </select>
                    </div>
                    <div class="row mb-2">
                        <label class="form-label fw-bold" for="firstName">Serial Number:</label>
                        <input class="form-control" type="text" value="<?= $user['serial_number'] ?>" id="serialNumber" name="serialNumber">
                    </div>
                    <div class="row mb-4">
                        <label class="form-label fw-bold" for="firstName">Position:</label>
                        <select name="position" id="position" class="form-select ">
                            <option></option>
                            <option value="OIC" <?php echo ($user['position'] === "OIC" ? "selected" : ''); ?>>OIC</option>
                            <option value="Assistant OIC" <?php echo ($user['position'] === "Assistant OIC" ? "selected" : ''); ?>>Assistant OIC</option>
                            <option value="NCOIC" <?php echo ($user['position'] === "NCOIC" ? "selected" : ''); ?>>NCOIC</option>
                            <option value="Personnel" <?php echo ($user['position'] === "Personnel" ? "selected" : ''); ?>>Personnel</option>
                        </select>
                    </div>
                    <div class="row mb-2">
                        <button class="btn btn-primary">UPDATE</button>
                    </div>

                </div>
                <div class="col-12 col-md-3 ms-2">
                    <div class="row mb-2">
                        <label class="form-label fw-bold" for="">Profile Picture:</label>
                        <input class="form-control" type="file" id="profilePic" name="profilePic" accept=".jpg,.jpeg,.png">
                    </div>
                    <div class="row mb-2">
                        <label class="form-label fw-bold" for="email">Email:</label>
                        <input class="form-control" type="email" value="<?= $user['email'] ?>" id="email" name="email">
                    </div>
                    <div class="row mb-2">
                        <label class="form-label fw-bold" for="firstName">Password:</label>
                        <input class="form-control" type="password" value="" id="password" name="password">
                    </div>
                    <div class="row mb-2">
                        <label class="form-label fw-bold" for="firstName">Confirm Password:</label>
                        <input class="form-control" type="password" value="" id="confirmPassword" name="confirmPassword">
                    </div>
                    <div class="row mb-2">
                        <span class="fw-bold">Section:</span>
                    </div>
                    <div class="row" style="margin-bottom: 14px;">
                        <div class="col-4">
                            <input class="form-check-input me-1" id="section[]" name="section[]" type="checkbox" value="DPP" <?php echo (in_array("DPP", $section) ? "checked" : ''); ?>>
                            <label for="section">DPP</label>
                        </div>
                        <div class="col-4">
                            <input class="form-check-input me-1" id="section[]" name="section[]" type="checkbox" value="DBFEE" <?php echo (in_array("DBFEE", $section) ? "checked" : ''); ?>>
                            <label for="section">DBFEE</label>
                        </div>
                        <div class="col-4">
                            <input class="form-check-input me-1" id="section[]" name="section[]" type="checkbox" value="DMA" <?php echo (in_array("DMA", $section) ? "checked" : ''); ?>>
                            <label for="section">DMA</label>
                        </div>
                        <div class="col-4">
                            <input class="form-check-input me-1" id="section[]" name="section[]" type="checkbox" value="DMS" <?php echo (in_array("DMS", $section) ? "checked" : ''); ?>>
                            <label for="section">DMS</label>
                        </div>
                        <div class="col-4">
                            <input class="form-check-input me-1" id="section[]" name="section[]" type="checkbox" value="DAMM" <?php echo (in_array("DAMM", $section) ? "checked" : ''); ?>>
                            <label for="section">DAMM</label>
                        </div>
                        <div class="col-4">
                            <input class="form-check-input me-1" id="section[]" name="section[]" type="checkbox" value="ADMIN" <?php echo (in_array("ADMIN", $section) ? "checked" : ''); ?>>
                            <label for="section">ADMIN</label>
                        </div>
                    </div>


                    <div class="row">
                        <a href="/profile" class="btn btn-secondary">CANCEL</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

</section>

<?php include $this->resolve("partials/_footer.php"); ?>