<form method="post" action="payment">
    <fieldset>
        <legend>Order Information</legend>

        <div class="form-group row">
            <label class="col-md-4 col-form-label">Amount</label>
            <div class="col-md-5">
                <input name="order[amount]" required class="form-control" placeholder="Amount" value="29"/>
            </div>
            <div class="col-md-3">
                <select name="order[currency]" required class="form-control">
                    <option value="EUR">EUR</option>
                    <option value="USD">USD</option>
                    <option value="GBP">GBP</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Order ID</label>
            <div class="col-md-8">
                <input name="order[order_id]" class="form-control" value="<?php echo uniqid(); ?>"
                       placeholder="Order ID"/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Country</label>
            <div class="col-md-8">
                <select name="order[country]" required class="form-control">
                    <?php require_once 'partial/country.php'; ?>
                </select>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Payment Information</legend>

        <div class="form-group row">
            <label class="col-md-4 col-form-label">Transaction type</label>
            <div class="col-md-8">
                <select name="order[settle]" required class="form-control">
                    <option value="1">Purchase</option>
                    <option value="0">Authorization</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Description</label>
            <div class="col-md-8">
                <input name="order[description]" class="form-control" placeholder="Description"/>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Card Information</legend>

        <div class="form-group row">
            <label class="col-md-4 col-form-label">Card holder</label>
            <div class="col-md-8">
                <input name="card[holder]" required class="form-control"
                       placeholder="Enter your full name" value="TestShababDSVTWO">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Card number</label>
            <div class="col-md-8">
                <input name="card[pan]" required class="form-control" placeholder="Enter credit card number" value="5454545454545454">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Expiration date</label>
            <div class="col-md-4">
                <select name="card[exp_year]" required class="form-control">
                    <option value="2022">2022</option>
                    <option value="">Year</option>
                    <?php for ($i = date('Y'); $i <= date('Y', strtotime('+10 years')); $i++) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4">
                <select name="card[exp_month]" required class="form-control">
                    <option value="12">12</option>
                    <option value="">Month</option>
                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Security code</label>
            <div class="col-md-3">
                <input name="card[cvc]" required class="form-control" placeholder="CVV" maxlength="4" value="125">
            </div>
            <div class="col-md-4"><span class="cvv"><img src="<?php echo getenv('PUBLIC_ROOT'); ?>/img/cvv.png" alt="Secured"> What is CVV?</span></div>
        </div>
    </fieldset>

    <div class="form-group row">
        <div class="col-md-12 text-center">
            <button class="btn btn-success btn-lg px-5">Pay</button>
        </div>
    </div>
</form>
