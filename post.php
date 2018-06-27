<?php

include_once 'common.php';

$room = filter_input(INPUT_POST, 'room', FILTER_VALIDATE_REGEXP, array('options' => array('default' => '', 'regexp' => "/\w+/")));
$lastId = filter_input(INPUT_POST, 'lastId', FILTER_VALIDATE_INT, array('options' => array('default' => 0)));
$message = mb_substr(filter_input(INPUT_POST, 'message', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW), 0, TAAB_MAX_POST_LENGTH);
$token = filter_input(INPUT_POST, 'room', FILTER_VALIDATE_REGEXP, array('options' => array('default' => '', 'regexp' => "/\w+/")));
$info = trim(mb_substr(filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_SANITIZE_EMAIL), 0, TAAB_MAX_INFO_LENGTH));

if (!mb_detect_encoding($info, 'UTF-8', true)) {
    $info = "relou";
}

if (mb_strlen($info) === 0) {
    $info = "coward";
}

$login = '';
if (mb_strlen($token) > 0) {
    $pdo->prepare(
            "SELECT login FROM users WHERE token = :token LIMIT 1
         ")->execute(array("token" => $token));
    $user = $posts->fetch(PDO::FETCH_OBJ);
    if ($user) {
        $login = $user->login;
    }
}

if (mb_strlen(trim($message)) > 0 && mb_detect_encoding($message, 'UTF-8', true)) {
    $pdo->prepare(
            "INSERT INTO posts
            (room, login, info, message)
            VALUES (:room, :login, :info, :message)
         ")->execute(array("room" => $room, "login" => $login, "info" => $info, "message" => $message));
}
taab_echo_backend($lastId, $room, $pdo->lastInsertId());
?>