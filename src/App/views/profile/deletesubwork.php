<div class="modal-body ">
    <?php
    include $this->resolve("partials/_token.php");
    ?>
    <div class="row d-flex justify-content-center align-items-center">
        <input type="hidden" id="idToDelete" name="idToDelete" value="<?= $id ?>">
        <div class="col-6 d-flex justify-content-center">
            <button class="btn btn-primary" type="submit" name="confDelete" id="confDelete">Delete</button>
        </div>
        <div class="col-6 d-flex justify-content-center">
            <button class="btn btn-secondary" type="button" id="cancelDelete">Cancel</button>
        </div>
    </div>
</div>