<?php
include $this->resolve("partials/_token.php");
?>
<input type="hidden" name="updateId" id="updateId" value="<?= $updateDetails['id'] ?>">
<div class="row mb-1">
    <div class="col-8">
        <label for="" class="form-label">Remarks:</label>
    </div>
</div>
<div class="row mb-2">
    <div class="col">
        <textarea class="form-control" name="updateRemarks" id="updateRemarks" cols="15" rows="4" required><?= $updateDetails['remarks'] ?></textarea>
    </div>
</div>
<div class="row mb-1">
    <div class="col-8">
        <label for="" class="form-label">File/s:</label>
    </div>
</div>
<div class="row mb-2">
    <div class="col">
        <input class="form-control text-center" type="file" name="workfiles[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
    </div>
</div>