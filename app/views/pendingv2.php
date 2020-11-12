<p>
    If your browser does not start loading the page after 3 second,
    press the button below.
    <br>
    You will be sent back to this site after you
    authorize the transaction.
</p>
<form id='ThreeDForm' name="ThreeDForm" method="POST" action="<?php echo $_SESSION['cardinity']['acs_url']; ?>">
    <button class="btn btn-success">Click Here</button>
    <input type="hidden" name="creq" value="<?php echo $_SESSION['cardinity']['creq']; ?>"/>
    <input type="hidden" name="threeDSSessionData" value="<?php echo $_SESSION['cardinity']['threeDSSessionData']; ?>"/>
</form>
<script type='text/javascript'>
    window.onload=function(){ 
        window.setTimeout(document.ThreeDForm.submit.bind(document.ThreeDForm), 2000);
    };
</script>
