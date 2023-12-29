<?php include $this->resolve("partials/_header.php"); ?>

<?php

$errorMsg = '';
if (isset($errors['email'][0])){
$errorMsg = $errors['email'][0];
}

$passwordErrorMsg = '';
if (isset($errors['password'][0])){
$passwordErrorMsg = $errors['password'][0];
}



?>
<section class="container-fluid my-5">
    <div class="row justify-content-center">
        <h1 class="text-center">LOG IN</h1>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-4">
            <form action="" method="POST">

            <?php include $this->resolve("partials/_token.php"); ?>

                <div class="form-floating">

                    <input value="<?php echo e($oldFormData['email'] ?? '');?>" name="email" id="email" type="email" class="form-control <?php echo !empty($oldFormData['email']) && $errorMsg !== "Invalid Email" ? "is-valid" : ($errorMsg !== "Invalid Email" && $errorMsg !== "This Field is required" ? '' : "is-invalid"); ?>" placeholder="john@example.com">

                    <label for="email">Email Address</label>

                    <?php if (array_key_exists('email', $errors)) : ?>
                        <div class="row ms-2 mt-1" style="color:red; font-size:14px">
                        <?php echo e($errors['email'][0]); ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="form-floating mt-4">

                    <input name="password" id="password" type="password" class="form-control <?php echo $passwordErrorMsg ? "is-invalid" : ''; ?>" placeholder="john@example.com">

                    <label for="password">Password</label>

                    <?php if (array_key_exists('password', $errors)) : ?>
                        <div class="row ms-2 mt-1" style="color:red; font-size:14px">
                        <?php echo e($errors['password'][0]); ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="row mt-5 justify-content-center">
                    <div class="col-4 d-grid">
                        <button class="btn btn-primary" type="submit">
                            Submit
                        </button>
                    </div>
                </div>


            </form>
        </div>
    </div>

</section>

<?php include $this->resolve("partials/_footer.php"); ?>