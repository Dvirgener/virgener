<?php
include $this->resolve("partials/_header.php");

?>

<!--  THIS IS USED TO LOAD PROFILE.JS -->
<script src="/assets/history.js"></script>

<!-- THIS ARE HIDDEN INPUTS USED TO IDENTIFY USER BEING VIEWED AND WHERE THE PROFILE IS BEING VIEWED -->
<input type="hidden" id="profileId" value="<?= $user['id'] ?>">
<input type="hidden" id="viewedFrom" value="<?= $viewedFrom ?>">

<section class="mt-4">
    <div class="row mx-2">

        <div class="row">

            <div class="col-4  px-3" style="height: 600px;">
                <div class="row mb-3">
                    <span class="h1 text-center">OFFICE WORK HISTORY</span>
                </div>
                <div class="row mb-3">
                    <div class="col-9">
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <button class="btn btn-primary">Search</button>
                    </div>

                </div>
                <div class="row overflow-y-scroll overflow-x-hidden px-2 " style="height: 545px;">
                    <?php foreach ($compliedWork as $work) : ?>
                        <button type="button" class="btn btn-light buttonzoom viewWorkBut border border-2" style="margin-bottom: 2px; height:fit-content; width: 100%;" value="<?= $work['id'] ?>">
                            <div class="row">
                                <h5 class="text-start fw-bold text-wrap fs-6"><?= $work['subject'] ?></h5>
                            </div>
                            <div class="row text-start">
                                <div class="col-4">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 20 20">
                                            <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                        </svg> <?= $work['addedBy'] ?> </span>
                                </div>
                                <div class="col-3">
                                    <span><span class="fst-italic fw-bold" style="color: <?= $work['timeColor'] ?>"><?= $work['timeliness'] ?></span></span>
                                </div>
                                <div class="col-5">
                                    <span>Date : <?= $work['dateComplied'] ?></span>
                                </div>
                            </div>
                        </button>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="col-8 " id="pageLoader">

            </div>

        </div>
    </div>
</section>

<!-- VIEW FILE MODAL -->
<div class="modal fade" id="viewFileModal" tabindex="-1" aria-labelledby="viewFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="viewFileModalLabel">File Uploaded:</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center" id="viewFiles">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- VIEW FILE MODAL -->
<?php
include $this->resolve("partials/_footer.php");
?>