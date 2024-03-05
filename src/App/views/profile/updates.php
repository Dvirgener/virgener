<!-- SCAN INDIVIDUAL UPDATES FOR THIS WORK QUEUE -->
<?php foreach ($updates as $update) : ?>
    <div class="row border border-dark mb-2 justify-content-center" style="background-color: <?php echo (($update['final']) == 'YES' ? '#31a339' : ''); ?>">
        <div class="row border-bottom border-dark p-0">
            <div class="col-10 ps-1">
                <span class="fw-bold">Update for: </span><span><?php echo ($update['sub_id'] != 0 ? $update['sub_id'] : 'Main Work') ?></span>
            </div>
            <div class="col-2 mt-1 d-flex justify-content-end" style="font-size: smaller;">

                <!-- CHECK WHERE THE WORK IS BEING VIEWED FROM -->
                <?php if ($viewedFrom == "dashboard") : ?>
                <?php elseif ($viewedFrom == "history") : ?>
                <?php else : ?>

                    <!-- SHOW IF THE WORK IS BEING VIEW FROM ADDED QUEUE -->
                    <?php if ($viewedOn == "workqueue") : ?>
                        <button type="button" class="editUpdateBut" style="background: none; border: none; color:blue" value="<?= $update['id'] ?>">Edit</button>
                    <?php elseif ($viewedOn == "addedqueue") : ?>
                        <form action="" method="POST" id="deleteUpdateForm">
                            <?php
                            include $this->resolve("partials/_token.php");
                            ?>
                            <input type="hidden" value="<?= $update['main_id'] ?>" id="mainId" name="mainId">
                            <input type="hidden" value="<?= $viewedOn ?>" id="viewedOn" name="viewedOn">
                            <input type="hidden" value="<?= $update['id'] ?>" id="id" name="id">
                            <button type="submit" class="btn-close" aria-label="Close"></button>
                        </form>
                    <?php endif ?>
                    <!-- SHOW IF THE WORK IS BEING VIEW FROM ADDED QUEUE -->

                <?php endif ?>
                <!-- CHECK WHERE THE WORK IS BEING VIEWED FROM -->

            </div>
        </div>
        <div class="row">
            <div class="col-4 border-end border-dark text-center d-flex align-items-center justify-content-center">
                <div class="row">
                    <span class="fw-bold"><?= $update['created_at'] ?></span>
                </div>
            </div>
            <div class="col-8">
                <div class="row mb-1">
                    <span><?= $update['remarks'] ?></span>
                </div>
                <div class="row mb-1">

                    <!-- CHECK FOR FILES -->
                    <?php foreach ($update['files'] as $file) : ?>
                        <div class="col-4 d-grid">
                            <button class="btn btn-secondary viewFileBut mb-1" type="button" value="<?= $file ?>">File</button>
                        </div>
                    <?php endforeach ?>
                    <!-- CHECK FOR FILES -->
                </div>
                <div class="row">
                    <span class="fst-italic mt-2">- <?= $update['updated_by'] ?></span>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- SCAN INDIVIDUAL UPDATES FOR THIS WORK QUEUE -->