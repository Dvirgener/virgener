<?php include $this->resolve("partials/_header.php"); ?>

<section class="container my-5">
    <div class="row justify-content-center">
        <h1 class="text-center">LOG IN</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="" method="POST">

                <div class="form-floating">
                    <input name="email" id="email" type="email" class="form-control" placeholder="john@example.com">
                    <label for="email">Email Address</label>
                </div>

                <div class="form-floating mt-3">
                    <input name="password" id="password" type="password" class="form-control" placeholder="john@example.com">
                    <label for="password">Password</label>
                </div>

                <div class="row mt-4 justify-content-center">
                    <div class="col-4 d-grid">
                        <button class="btn btn-primary" type="submit">
                            Login
                        </button>
                    </div>
                </div>


            </form>
        </div>
    </div>

    <form method="POST">



        <?php include $this->resolve("partials/_token.php"); ?>
        <label class="block">
            <span class="text-gray-700">Email address</span>
            <input value="<?= e($oldFormData['email'] ?? ''); ?>" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="john@example.com" />
            <?php if (array_key_exists('email', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['email'][0]); ?>
                </div>
            <?php endif; ?>
        </label>
        <label class="block">
            <span class="text-gray-700">Password</span>
            <input name="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" />
            <?php if (array_key_exists('password', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['password'][0]); ?>
                </div>
            <?php endif; ?>
        </label>
        <button type="submit" class="block w-full py-2 bg-indigo-600 text-white rounded">
            Submit
        </button>
    </form>

</section>

<?php include $this->resolve("partials/_footer.php"); ?>