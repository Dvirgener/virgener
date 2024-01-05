<?php

$data = $_GET['play'];
$songTitle = $_GET['title'];
$artist = $_GET['artist'];


$json = json_encode($data);
echo "<script>var data = $json;</script>";
include $this->resolve("partials/_header.php");


?>

<!-- Start Main Content Area -->
<section>

    <div class="row">
        <div class="row text-center">
            <div class="col-2"></div>
            <div class="col-7">
            <h1>Title: <?= $songTitle ?></h1>
            <h4>Artist: <?= $artist ?></h4>
            </div>
            <div class="col-3"></div>

        </div>
        <div class="row">
            <div class="col-2 ps-5">
                <div class="row mb-3">
                    <div class="col-9">
                        <h5>Up Next ... </h5>
                    </div>
                    <div class="col-2">
                        <a href="/playlist" class="btn btn-primary">NEXT</a>
                    </div>
                </div>
                <div class="row d-flex overflow-auto align-content-start" id="playlistDiv" style="height: 540px;">
                    <?php $count = 1;
                    foreach ($_SESSION['playlist'] as $song) : ?>

                        <div class="row border-bottom" style="height: fit-content;">
                            <div class="col-1 ">
                                <h6><?php echo $count ?>.</h6>
                            </div>
                            <div class="col-10 text-start">
                                <h7><?php echo $song['artist'] . " - " . $song['title'] ?></h7>
                            </div>
                        </div>
                    <?php $count += 1;
                    endforeach ?>
                </div>
            </div>
            <div class="col-7 d-grid justify-content-center ">
                <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
                <div id="playersa" class="mb-2"></div>
            </div>
            <div class="col-3">
                <div class="row">
                    <h5>SEARCH</h5>
                </div>
                <div class="row px-2">
                    <input type="text" class="form-control" id="live-search">
                </div>
                <div class="row" id="searchResult">

                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center my-3 ">
        <div class="col-2">

        </div>
        <div class="col-7 d-grid">
            
        </div>
        <div class="col-3"></div>
    </div>

</section>
<!-- End Main Content Area -->

<?php
include $this->resolve("partials/_footer.php");
?>