<?php
include $this->resolve("partials/_header.php");

?>
<section class="mt-4">

    <div class="row mx-3">
        <div class="col-4">
            <?php
            include $this->resolve("partials/_profile.php");
            ?>
        </div>

        <div class="col-8">
            <div class="row ms-2 text-center fw-bold">
                <h2>WORK QUEUE</h2>
            </div>
            <div class="row border-bottom border-dark border-2 mx-2 mb-3">

            </div>
            <div class="row">
                <div class="col-4">
                    <div class="row mx-2 text-center">
                        <h4>DIRECTED WORK</h4>
                    </div>

                    <div class="row mx-3 py-4 pe-4 overflow-y-scroll overflow-x-hidden rounded align-content-start" style="height:560px">
                        <?php foreach ($directedWork as $work) : ?>
                            <button type="button" class="card shadow m-2 buttonzoom viewWorkBut" style="height:fit-content; width: 100%; <?= $work['style'] ?>" value="<?= $work['id'] ?>">
                                <div class="row">
                                    <h5 class="text-start fw-bold text-wrap"><?= $work['subject'] ?></h5>
                                </div>
                                <div class="row">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 20 20">
                                            <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                        </svg> <?= $work['added_by'] ?> </span>
                                </div>
                            </button>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row mx-2 text-center">
                        <h4>SECTION WORK</h4>
                    </div>
                    <div class="row mx-3 py-4 pe-4 overflow-y-scroll overflow-x-hidden rounded align-content-start" style="height:560px">
                        <?php foreach ($sectionWork as $work) : ?>
                            <button type="button" class="card shadow m-2 buttonzoom viewWorkBut" style="height:fit-content; width: 100%; <?= $work['style'] ?>" value="<?= $work['id'] ?>">
                                <div class="row">
                                    <h5 class="text-start fw-bold "><?= $work['subject'] ?></h5>
                                </div>
                                <div class="row">
                                    <span>=> <?= $work['added_by'] ?> </span>
                                </div>
                            </button>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row mx-2 text-center">
                        <h4>ADDED WORK</h4>
                    </div>
                    <div class="row mx-3 py-4 pe-4 overflow-y-scroll overflow-x-hidden rounded align-content-start" style="height:560px">
                        <?php foreach ($addedWork as $work) : ?>
                            <button type="button" class="card shadow m-2 buttonzoom viewWorkBut" style="height:fit-content; width: 100%; <?= $work['style'] ?>" value="<?= $work['id'] ?>">
                                <div class="row">
                                    <h5 class="text-start fw-bold "><?= $work['subject'] ?></h5>
                                </div>
                                <div class="row">
                                    <span></span>
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