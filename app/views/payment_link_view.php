<form method="post" action="payment_link_view">
    <fieldset>
        <?php
        $paymentLink = $_SESSION['payment_link'];
        ?>
        <legend>Update Payment Link</legend>
        <legend><b><?php echo $paymentLink->getId()?></b></legend>
        <br/>
        <pre><?php echo json_encode(json_decode($paymentLink->serialize()), JSON_PRETTY_PRINT);?></pre>

        <div class="form-group row">
            <label class="col-md-4 col-form-label">Expiration date</label>
            <div class="col-md-3">
                <select name="order[exp_year]"  class="form-control">
                    <option value="">No End</option>
                    <?php for ($i = date('Y'); $i <= date('Y', strtotime('+10 years')); $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor;?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="order[exp_month]"  class="form-control">
                    <option value="">Month</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo sprintf('%02d', $i); ?></option>
                    <?php endfor;?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="order[exp_date]"  class="form-control">
                    <option value="">Date</option>
                    <?php for ($i = 1; $i <= 31; $i++): ?>
                        <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo sprintf('%02d', $i); ?></option>
                    <?php endfor;?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Enabled</label>
            <div class="col-md-8">
                <select name="order[enabled]" required class="form-control">
                    <option value="1">Enabled</option>
                    <option value="0">Disabled</option>
                </select>
            </div>
        </div>
    </fieldset>

    <div class="form-group row">
        <div class="col-md-12 text-center">
            <button class="btn btn-success btn-lg px-5">Update</button>
        </div>
    </div>
</form>
