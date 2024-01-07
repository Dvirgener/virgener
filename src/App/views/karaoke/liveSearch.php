<div class="row overflow-auto mt-2 ps-4 d-flex align-content-start" style="height:285px; width:350px">
    <?php foreach ($searchResult as $song) : ?>
        <div class="row mb-2 border-bottom">
            <div class="col-9">
                <?= "<span style='font-weight:bold'>" . $song['artist'] . "</span> - " . $song['title'] ?>
            </div>
            <div class="col-3">
                <button value="<?= $song['id'] ?>" class="btn btn-primary" id="selectCue">Select</button>
            </div>
        </div>

    <?php endforeach ?>
</div>