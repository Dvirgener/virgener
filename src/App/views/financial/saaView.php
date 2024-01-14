<div class="row mb-2" id="">
    <div class="col-6">
        <label class="form-label" for="">Activity:</label>
        <input class="form-control" type="text" value="<?= $saaDetails['saa_desc'] ?>" disabled>
    </div>
    <div class="col-6">
        <label class="form-label" for="">Acccount Code:</label>
        <input class="form-control" type="text" value="<?= $saaDetails['saa_acct_code'] ?>" disabled>
    </div>
</div>
<div class="row mb-2">
    <div class="col-3">
        <label class="form-label" for="">SAA Number:</label>
        <input class="form-control" type="text" value="<?= $saaDetails['saa_number'] ?>" disabled>
    </div>
    <div class="col-3">
        <label class="form-label" for="">Quarter:</label>
        <input class="form-control" type="text" value="<?= $saaDetails['saa_quarter'] ?>" disabled>
    </div>
    <div class="col-3">
        <label class="form-label" for="">Date:</label>
        <input class="form-control" type="text" value="<?= $saaDetails['saa_date'] ?>" disabled>
    </div>
    <div class="col-3">
        <label class="form-label" for="">Amount:</label>
        <input class="form-control" type="text" value="<?php echo number_format($saaDetails['saa_amount'], 2, '.', ','); ?>" disabled>
    </div>
</div>
<div class="row">
    <div class="col-8">
        <label class="form-label" for="">Remarks:</label>
        <textarea class="form-control" type="text" disabled cols="10" rows="5"><?= $saaDetails['saa_remarks'] ?></textarea>
    </div>
    <div class="col-4 ">
        <div class="row">
            <label class="form-label" for="">File/s:</label>
            <br>
            <a href="">M-24-12323.pdf</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <table class="table table-stripped text-center justify-content-center align-items-center">
            <thead>
                <tr>
                    <th>
                        L/I
                    </th>
                    <th>Reviewing Staff</th>
                    <th>Sub Ben</th>
                    <th>Activity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
                foreach ($saaActivities as $saaActivity) : ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td style="text-align:center"><?= $saaActivity['reviewing_staff'] ?></td>
                        <td class="align-items-center"><?= $saaActivity['sub_ben'] ?></td>
                        <td class=" justify-content-center"><?= $saaActivity['activity'] ?></td>
                        <td class=" justify-content-center"><?php echo number_format($saaActivity[$act_quarter], 2, '.', ','); ?></td>
                    </tr>
                <?php $count += 1;
                endforeach ?>


            </tbody>
        </table>
    </div>
</div>