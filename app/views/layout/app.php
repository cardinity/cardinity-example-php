<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cardinity</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo getenv('PUBLIC_ROOT'); ?>/css/app.css">
</head>
<body>
<header>

</header>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-6 mx-auto">
                <div class="row">
                    <div class="col-md-12 text-center my-5">
                        <img src="<?php echo getenv('PUBLIC_ROOT'); ?>/img/logo.png" alt="Cardinity"/>
                    </div>
                </div>

                <?php if (isset($_SESSION["errors"])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach ($_SESSION["errors"] as $key => $value) : ?>
                            <div><?php print_r($value); ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION["errors"]); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION["success"])) : ?>
                    <div class="alert alert-success" role="alert">
                        <div><?php print_r($_SESSION["success"]); ?></div>
                    </div>
                    <?php unset($_SESSION["success"]); ?>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-12">
                        <?php include $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <p>Card Processing by
        <a href="https://cardinity.com" target="_blank">
            <img src="<?php echo getenv('PUBLIC_ROOT'); ?>/img/by.png" alt="Cardinity">
        </a>
    </p>
</footer>
</body>
</html>
