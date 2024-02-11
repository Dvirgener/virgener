<div class="row ms-2 text-center fw-bold">
    <h2>WORK QUEUE</h2>
</div>
<input type="hidden" id="viewedFrom" value="<?= $viewedFrom ?>">
<div class="row border-bottom border-dark border-2 mx-2 mb-3">
</div>
<div class="row">

    <!-- THIS PART IS FOR THE VIEWING OF PERSONAL WORK QUEUE LIST -->
    <div class="col-12 col-md-7">
        <div class="row mx-2 text-center">
            <h4 class="d-none d-md-inline">MY WORK QUEUE</h4>
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
    <!-- THIS PART IS FOR THE VIEWING OF PERSONAL WORK QUEUE LIST -->

    <!-- THIS PART IS FOR THE VIEWING OF ADDED WORK QUEUE LIST -->
    <div class="col-12 col-md-5">
        <div class="row mx-2 text-center">
            <h4 class="d-inline d-md-none mt-2">MY ADDED WORK</h4>
            <h4 class="d-none d-md-inline ">MY ADDED WORK</h4>
        </div>
        <div class="row mx-1 py-4 pe-3 overflow-y-scroll overflow-x-hidden rounded align-content-start" style="height:560px">
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
    <!-- THIS PART IS FOR THE VIEWING OF ADDED WORK QUEUE LIST -->

</div>