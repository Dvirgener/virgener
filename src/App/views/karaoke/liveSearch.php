<div class="row overflow-auto mt-2 d-flex align-content-start" style="height:530px">
    <?php foreach ($searchResult as $song) : ?>
        <div class="row mb-2">
            <div class="col-10">
                <?= $song['artist'] ." - " . $song['title']?>
            </div>
            <div class="col-2">
                <button value="<?= $song['id'] ?>" class="btn btn-primary" id="selectCue">Select</button>
            </div>
        </div>

    <?php endforeach ?>
</div>