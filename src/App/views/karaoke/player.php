<?php

$data = $_GET['play'];

$json = json_encode($data);
echo "<script>var data = $json;</script>";
include $this->resolve("partials/_header.php");


?>

<!-- Start Main Content Area -->
<section>

    <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
    <div id="playersa"></div>

    <div class="row">
        <a href="/playlist">NEXT</a>
    </div>

    <div class="row">
        <br>
        <br>
        <h1>Up next</h1>
        <?php foreach ($_SESSION['playlist'] as $key => $value) : ?>

            <h3>Song: <?php echo $key ?></h3>
            <h3>Song: <?php echo $value ?></h3>
            <br>
        <?php endforeach ?>
    </div>

</section>
<!-- End Main Content Area -->

<?php
include $this->resolve("partials/_footer.php");
?>