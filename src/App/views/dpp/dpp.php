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
                    <form action="">
                        <div class="row">
                            <label>Procurement Activity:</label>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label>Amount:</label>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control">
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