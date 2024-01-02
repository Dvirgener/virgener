<!-- Modal -->
<div class="modal fade" id="editMusicModal<?= $count ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit this Song</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/karaoke/edit" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <?php include $this->resolve("partials/_token.php"); ?>

                            <input class=" form-control mt-1" type="hidden" value="<?= $song['id']; ?>" name="id">

                            <div class="row">
                                <label for="artist" class="fw-bold">Artist:</label>
                                <input class="form-control mt-1" type="text" value="<?= $song['artist']; ?>" name="artist" id="artist">
                            </div>
                            <div class="row mt-1">
                                <label for="title" class="fw-bold">Title:</label>
                                <input class=" form-control mt-1" type="text" value="<?= $song['title']; ?>" name="title" id="title">
                            </div>
                            <div class="row mt-1">
                                <label for="url" class="fw-bold">URL:</label>
                                <input class=" form-control mt-1" type="text" value="<?= $song['youtube']; ?>" name="url" id="url">
                            </div>
                            <div class="row mt-1">
                                <label for="mode" class="fw-bold">Mode:</label>
                                <select name="mode" id="mode" class="form-select">
                                    <option value="<?= $song['mode']; ?>"><?= $song['mode']; ?></option>
                                    <option value="karaoke">Karaoke</option>
                                    <option value="music">Music</option>
                                    <option value="concert">Concert</option>
                                    <option value="playlist">Playlist</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>