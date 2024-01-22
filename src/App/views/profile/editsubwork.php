<input type="hidden" id="addedfrom" name="addedfrom" value="directed">
<?php
include $this->resolve("partials/_token.php");
?>

<div class="row mb-2">
    <div class="col">
        <input type="hidden" name="id" value="<?= $subWorkDetails['id'] ?>">
        <label for="addSubSubject" class="form-label fw-bold">SUB WORK SUBJECT:</label>
        <input class="form-control" type="text" id="editSubSubject" name="editSubSubject" value="<?= $subWorkDetails['sub_subject'] ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col">
        <span class="fw-bold">ASSIGN TO:</span>
    </div>
</div>
<div class="row">
    <?php
    foreach ($subAssigned as $assigned) : ?>
        <div class="col-4 mb-2">
            <div class="row">
                <div class="col-2 d-flex align-items-center">
                    <input <?php echo $assigned['check'] ?> class="form-check-input ms-3" id="editSubto[]" name="editSubto[]" type="checkbox" value="<?php echo $assigned['id'] ?>">

                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-4">
                            <img src="/profile/<?php echo $assigned['picture'] ?>" style="height:50px; width:50px" alt="">
                        </div>
                        <div class="col-8 d-flex align-items-center">
                            <label for=""><?php echo $assigned['name'] ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>