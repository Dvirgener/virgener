<?php
include $this->resolve("partials/_header.php");

?>


<section class="mt-4">

    <div class="row mx-3">
        <div class="row mb-3">
            <span class="h1 text-center">DPP - DIRECTORATE FOR PLANS AND PROGRAMS</span>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <span class="h3">ADD PROCUREMENT</span>
                </div>
                <div class="row">
                    <form action="/section/dpp/addproc" method="POST">
                        <?php
                        include $this->resolve("partials/_token.php");
                        ?>
                        <div class="row">
                            <label>Procurement Activity:</label>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <input type="text" class="form-control" name="activity">
                            </div>
                        </div>
                        <div class="row">
                            <label>Amount:</label>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <input type="float" class="form-control" name="amount">
                            </div>
                        </div>
                        <div class="row">
                            <label>Quarter:</label>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <select name="quarter" id="" class="form-select">
                                    <option value="1st Quarter">1st Quarter</option>
                                    <option value="2nd Quarter">2nd Quarter</option>
                                    <option value="3rd Quarter">3rd Quarter</option>
                                    <option value="4th Quarter">4th Quarter</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <button class="btn btn-primary" type="submit">ADD PROCUREMENT</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>



</section>




<?php
include $this->resolve("partials/_footer.php");
?>