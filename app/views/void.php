<form method="post" action="void">
    <fieldset>
        <legend>Void Information</legend>

        <div class="form-group row">
            <label class="col-md-4 col-form-label">Payment ID</label>
            <div class="col-md-8">
                <input name="void[payment_id]" required class="form-control"
                       placeholder="ID of the authorized payment"/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">Description</label>
            <div class="col-md-8">
                <input name="void[description]" class="form-control" placeholder="Description"/>
            </div>
        </div>
    </fieldset>

    <div class="form-group row">
        <div class="col-md-12 text-center">
            <button class="btn btn-success btn-lg px-5">Void</button>
        </div>
    </div>
</form>
