<div class="row mb-2 ms-2 text-center fw-bold justify-content-between">
    <div class="col-12 col-md-11">
        <h2 class="text-center">PERSONAL HISTORY</h2>
    </div>
    <div class="col-3 d-none d-md-inline col-md-1">
        <input type="hidden" value="<?= $viewedFrom ?>" id="historyViewedFrom">
        <input type="hidden" value="<?= $updatedBy ?>" id="historyBy">
    </div>
</div>
<div class="row border-bottom border-dark border-2 mx-1 mb-3">
</div>
<div class="row mx-2 ps-1 pe-3 overflow-y-scroll overflow-x-hidden justify-content-center" style="height: 610px;">
    <?php foreach ($allUpdates as $update) : ?>
        <div class="row mx-2 mb-2 border border-dark rounded" style="width: 70%;">
            <div class="col-8">
                <div class="row">
                    <span class="fw-bold">DATE : <span class="fw-normal" style="color: green;"><?= $update['dateCreated'] ?></span></span>
                </div>
                <div class="row mb-1">
                    <span class="fw-bold">SUBJECT : <span class="fw-normal"><?= $update['mainSubject'] ?></span></span>
                </div>
                <div class="row mb-1" style="display: <?php echo ($update['subSubject'] == 0 ? 'none' : 'block') ?>;">
                    <span class="fw-bold">SUB WORK : <span class="fw-normal"><?= $update['subSubject'] ?></span></span>
                </div>
                <div class="row">
                    <span class="fw-bold">REMARKS : <span class="fw-normal"><?= $update['remarks'] ?></span></span>
                </div>
            </div>
            <div class="col-4 d-flex justify-content-center align-items-center"><button class="btn btn-primary viewWorkButHistory" value="<?= $update['mainId'] ?>">VIEW
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-eye" viewBox="-1 1 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                    </svg></button>
            </div>

        </div>
    <?php endforeach ?>
</div>