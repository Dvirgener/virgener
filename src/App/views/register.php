<?php
include $this->resolve("partials/_header.php");

?>

<section class="container-fluid my-5">
    <div class="row justify-content-center">
        <h1 class="text-center">REGISTER</h1>
    </div>


    <form action="/register" method="POST">
        <?php include $this->resolve("partials/_token.php"); ?>
        <div class="row justify-content-center mt-4">

            <div class="col-4 ">

                <div class="form-floating">
                    <input value="<?php echo e($oldFormData['firstName'] ?? ''); ?>" name="firstName" id="firstName" type="text" class="form-control <?php echo validInvalidForm($errors,$oldFormData,'firstName'); ?>" placeholder="john@example.com">
                    <label for="firstName">First Name</label>
                    <?php formErrorMessaage($errors,'firstName');?>
                </div>

                <div class="form-floating mt-3">
                    <input value="<?php echo e($oldFormData['email'] ?? ''); ?>" name="email" id="email" type="email" class="form-control <?php echo validInvalidForm($errors,$oldFormData,'email'); ?>" placeholder="john@example.com">
                    <label for="email">Email address</label>
                    <?php formErrorMessaage($errors,'email');?>
                </div>

                <div class="form-floating mt-3">
                    <input value="" name="password" id="password" type="password" class="form-control <?php echo validInvalidForm($errors,$oldFormData,'password'); ?>" placeholder="john@example.com">
                    <label for="password">Password</label>
                    <?php formErrorMessaage($errors,'password');?>
                </div>

                <div class="form-floating mt-3">
                    <input value="" name="confirmPassword" id="confirmPassword" type="password" class="form-control <?php echo validInvalidForm($errors,$oldFormData,'confirmPassword'); ?>" placeholder="john@example.com">
                    <label for="confirmPassword">Confirm Password</label>
                    <?php formErrorMessaage($errors,'confirmPassword');?>
                </div>

            </div>
            <div class="col-4">

                <div class="form-floating">
                    <input value="<?php echo e($oldFormData['lastName'] ?? ''); ?>" name="lastName" id="lastName" type="text" class="form-control" placeholder="john@example.com">
                    <label for="lastName">Last Name</label>
                    <?php formErrorMessaage($errors,'lastName');?>
                </div>

                <div class="form-floating mt-3">
                    <select name="rank" id="rank" class="form-select">
                        <option value="0"></option>
                        <option value="1" <?php echo ($rank === "1" ? "selected" : ''); ?>>AM</option>
                        <option value="2" <?php echo ($rank === "2" ? "selected" : ''); ?>>A2C</option>
                        <option value="3" <?php echo ($rank === "3" ? "selected" : ''); ?>>A1C</option>
                        <option value="4" <?php echo ($rank === "4" ? "selected" : ''); ?>>SGT</option>
                        <option value="5" <?php echo ($rank === "5" ? "selected" : ''); ?>>SSG</option>
                        <option value="6" <?php echo ($rank === "6" ? "selected" : ''); ?>>TSG</option>
                        <option value="7" <?php echo ($rank === "7" ? "selected" : ''); ?>>MSG</option>
                        <option value="8" <?php echo ($rank === "8" ? "selected" : ''); ?>>2LT</option>
                        <option value="9" <?php echo ($rank === "9" ? "selected" : ''); ?>>1LT</option>
                        <option value="10" <?php echo ($rank === "10" ? "selected" : ''); ?>>CPT</option>
                        <option value="11" <?php echo ($rank === "11" ? "selected" : ''); ?>>MAJ</option>
                        <option value="12" <?php echo ($rank === "12" ? "selected" : ''); ?>>LTC</option>
                    </select>
                    <label class="form-label" for="rank">Rank</label>
                    <?php formErrorMessaage($errors,'rank');?>
                </div>

                <div class="form-floating mt-3">
                    <select name="position" id="position" class="form-select">
                        <option></option>
                        <option value="OIC" <?php echo ($position === "OIC" ? "selected" : ''); ?>>OIC</option>
                        <option value="Assistant OIC" <?php echo ($position === "Assistant OIC" ? "selected" : ''); ?>>Assistant OIC</option>
                        <option value="NCOIC" <?php echo ($position === "NCOIC" ? "selected" : ''); ?>>NCOIC</option>
                        <option value="Personnel" <?php echo ($position === "Personnel" ? "selected" : ''); ?>>Personnel</option>
                    </select>
                    <label class="form-label" for="position">Position</label>
                    <?php formErrorMessaage($errors,'position');?>
                </div>

                <div class="form-floating mt-3">
                    <input value="<?php echo e($oldFormData['serialNumber'] ?? ''); ?>" name="serialNumber" id="serialNumber" type="number" class="form-control" placeholder="john@example.com">
                    <label for="serialNumber">Serial Number</label>
                    <?php formErrorMessaage($errors,'serialNumber');?>
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