<?php foreach ($updates as $update) : ?>
    <div class="row-fluid border  mx-1 mb-2">
        <div class="row justify-content-end">
        </div>
        <div class="row">
            <div class="col-4 border-end text-center d-flex align-items-center justify-content-center">
                <span class="fw-bold"><?= $update['created_at'] ?></span>
            </div>
            <div class="col-7">
                <?php if ($update['final'] == "YES") : ?>
                    <?php if ($update['sub_id'] != 0) : ?>
                        <div class="row">
                            <span><span class="fw-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                                    </svg>
                                    Sub Work: </span><?= $update['sub_id'] ?><span style="font-size: small; color:green;" class="fst-italic"> <?= $update['complied'] ?></span>
                            </span>
                        </div>
                    <?php else : ?>
                        <div class="row">
                            <span class="fst-italic" style="font-size: small; color:green;">Main work <?= $update['complied'] ?></span>
                        </div>
                    <?php endif ?>
                <?php else : ?>
                    <?php if ($update['sub_id'] != 0) : ?>
                        <div class="row">
                            <span><span class="fw-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                                    </svg>
                                    Sub Work: </span><?= $update['sub_id'] ?><span style="font-size: small; color:green;" class="fst-italic"> <?= $update['complied'] ?></span>
                            </span>
                        </div>
                    <?php endif ?>
                <?php endif ?>
                <div class="row mb-1">
                    <span><span class="fw-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                            </svg>
                            Remarks: </span><span><?= $update['remarks'] ?></span></span>
                </div>
                <div class="row mb-1">
                    <?php foreach ($update['files'] as $file) : ?>
                        <div class="col-4 d-grid">
                            <button class="btn btn-secondary viewFileBut" type="button" value="<?= $file ?>">File</button>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="row">
                    <span class="fst-italic mt-2">- <?= $update['updated_by'] ?></span>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>