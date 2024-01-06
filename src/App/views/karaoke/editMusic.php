<?php
include $this->resolve("partials/_header.php");
?>

<section>
    <div class="row d-flex justify-content-center">
        <h1 class="text-center virg-karaoke-font">EDIT SONG</h1>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-4 mt-4">
            <form action="/karaoke/edit" method="POST">
                <?php include $this->resolve("partials/_token.php"); ?>

                <input class=" form-control mt-1" type="hidden" value="<?= $editSong['id']; ?>" name="id">

                <div class="row">
                    <label for="artist" class="fw-bold virg-karaoke-font">Artist:</label>
                    <input class="form-control mt-1" type="text" value="<?= $editSong['artist']; ?>" name="artist" id="artist">
                </div>
                <div class="row mt-3">
                    <label for="title" class="fw-bold virg-karaoke-font">Title:</label>
                    <input class=" form-control mt-1" type="text" value="<?= $editSong['title']; ?>" name="title" id="title">
                </div>
                <div class="row mt-3">
                    <label for="url" class="fw-bold virg-karaoke-font" >URL:</label>
                    <input class=" form-control mt-1" type="text" value="<?= $editSong['youtube']; ?>" name="url" id="url">
                </div>
                <div class="row mt-3">
                    <label for="mode" class="fw-bold virg-karaoke-font">Mode:</label>
                    <select name="mode" id="mode" class="form-select">
                        <option value="<?= $editSong['mode']; ?>"><?= $editSong['mode']; ?></option>
                        <option value="karaoke">Karaoke</option>
                        <option value="music">Music</option>
                        <option value="concert">Concert</option>
                        <option value="playlist">Playlist</option>
                    </select>
                </div>
                <div class="row justify-content-around mt-5">
                    <div class="col-3 d-grid">
                        <button type="submit" class="btn btn-primary">Save changes</button>

                    </div>
                    <div class="col-3 d-grid">
                        <a type="button" class="btn btn-secondary" href="/karaoke">Back</a>
                    </div>
                </div>


            </form>
        </div>
    </div>

</section>




<?php
include $this->resolve("partials/_footer.php");
?>