<?php
include $this->resolve("partials/_header.php");



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

                    <select class="form-select my-2" name="searchYear" id="searchYear">
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                    </select>
                </div>
                <div class="col-2 my-2">
                    <button class="btn btn-primary" id="" name="">Search</button>
                </div>
            </div>
        </form>

    </div>
    <div class="row mb-3 px-2">
        <div class="col">
            <button class="btn btn-primary">ADD ACTIVITY</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_saa">ADD SAA</button>
            <button class="btn btn-primary">ADD OBLIGATION</button>
            <button class="btn btn-primary">ADD DV</button>
            <button class="btn btn-primary">ADD AAR</button>
        </div>

    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="activities-tab" data-bs-toggle="tab" data-bs-target="#activities" type="button" role="tab" aria-controls="activities" aria-selected="true">Activities</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="saa-tab" data-bs-toggle="tab" data-bs-target="#saa" type="button" role="tab" aria-controls="saa" aria-selected="false">SAA Files</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">OBR Files</button>
        </li>
    </ul>
    <div class="tab-content " id="myTabContent">
        <div class="tab-pane fade show active p-3" id="activities" role="tabpanel" aria-labelledby="activities-tab">


            <div class="row border d-grid ">
                <table id="example2" class="table table-striped text-start virg-normal-font table-light" style="width:100%; height:100%">
                    <thead class="virg-karaoke-font">
                        <tr>
                            <th style="width:30px">View</th>
                            <th style="width:50px">Staff</th>
                            <th class="text-center">Account Code</th>
                            <th class="text-center">Fund Source</th>
                            <th class="text-center">Activity</th>
                            <th class="text-center">Sub Ben</th>
                            <th class="text-center">Mode of Implementation</th>
                            <th class="text-center">Mode of Procurement</th>
                            <th class="text-center">1st Quarter</th>
                            <th class="text-center">2nd Quarter</th>
                            <th class="text-center">3rd Quarter</th>
                            <th class="text-center">4th Quarter</th>
                        </tr>
                    </thead>

                    <tbody class="fs-6 mb-2">
                        <?php foreach ($allActivity as $activity) : ?>
                            <tr>
                                <td><a class="btn btn-success" href="">View</a></td>
                                <td class="text-center"><?php echo e($activity['reviewing_staff']); ?></td>
                                <td class="text-center"><?php echo e($activity['acct_code']); ?></td>
                                <td class="text-center"><?php echo e($activity['fund_source']); ?></td>
                                <td class="text-center"><?php echo e($activity['activity']); ?></td>
                                <td class="text-center"><?php echo e($activity['sub_ben']); ?></td>
                                <td class="text-center"><?php echo e($activity['mode_imp']); ?></td>
                                <td class="text-center"><?php echo e($activity['mode_proc']); ?></td>

                                <?php
                                $firstBg = bgColor($activity['first_saa'], $activity['first_obr'], $activity['first_dv'], $activity['first_aar']);
                                $secondBg = bgColor($activity['second_saa'], $activity['second_obr'], $activity['second_dv'], $activity['second_aar']);
                                $thirBg = bgColor($activity['third_saa'], $activity['third_obr'], $activity['third_dv'], $activity['third_aar']);
                                $fourthBg = bgColor($activity['fourth_saa'], $activity['fourth_obr'], $activity['fourth_dv'], $activity['fourth_aar']);
                                ?>
                                <td class="text-center" style="background-color: <?= $firstBg ?>;"><?php echo number_format($activity['first_amount'], 2, '.', ','); ?></td>
                                <td class="text-center"><?php echo number_format($activity['second_amount'], 2, '.', ','); ?></td>
                                <td class="text-center"><?php echo number_format($activity['third_amount'], 2, '.', ','); ?></td>
                                <td class="text-center"><?php echo number_format($activity['fourth_amount'], 2, '.', ','); ?></td>

                            </tr>

                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <div class="row px-3">
                <span>Legend (Amount Background Color):</span>
                <div class="row mt-2">
                    <div class="col-6">
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

        </div>

        <div class="tab-pane fade p-3" id="saa" role="tabpanel" aria-labelledby="saa-tab">
            <div class="row">
                <div class="col">

                </div>
            </div>
            <div class="row px-2" id="saa_row">
                <div class="col-6 border-end overflow-y-scroll" style="height:600px;">

                    <table id="example3" class="table table-striped text-start virg-normal-font table-light align-items-start" style="width:100%; height:100%">
                        <thead class="virg-karaoke-font">
                            <tr class="text-center">
                                <th>L/I</th>
                                <th>Description</th>
                                <th>SAA Number</th>
                                <th>SAA Date</th>
                                <th>Amount</th>
                                <th>View</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody class="fs-6 mb-2">
                            <?php $count = 1;
                            foreach ($allSaa as $saa) : ?>
                                <tr class="text-center">
                                    <td class="text-center"><?php echo e($count); ?></td>
                                    <td class="text-center"><?php echo e($saa['saa_desc']); ?></td>
                                    <td class="text-center"><?php echo e($saa['saa_number']); ?></td>
                                    <td class="text-center"><?php echo e($saa['saa_date']); ?></td>
                                    <td class="text-center"><?php echo number_format($saa['saa_amount'], 2, '.', ','); ?></td>
                                    <td><button type="button" class="btn btn-primary view_saa_but" id="" value="<?php echo e($saa['id']); ?>">View</button></td>
                                    <td><button type="button" class="btn btn-danger delete_saa_but" id="" value="<?php echo e($saa['id']); ?>">Delete</button></td>
                                </tr>

                            <?php $count += 1;
                            endforeach ?>
                        </tbody>
                    </table>


                </div>
                <div class="col-6 ">
                    <div class="row">
                        <div class="col text-center fw-bold">
                            <h1>RECORD DETAILS</h1>
                        </div>
                    </div>
                    <div class="row  overflow-y-scroll align-items-start" id="saa_view" style="height: 550px;">

                    </div>

                </div>
            </div>

        </div>
        <div class="tab-pane fade p-3" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
    </div>






</section>


<?php
include $this->resolve("financial/modals.php");
include $this->resolve("partials/_footer.php");
?>