<input type="hidden" name="id" id="id" value="<?= $editWorkDetails['id'] ?>">
<div class="row mb-2">
    <div class="col-2">
        <span class="fw-bold">ADD TO:</span>
    </div>
    <div class="col-8">
        <div class="row">
            <div class="col-1">
                <input class="form-check-input form-check-required" type="checkbox" name="checkall" id="checkall" value="">
            </div>
            <div class="col-9">
                <label for="checkall" class="form-label">Select All</label>
            </div>
        </div>
    </div>
</div>
<div class="row mb-2">
    <?php foreach ($juniors as $junior) : ?>
        <div class="col-4 mb-2">
            <div class="row">
                <div class="col-3 d-flex align-items-center">
                    <input class="form-check-input ms-3 form-check-required" id="addto[]" name="addto[]" type="checkbox" value="<?= $junior['id'] ?>" <?= $junior['check'] ?>>
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-4">
                            <img src="/profile/<?php echo $junior['picture'] ?>" style="height:50px; width:50px" alt="">
                        </div>
                        <div class="col-8 d-flex align-items-center">
                            <label for=""><?php echo $junior['actual_rank'] . " " . $junior['last_name'] . " " . " PAF" ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<div class="row mb-2">
    <span class="fw-bold">DETAILS:</span>
</div>
<div class="row">
    <div class="col-6 pe-3">
        <div class="row mb-2">
            <label for="subject" class="form-label">Subject:</label>
            <input type="text" class="form-control ms-2" id="subject" name="subject" value="<?= $editWorkDetails['subject'] ?>">
        </div>
        <div class="row mb-2">
            <label class="form-label" for="addworktype">Type:</label>
            <select class="form-select ms-2" aria-label="Default select example" name="addworktype" id="addworktype">
                <option value="" selected></option>
                <option value="Compliance">Compliance</option>
                <option value="Errand">Errand</option>
                <option value="Errand">Financial</option>
                <option value="Errand">Request</option>
                <option value="Follow up">Follow up </option>
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="row mb-2">
            <label class="form-label" for="addworktargetdate">Target Date:</label>
            <input class="form-control ms-2" type="date" name="addworktargetdate" id="addworktargetdate" value="<?= $editWorkDetails['formatted_date'] ?>">
        </div>
        <div class="row mb-2">
            <label class="form-label">Upload Files:</label>
            <input class="form-control text-center ms-2" type="file" name="workfiles[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
        </div>
    </div>
</div>
<div class="row">
    <label class="form-label" for="addworkintremarks">Work Instructions / Remarks:</label>
    <textarea class="form-control ms-2" name="addworkintremarks" id="addworkintremarks" rows="4"><?= $editWorkDetails['instructions'] ?></textarea>
</div>