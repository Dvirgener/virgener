<?php
include $this->resolve("partials/_header.php");

?>
<section class="mt-4">

    <div class="row mx-3">
        <div class="col-4">
            <?php
            include $this->resolve("partials/_profile.php");
            ?>
        </div>

        <div class="col-8 px-4">
            <div class="row ms-2 text-center fw-bold">
                <h2>HISTORY</h2>
            </div>
            <div class="row border-bottom border-dark border-2 mx-2 mb-3">
            </div>
            <div class="row border p-2">
                <table id="workHistory" class="table table-striped virg-normal-font table-light">
                    <thead class="text-center mb-4">
                        <tr class="text-center">
                            <th class="text-center" style="width: 20px;">L/I</th>
                            <th class="text-center" style="width: 420px;">SUBJECT</th>
                            <th class="text-center" style="width: 130px">ADDED FROM</th>
                            <th class="text-center" style="width: 130px">COMPLIED BY</th>
                            <th class="text-center" style="width: 130px">TIMELINESS</th>
                            <th class="text-center" style="width: 130px">DETAILS</th>
                        </tr>
                    </thead>
                    <tbody class="align-items-center fs-5">
                        <?php
                        $count = 1;
                        foreach ($directedWork as $work) : ?>
                            <tr>
                                <td class="text-center align-items-bottom"><?= $count ?></td>
                                <td><?= $work['subject'] ?></td>
                                <td class="text-center"><?= $work['added_from'] ?></td>
                                <td class="text-center"><?= $work['complied_by'] ?></td>
                                <td class="text-center"><?= $work['timeliness'] ?></td>
                                <td class="text-center fs-6">
                                    <button value="<?= $work['id'] ?>" class="btn btn-primary viewWorkButHistory" style="font-size: small;">VIEW</button>
                                </td>
                            </tr>
                        <?php
                            $count += 1;
                        endforeach ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



</section>




<?php
include $this->resolve("partials/_modals.php");
include $this->resolve("partials/_footer.php");
?>