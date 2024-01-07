<!-- MODAL FOR ADD SAA BUTTON -->

<!-- Modal -->
<div class="modal fade" id="add_saa" tabindex="-1" aria-labelledby="add_saa_label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_saa_label">Add SAA File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="addSaaModalBody">
                <form action="" method="GET" id="search_act" name="search_act">
                    <div class="row">
                        <div class="col-4">
                            <div class="row" id="resMe">
                                <div class="col">
                                    <?php
                                    $staffArray = [];
                                    foreach ($allActivity as $staff) {
                                        $staffArray[] = $staff['reviewing_staff'];
                                    }
                                    $staffArray = array_unique($staffArray);
                                    $acctCodeArray = [];
                                    foreach ($allActivity as $staff) {
                                        $acctCodeArray[] = $staff['acct_code'];
                                    }
                                    $acctCodeArray = array_unique($acctCodeArray);
                                    sort($acctCodeArray);
                                    ?>
                                    <label for="acct_code" class="form-label">Account Code:</label>
                                    <select name="acct_code" id="acct_code" class="form-select">
                                        <option value=""></option>
                                        <?php foreach ($acctCodeArray as $acctCode) : ?>
                                            *+ <option value="<?= $acctCode ?>"><?= $acctCode ?></option>
                                        <?php endforeach ?>

                                    </select>
                                    <label for="reviewing_staff" class="form-label mt-2">Reviewing Staff:</label>
                                    <select name="reviewing_staff" id="reviewing_staff" class="form-select" required>
                                        <option value=""></option>
                                        <?php foreach ($staffArray as $staff) : ?>
                                            <option value="<?= $staff ?>"><?= $staff ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <label for="" class="form-label mt-2">Quarter:</label>
                                    <select name="quarter" id="quarter" class="form-select" required>
                                        <option value=""></option>
                                        <option value="1">1st Quarter</option>
                                        <option value="2">2nd Quarter</option>
                                        <option value="3">3rd Quarter</option>
                                        <option value="4">4th Quarter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <button type="submit" class="btn btn-secondary">Search</button>
                                </div>
                            </div>
                        </div>
                </form>

                <div class="col-8">
                    <form action="/spendingplan/addsaa" method="POST">

                        <div class="row mb-2">
                            <?php include $this->resolve("partials/_token.php"); ?>
                            <div class="col">
                                <label for="saa_nr" class="form-label">SAA Number:</label>
                                <input type="text" class="form-control" name="saa_nr" id="saa_nr">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <input type="file" class="form-control">
                            </div>

                        </div>
                        <div class="row overflow-auto" id="" style="height: 300px;">
                            <table class="table">
                                <thead style="position:relative;">
                                    <tr class="border-bottom">
                                        <th style="width: 20px;">Check</th>
                                        <th style="width: 50px;">Acct Code</th>
                                        <th style="width: 150px;">Activity</th>
                                        <th style="width: 50px;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="" style="overflow-y: auto; height:400px" id="resultTable">


                                </tbody>

                            </table>
                        </div>


                </div>

            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
    </div>
</div>
</div>

<!-- MODAL FOR ADD SAA BUTTON -->