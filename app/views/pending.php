<p>
    If your browser does not start loading the page,
    press the button below.
    <br>
    You will be sent back to this site after you
    authorize the transaction.
</p>
<form name="ThreeDForm" method="POST" action="<?php echo $_SESSION['cardinity']['ThreeDForm']; ?>">
    <button class="btn btn-success">Click Here</button>
    <input type="hidden" name="PaReq" value="<?php echo $_SESSION['cardinity']['PaReq']; ?>"/>
    <input type="hidden" name="TermUrl" value="<?php echo getenv('BASE_URL'); ?>/callback"/>
    <input type="hidden" name="MD" value="<?php echo $_SESSION['cardinity']['MD']; ?>"/>
</form>
