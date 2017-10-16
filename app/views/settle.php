<form method="post" action="settle">
    <fieldset>
        <legend>Settlement Information</legend>

        <div class="form-group row">
            <label class="col-md-4 col-form-label">Payment ID</label>
            <div class="col-md-8">
                <input name="settle[payment_id]" required class="form-control"
                       placeholder="ID of the authorized payment"/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Amount</label>
            <div class="col-md-8">
                <input name="settle[amount]" required class="form-control" placeholder="Amount"/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Description</label>
            <div class="col-md-8">
                <input name="settle[description]" class="form-control" placeholder="Description"/>
            </div>
        </div>
    </fieldset>

    <div class="form-group row">
        <div class="col-md-12 text-center">
            <button class="btn btn-success btn-lg px-5">Settle</button>
        </div>
    </div>
</form>
