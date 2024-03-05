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
        <!-- //* Display for Browser -->
        <div class="col-12 col-md-4 mb-2" id="allJuniorBrowser">
            <div class="row">
                <div class="col-2 d-flex align-items-center">
                    <input class="form-check-input form-check-required ms-3" id="addto[]" name="addto[]" type="checkbox" value="<?= $junior['id'] ?>" required>
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-3 col-md-4">
                            <img src="/profile/<?php echo $junior['picture'] ?>" style="height:100%; width:100%" alt="">
                        </div>
                        <div class="col-9 col-md-8 d-flex align-items-center">
                            <label for=""><?php echo $junior['name'] ?></label>
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
            <select class="form-select ms-2" name="addworktype" id="addworktype">

                <option <?php echo ($editWorkDetails['type'] == "Compliance" ? "selected" : ''); ?> value="Compliance">Compliance</option>
                <option <?php echo ($editWorkDetails['type'] == "Errand" ? "selected" : ''); ?> value="Errand">Errand</option>
                <option <?php echo ($editWorkDetails['type'] == "Financial" ? "selected" : ''); ?> value="Financial">Financial</option>
                <option <?php echo ($editWorkDetails['type'] == "Request" ? "selected" : ''); ?> value="Request">Request</option>
                <option <?php echo ($editWorkDetails['type'] == "Follow up" ? "selected" : ''); ?> value="Follow up">Follow up</option>
                <option <?php echo ($editWorkDetails['type'] == "Routine" ? "selected" : ''); ?> value="Routine">Routine</option>
                <option <?php echo ($editWorkDetails['type'] == "Procurement" ? "selected" : ''); ?> value="Procurement">Procurement</option>

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