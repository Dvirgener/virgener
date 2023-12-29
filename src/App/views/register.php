<?php
include $this->resolve("partials/_header.php");

$country = isset($oldFormData['country']) ? $oldFormData['country'] : '';

?>

<section class="container-fluid my-5">
    <div class="row justify-content-center">
        <h1 class="text-center">REGISTER</h1>
    </div>
    <form action="" method="POST">
        <div class="row justify-content-center mt-4">

            <div class="col-4 ">

                <div class="form-floating">
                    <input value="<?php echo e($oldFormData['email'] ?? ''); ?>" name="firstName" id="firstName" type="text" class="form-control" placeholder="john@example.com">
                    <label for="firstName">First Name</label>
                    <?php if (array_key_exists('email', $errors)) : ?>
                        <div class="row ms-2 mt-1" style="color:red; font-size:14px">
                            <?php echo e($errors['email'][0]); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-floating mt-3">
                    <input value="<?php echo e($oldFormData['email'] ?? ''); ?>" name="email" id="email" type="email" class="form-control" placeholder="john@example.com">
                    <label for="email">Email address</label>
                    <?php if (array_key_exists('email', $errors)) : ?>
                        <div class="row ms-2 mt-1" style="color:red; font-size:14px">
                            <?php echo e($errors['email'][0]); ?>
                        </div>
                    <?php endif; ?>
                </div>



                <div class="form-floating mt-3">
                    <input value="<?php echo e($oldFormData['email'] ?? ''); ?>" name="password" id="password" type="password" class="form-control" placeholder="john@example.com">
                    <label for="password">Password</label>
                    <?php if (array_key_exists('email', $errors)) : ?>
                        <div class="row ms-2 mt-1" style="color:red; font-size:14px">
                            <?php echo e($errors['email'][0]); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-floating mt-3">
                    <input value="<?php echo e($oldFormData['email'] ?? ''); ?>" name="confirmPassword" id="confirmPassword" type="password" class="form-control" placeholder="john@example.com">
                    <label for="confirmPassword">Confirm Password</label>
                    <?php if (array_key_exists('email', $errors)) : ?>
                        <div class="row ms-2 mt-1" style="color:red; font-size:14px">
                            <?php echo e($errors['email'][0]); ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <div class="col-4">

                <div class="form-floating">
                    <input value="<?php echo e($oldFormData['email'] ?? ''); ?>" name="lastName" id="lastName" type="text" class="form-control" placeholder="john@example.com">
                    <label for="lastName">Last Name</label>
                    <?php if (array_key_exists('email', $errors)) : ?>
                        <div class="row ms-2 mt-1" style="color:red; font-size:14px">
                            <?php echo e($errors['email'][0]); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-floating mt-3">
                    <select name="rank" id="rank" class="form-select">
                        <option value="1" selected></option>
                        <option value="2">AM</option>
                        <option value="3">A2C</option>
                        <option value="4">A1C</option>
                        <option value="5">SGT</option>
                        <option value="6">SSG</option>
                        <option value="7">TSG</option>
                        <option value="8">MSG</option>
                        <option value="9">2LT</option>
                        <option value="10">1LT</option>
                        <option value="11">CPT</option>
                        <option value="12">MAJ</option>
                        <option value="13">LTC</option>
                    </select>
                    <label class="form-label" for="rank">Rank</label>
                </div>

                <div class="form-floating mt-3">
                    <input value="<?php echo e($oldFormData['email'] ?? ''); ?>" name="serialNumber" id="serialNumber" type="number" class="form-control" placeholder="john@example.com">
                    <label for="serialNumber">Serial Number</label>
                </div>

                <div class="form-floating mt-3">
                    <input value="<?php echo e($oldFormData['email'] ?? ''); ?>" name="position" id="position" type="text" class="form-control" placeholder="john@example.com">
                    <label for="position">Position</label>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-2 d-grid">
                <button class="btn btn-primary" type="submit">
                    Submit
                </button>
            </div>
            <div class="col-2 d-grid">
                <button class="btn btn-primary" type="submit">
                    Cancel
                </button>
            </div>
        </div>
    </form>


</section>

<?php
include $this->resolve("partials/_footer.php");
?>