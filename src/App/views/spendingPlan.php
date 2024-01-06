<?php
include $this->resolve("partials/_header.php");

echo $totalFirstAmount;
?>

<section>

<div class="row text-center fs-1 px-2">
<span>UNIT ACTIVITIES TRANSACTION RECORD</span>
</div>
<div class="row d-flex px-2 my-2">
    <form action="">
        <div class="row">
            <label for="selectYear">Year:</label>
        </div>
        <div class="row">
            <div class="col-3">
                
                <select class="form-select my-2" name="selectYear" id="selectYear">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                </select>
            </div>
            <div class="col-2 my-2">
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
</div>
<div class="row mb-3 px-2">
    <div class="col">
        <button class="btn btn-primary">ADD ACTIVITY</button>
        <button class="btn btn-primary">ADD SAA</button>
        <button class="btn btn-primary">ADD OBLIGATION</button>
        <button class="btn btn-primary">ADD DV</button>
        <button class="btn btn-primary">ADD AAR</button>
    </div>

</div>
<div class="row px-3 border d-grid py-3">


<table id="example2" class="table table-striped text-start virg-normal-font table-light" style="width:100%; height:100%">
                    <thead class="virg-karaoke-font">
                        <tr>
                            <th style="width:30px">View</th>
                            <th style="width:50px">Staff</th>
                            <th class="text-center">Account Code</th>
                            <th class="text-center">Fund Source</th>
                            <th class="text-center">Activity</th>
                            <th class="text-center">Mode of Implementation</th>
                            <th class="text-center">Mode of Procurement</th>
                            <th class="text-center">1st Quarter</th>
                            <th class="text-center">2nd Quarter</th>
                            <th class="text-center">3rd Quarter</th>
                            <th class="text-center">4th Quarter</th>
                        </tr>
                    </thead>

                    <tbody class="fs-6 mb-2" >
                        <?php foreach ($allActivity as $activity) : ?>
                            <tr>
                                <td><a class="btn btn-success" href="">View</a></td>
                                <td class="text-center"><?php echo e($activity['reviewing_staff']); ?></td>
                                <td class="text-center"><?php echo e($activity['acct_code']); ?></td>
                                <td class="text-center"><?php echo e($activity['fund_source']); ?></td>
                                <td class="text-center"><?php echo e($activity['activity']); ?></td>
                                <td class="text-center"><?php echo e($activity['mode_imp']); ?></td>
                                <td class="text-center"><?php echo e($activity['mode_proc']); ?></td>

                                <?php
                                    $firststatusColor = "";
                                    if ($activity['first_obr'] !== ""){
                                        if(isset($activity['first_dv'])){
                                            $firststatusColor = "green";
                                        }

                                        $firststatusColor = "orange";
                                    }
                                ?>
                                <td class="text-center" style="background-color: <?=$firststatusColor?>;"><?php echo number_format($activity['first_amount'],2,'.',','); ?></td>
                                <td class="text-center"><?php echo number_format($activity['second_amount'],2,'.',','); ?></td>
                                <td class="text-center"><?php echo number_format($activity['third_amount'],2,'.',','); ?></td>
                                <td class="text-center"><?php echo number_format($activity['fourth_amount'],2,'.',','); ?></td>

                            </tr>

                        <?php endforeach ?>
                    </tbody >
                </table>
</div>
<div class="row px-3">
    <span>Legend (Amount Background Color):</span>
    <div class="row mt-2">
        <div class="col-5">
            <div class="row">
            <div class="col-1">SAA -</div>
        <div class="col-2 border" style="background-color: red;"></div>
        <div class="col-1">OBR -</div>
        <div class="col-2 border" style="background-color: orange;"></div>
        <div class="col-1">DV -</div>
        <div class="col-2 border" style="background-color: yellow;"></div>
        <div class="col-1">AAR -</div>
        <div class="col-2 border" style="background-color: green;"></div>
            </div>
        </div>

    </div>
</div>
        
</section>


<?php
include $this->resolve("partials/_footer.php");
?>