<form method="post" action="refund">
    <fieldset>
        <legend>Refund Information</legend>

        <div class="form-group row">
            <label class="col-md-4 col-form-label">Payment ID</label>
            <div class="col-md-8">
                <input name="refund[payment_id]" required class="form-control" placeholder="Payment ID"/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Amount</label>
            <div class="col-md-8">
                <input name="refund[amount]" required class="form-control" placeholder="Amount"/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Description</label>
            <div class="col-md-8">
                <input name="refund[description]" class="form-control" placeholder="Description"/>
            </div>
        </div>
    </fieldset>

    <div class="form-group row">
        <div class="col-md-12 text-center">
            <button class="btn btn-success btn-lg px-5">Refund</button>
        </div>
    </div>
</form>
