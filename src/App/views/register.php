<?php
include $this->resolve("partials/_header.php");
$oldFormRank = isset($oldFormData['rank']) ? $oldFormData['rank'] : '';
$oldFormPosition = isset($oldFormData['position']) ? $oldFormData['position'] : '';
?>

<section class="container-fluid my-5">
    <div class="row justify-content-center">
        <h1 class="text-center">REGISTER</h1>
    </div>


    <form action="/register" method="POST">
        <?php include $this->resolve("partials/_token.php"); ?>
        <div class="row justify-content-center mt-4">

            <div class="col-12 col-md-4">

                <div class="form-floating">
                    <input value="<?php echo e($oldFormData['firstName'] ?? ''); ?>" name="firstName" id="firstName" type="text" class="form-control <?php echo validInvalidForm($errors, $oldFormData, 'firstName'); ?>" placeholder="john@example.com">
                    <label for="firstName">First Name</label>
                    <?php formErrorMessaage($errors, 'firstName'); ?>
                </div>

                <div class="form-floating mt-3">
                    <input value="<?php echo e($oldFormData['email'] ?? ''); ?>" name="email" id="email" type="email" class="form-control <?php echo validInvalidForm($errors, $oldFormData, 'email'); ?>" placeholder="john@example.com">
                    <label for="email">Email address</label>
                    <?php formErrorMessaage($errors, 'email'); ?>
                </div>

                <div class="form-floating mt-3">
                    <input value="" name="password" id="password" type="password" class="form-control <?php echo isset($errors["password"]) ? "is-invalid" : ''; ?>" placeholder="john@example.com">
                    <label for="password">Password</label>
                    <?php formErrorMessaage($errors, 'password'); ?>
                </div>

                <div class="form-floating mt-3">
                    <input value="" name="confirmPassword" id="confirmPassword" type="password" class="form-control <?php echo isset($errors["confirmPassword"]) ? "is-invalid" : ''; ?>" placeholder="john@example.com">
                    <label for="confirmPassword">Confirm Password</label>
                    <?php formErrorMessaage($errors, 'confirmPassword'); ?>
                </div>

            </div>
            <div class="col-12 col-md-4">

                <div class="form-floating">
                    <input value="<?php echo e($oldFormData['lastName'] ?? ''); ?>" name="lastName" id="lastName" type="text" class="form-control <?php echo validInvalidForm($errors, $oldFormData, 'lastName'); ?>" placeholder="john@example.com">
                    <label for="lastName">Last Name</label>
                    <?php formErrorMessaage($errors, 'lastName'); ?>
                </div>

                <div class="form-floating mt-3">
                    <select name="rank" id="rank" class="form-select <?php echo validInvalidForm($errors, $oldFormData, 'rank'); ?>">
                        <option value="0"></option>
                        <option value="1" <?php echo ($oldFormRank === "1" ? "selected" : ''); ?>>AM</option>
                        <option value="2" <?php echo ($oldFormRank === "2" ? "selected" : ''); ?>>A2C</option>
                        <option value="3" <?php echo ($oldFormRank === "3" ? "selected" : ''); ?>>A1C</option>
                        <option value="4" <?php echo ($oldFormRank === "4" ? "selected" : ''); ?>>SGT</option>
                        <option value="5" <?php echo ($oldFormRank === "5" ? "selected" : ''); ?>>SSG</option>
                        <option value="6" <?php echo ($oldFormRank === "6" ? "selected" : ''); ?>>TSG</option>
                        <option value="7" <?php echo ($oldFormRank === "7" ? "selected" : ''); ?>>MSG</option>
                        <option value="8" <?php echo ($oldFormRank === "8" ? "selected" : ''); ?>>2LT</option>
                        <option value="9" <?php echo ($oldFormRank === "9" ? "selected" : ''); ?>>1LT</option>
                        <option value="10" <?php echo ($oldFormRank === "10" ? "selected" : ''); ?>>CPT</option>
                        <option value="11" <?php echo ($oldFormRank === "11" ? "selected" : ''); ?>>MAJ</option>
                        <option value="12" <?php echo ($oldFormRank === "12" ? "selected" : ''); ?>>LTC</option>
                    </select>
                    <label class="form-label" for="rank">Rank</label>
                    <?php formErrorMessaage($errors, 'rank'); ?>
                </div>

                <div class="form-floating mt-3">
                    <select name="position" id="position" class="form-select <?php echo validInvalidForm($errors, $oldFormData, 'position'); ?>">
                        <option></option>
                        <option value="OIC" <?php echo ($oldFormPosition === "OIC" ? "selected" : ''); ?>>OIC</option>
                        <option value="AOIC" <?php echo ($oldFormPosition === "AOIC" ? "selected" : ''); ?>>Assistant OIC</option>
                        <option value="NCOIC" <?php echo ($oldFormPosition === "NCOIC" ? "selected" : ''); ?>>NCOIC</option>
                        <option value="Personnel" <?php echo ($oldFormPosition === "Personnel" ? "selected" : ''); ?>>Personnel</option>
                    </select>
                    <label class="form-label" for="position">Position</label>
                    <?php formErrorMessaage($errors, 'position'); ?>
                </div>

                <div class="form-floating mt-3">
                    <input value="<?php echo e($oldFormData['serialNumber'] ?? ''); ?>" name="serialNumber" id="serialNumber" type="number" class="form-control <?php echo validInvalidForm($errors, $oldFormData, 'serialNumber'); ?>" placeholder="john@example.com">
                    <label for="serialNumber">Serial Number</label>
                    <?php formErrorMessaage($errors, 'serialNumber'); ?>
                </div>
            </div>

            <div class="row justify-content-center mt-4">
                <div class="col-2 d-grid">
                    <button class="btn btn-primary" type="submit">
                        Register
                    </button>
                </div>
                <div class="col-2 d-grid">
                    <a href="/" class="btn btn-primary">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>


</section>

<?php
include $this->resolve("partials/_footer.php");
?>