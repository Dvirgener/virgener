<div class="row">
    <?php foreach ($searchResult as $song) : ?>
        <div class="row">
            <div class="col-2">
                <?= $song['artist'] ?>
            </div>
            <div class="col-8">
                <?= $song['title'] ?>
            </div>
            <div class="col-2">
                <button value="<?= $song['id'] ?>" class="btn btn-primary" id="selectCue">Select</button>
            </div>
        </div>

    <?php endforeach ?>
</div>