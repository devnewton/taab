<?php

include_once 'common.php';

$mail = trim(mb_substr(filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL), 0, TAAB_MAX_INFO_LENGTH));
$login = filter_input(INPUT_POST, 'login', FILTER_VALIDATE_REGEXP, array('options' => array('default' => '', 'regexp' => "/\w+/")));

if (!mb_detect_encoding($login, 'UTF-8', true)) {
    $login = "relou";
}

if (mb_strlen($login) === 0) {
    $login = "relou";
}

$token = sha1($mail . time() . rand(0, 1000000));
$pdoStatement = $pdo->prepare(
        "INSERT OR REPLACE INTO users
            (mail, login, token)
            VALUES (:mail, :login, :token)
         ");
$pdoStatement->execute(array("mail" => $mail, "login" => $login, "token" => $token));

$mailContent = 'You can login from this URL:\n http'. (empty(filter_input(INPUT_SERVER, 'HTTPS', FILTER_SANITIZE_URL))?'':'s') . '://' . filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) . '/login.php#token=' . $token;
 mail ($mail, 'taab you for registering', $mailContent);
?>
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
        Register success, check your emails !
    </body>
</html>
