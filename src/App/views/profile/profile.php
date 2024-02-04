<?php
include $this->resolve("partials/_header.php");

?>


<section class="mt-4">

    <div class="row mx-3">
        <div class="col-12 col-md-4">
            <?php
            include $this->resolve("partials/_profile.php");
            ?>
        </div>

        <div class="col-12 col-md-8">
            <div class="row ms-2 text-center fw-bold">
                <h2>WORK QUEUE</h2>
            </div>
            <div class="row border-bottom border-dark border-2 mx-2 mb-3">

            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="row mx-2 text-center">
                        <h4 class="d-none d-md-inline">WORK QUEUE</h4>
                    </div>
                    <div class="row mx-1 py-4 pe-1 overflow-y-scroll overflow-x-hidden rounded align-content-start" style="height:560px">
                        <div class="col">
                            <?php foreach ($directedWork as $work) : ?>
                                <button type="button" class="btn btn-light buttonzoom viewWorkBut border border-2" style="margin-bottom: 2px; height:fit-content; width: 100%; <?= $work['style'] ?>" value="<?= $work['id'] ?>">
                                    <div class="row">
                                        <h5 class="text-start fw-bold text-wrap fs-6"><?= $work['subject'] ?></h5>
                                    </div>
                                    <div class="row text-start">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 20 20">
                                                <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                            </svg> <?= $work['added_by'] ?> </span>
                                    </div>
                                </button>
                            <?php endforeach ?>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="row mx-2 text-center">
                        <h4 class="d-inline d-md-none mt-2">ADDED WORK</h4>
                        <h4 class="d-none d-md-inline ">ADDED WORK</h4>
                    </div>
                    <div class="row mx-2 py-4 pe-2 overflow-y-scroll overflow-x-hidden rounded align-content-start" style="height:560px">
                        <?php foreach ($addedWork as $work) : ?>
                            <button type="button" class="btn btn-light buttonzoom viewAddedWorkBut border border-2" style="margin-bottom: 2px; height:fit-content; width: 100%; <?= $work['style'] ?>" value="<?= $work['id'] ?>">
                                <div class="row">
                                    <h5 class="text-start fw-bold fs-6"><?= $work['subject'] ?>
                                    </h5>
                                </div>
                                <div class="row">
                                    <?php if ($work['status'] == "PENDING") : ?>
                                        <span class="fst-italic text-start" style="color:green;">(Complied! Pending Approval)</span>
                                    <?php endif ?>
                                </div>
                                <div class="row text-start">

                                </div>

                            </button>

                        <?php endforeach ?>
                    </div>
                </div>

            </div>
        </div>
    </div>



</section>




<?php
include $this->resolve("partials/_modals.php");
include $this->resolve("partials/_footer.php");
?>