<?php

include $this->resolve("partials/_header.php");
?>

<section class="my-5">
    <div class="row justify-content-between text-center">
        <div class="col-12 col-md-3 px-5">
            <div class="row my-5">
                <h4>ADD A YOUTUBE VIDEO</h4>
            </div>
            <div class="row d-flex justify-content-center border-start">
                <div class="row " style="height: 410px;">
                    <form action="/karaoke/addsong" method="POST">
                        <?php include $this->resolve("partials/_token.php"); ?>

                        <div class="row">
                            <label for="artist" class="fw-bold">Artist:</label>
                            <input class="form-control mt-1" type="text" value="" name="artist" id="artist">
                        </div>
                        <div class="row mt-1">
                            <label for="title" class="fw-bold">Title:</label>
                            <input class=" form-control mt-1" type="text" value="" name="title" id="title">
                        </div>
                        <div class="row mt-1">
                            <label for="url" class="fw-bold">URL:</label>
                            <input class=" form-control mt-1" type="text" value="" name="url" id="url">
                        </div>
                        <div class="row mt-1">
                            <label for="title" class="fw-bold">Mode:</label>
                            <select name="mode" id="mode" class="form-select">
                                <option value=""></option>
                                <option value="karaoke">Karaoke</option>
                                <option value="music">Music</option>
                                <option value="concert">Concert</option>
                                <option value="playlist">Playlist</option>
                            </select>
                        </div>
                        <div class="row mt-3">
                            <button class="btn btn-primary" type="submit">Add</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
        <div class="col-12 col-md-6">
            <div class="row mb-3">
                <h1>SONG LIST</h1>
            </div>
            <div class="row d-flex justify-content-center border-start border-end">
                <table id="example" class="table table-striped text-start" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 30px;">plays</th>
                            <th style="width: 110px;">Artist</th>
                            <th>Title</th>
                            <th style="width: 90px;">Mode</th>
                            <th class="text-center" style="width: 60px;">Queue</th>
                            <th class="text-center" style="width: 60px;">Edit</th>
                            <th class="text-center" style="width: 60px;">Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($allSongs as $song) : ?>
                            <tr>
                                <td class="text-center"><?php echo e($song['plays']); ?></td>
                                <td><?php echo e($song['artist']); ?></td>
                                <td><?php echo e($song['title']); ?></td>
                                <td><?php echo e($song['mode']); ?></td>
                                <td class="justify-content-center"><button value="<?= $song['id'] ?>" class="btn btn-primary" id="selectCue">Select</button></td>
                                <td class=" text-center"><a href="/karaoke/edit?id=<?= $song['id'] ?>" type="button" class="btn btn-secondary">
                                        Edit
                                    </a></td>
                                <td class="justify-content-center"><a href="/karaoke/delete?delete=<?= $song['id'] ?>" class="btn btn-danger">Delete</a></td>
                            </tr>

                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="width: 60px;">plays</th>
                            <th style="width: 200px;">Artist</th>
                            <th>Title</th>
                            <th style="width: 120px;">Mode</th>
                            <th class="text-center" style="width: 60px;">Queue</th>
                            <th class="text-center" style="width: 60px;">Edit</th>
                            <th class="text-center" style="width: 60px;">Delete</th>
                        </tr>
                    </tfoot>
                </table>
            </div>


        </div>

        <div class="col-12 col-md-3 px-5">
            <div class="row mt-5 mb-3">
                <h3>PLAYLIST:</h3>
            </div>
            <div class="row d-flex overflow-auto border-end align-content-start" id="playlistDiv" style="height: 410px;">
                <?php $count = 1;
                foreach ($_SESSION['playlist'] as $song) : ?>

                    <div class="row border-bottom" style="height: fit-content;">
                        <div class="col-1">
                            <h6><?php echo $count ?>.</h6>
                        </div>
                        <div class="col-10 text-start">
                            <h7><?php echo $song['artist'] . " - " . $song['title'] ?></h7>
                        </div>
                    </div>


                <?php $count += 1;
                endforeach ?>
            </div>
            <div class="row justify-content-center">
                <div class="col-10 d-grid">
                    <a href="/playlist" class="btn btn-primary">Play</a>
                </div>

            </div>
        </div>
    </div>


</section>









<?php
include $this->resolve("partials/_footer.php");
?>