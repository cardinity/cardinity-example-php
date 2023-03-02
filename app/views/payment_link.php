<form method="post" action="payment_link">
    <fieldset>
        <legend>Create Payment Link</legend>

        <div class="form-group row">
            <label class="col-md-4 col-form-label">Amount</label>
            <div class="col-md-5">
                <input name="order[amount]" required class="form-control" placeholder="Amount"  value="29" />
            </div>
            <div class="col-md-3">
                <select name="order[currency]" class="form-control">
                    <option value="EUR">EUR</option>
                    <option value="USD">USD</option>
                    <option value="GBP">GBP</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label">Description</label>
            <div class="col-md-8">
                <input name="order[description]" class="form-control" placeholder="Description" />
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label">Country</label>
            <div class="col-md-8">
                <select name="order[country]" class="form-control">
                    <option value="">Dont Specify</option>
                    <?php require_once 'partial/country.php'; ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label">Expiration date</label>
            <div class="col-md-3">
                <select name="order[exp_year]"  class="form-control">
                    <option value="">No End</option>
                    <?php for ($i = date('Y'); $i <= date('Y', strtotime('+10 years')); $i++) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="order[exp_month]"  class="form-control">
                    <option value="">Month</option>
                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                        <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo sprintf('%02d', $i);  ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="order[exp_date]"  class="form-control">
                    <option value="">Date</option>
                    <?php for ($i = 1; $i <= 31; $i++) : ?>
                        <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo sprintf('%02d', $i);  ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
                <label class="col-md-4 col-form-label">Allow Multiple</label>
                <div class="col-md-8">
                    <select name="order[multiple_use]" required class="form-control">
                        <option value="1">Enable</option>
                        <option value="0">Disable</option>
                    </select>
                </div>
            </div>
    </fieldset>

    <div class="form-group row">
        <div class="col-md-12 text-center">
            <button class="btn btn-success btn-lg px-5">Create</button>
        </div>
    </div>
</form>
