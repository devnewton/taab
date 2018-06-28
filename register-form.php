<?php include_once "config.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <title>taab</title>
        <link rel="stylesheet" href="css/blaze.css">
    </head>
    <body class="c-text">
        <form class="o-container o-container--medium u-window-box--tiny" action="register.php" method="post">
            <label class="c-label o-form-element">
                Email:
                <input name="mail" type="email" class="c-field c-field--label" placeholder="kevin@caramail.com">
            </label>
            <label class="c-label o-form-element">
                Login:
                <input name="login" type="text" class="c-field c-field--label" placeholder="DarkKevin666">
            </label>
            <input type="submit" class="c-button c-button--info">
        </form>
    </body>
</html>
