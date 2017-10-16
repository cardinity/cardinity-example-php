<form method="post" action="recurring">
    <fieldset>
        <legend>Payment Information</legend>

        <div class="form-group row">
            <label class="col-md-4 col-form-label">Amount</label>
            <div class="col-md-5">
                <input name="recurring[amount]" required class="form-control" placeholder="Amount"/>
            </div>
            <div class="col-md-3">
                <select name="recurring[currency]" required class="form-control">
                    <option value="EUR">EUR</option>
                    <option value="USD">USD</option>
                    <option value="GBP">GBP</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Order ID</label>
            <div class="col-md-8">
                <input name="recurring[order_id]" class="form-control" value="<?php echo uniqid(); ?>"
                       placeholder="Order ID"/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Country</label>
            <div class="col-md-8">
                <select name="recurring[country]" required class="form-control">
                    <?php require_once "partial/country.php"; ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Transaction type</label>
            <div class="col-md-8">
                <select name="recurring[settle]" required class="form-control">
                    <option value="1">Purchase</option>
                    <option value="0">Authorization</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Description</label>
            <div class="col-md-8">
                <input name="recurring[description]" class="form-control" placeholder="Description"/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Payment ID</label>
            <div class="col-md-8">
                <input name="recurring[payment_id]" required class="form-control"
                       placeholder="ID of the successful payment">
            </div>
        </div>
    </fieldset>

    <div class="form-group row">
        <div class="col-md-12 text-center">
            <button class="btn btn-success btn-lg px-5">Charge</button>
        </div>
    </div>
</form>
