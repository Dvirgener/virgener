<?php foreach ($result as $res) : ?>
    <tr>
        <td style="width: 20px;">
            <input class="form-check-input" type="checkbox" name="activitiesId[]" id="activitiesId[]" value="<?= $res['id']; ?>">
        </td>
        <td>
            <?= $res['acct_code']; ?>
        </td>
        <td>
            <?= $res['activity']; ?>
        </td>
        <td>
            <?= $res['sub_ben']; ?>
        </td>
        <td>
            <?php
            switch ($quarter) {
                case 1:
                    echo "<input type='hidden' id='quarter' name='quarter' value='1'>";
                    echo number_format($res['first_amount'], 2, '.', ',');
                    break;
                case 2:
                    echo "<input type='hidden' id='quarter' name='quarter' value='2'>";
                    echo number_format($res['second_amount'], 2, '.', ',');
                    break;
                case 3:
                    echo "<input type='hidden' id='quarter' name='quarter' value='3'>";
                    echo number_format($res['third_amount'], 2, '.', ',');
                    break;
                case 4:
                    echo "<input type='hidden' id='quarter' name='quarter' value='4'>";
                    echo number_format($res['fourth_amount'], 2, '.', ',');
                    break;
            }
            ?>
        </td>
    </tr>
<?php endforeach; ?>

