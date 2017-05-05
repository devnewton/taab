<?php

include_once 'common.php';

$lastId = filter_input(INPUT_POST, 'lastId', FILTER_VALIDATE_INT, array('options' => array('default' => 0)));
$message = mb_substr(filter_input(INPUT_POST, 'message', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW), 0, TAAB_MAX_POST_LENGTH);
$login = trim(mb_substr(filter_input(INPUT_POST, 'login', FILTER_SANITIZE_EMAIL), 0, TAAB_MAX_LOGIN_LENGTH));
$info = trim(mb_substr(filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_SANITIZE_EMAIL), 0, TAAB_MAX_INFO_LENGTH));

if(!mb_detect_encoding($login, 'UTF-8', true)) {
    $login = "relou";
}

if(!mb_detect_encoding($info, 'UTF-8', true)) {
    $info = "relou";
}

if (mb_strlen($login) === 0 && mb_strlen($info) === 0) {
    $info = "coward";
}

$file = fopen(TAAB_BACKEND, "c+");
flock($file, LOCK_EX);
$newPostId = 0;
$newPosts = array();
while (($post = fgetcsv($file, TAAB_MAX_BACKEND_LINE_LENGTH, "\t")) !== FALSE) {
    $newPosts[] = $post;
    $newPostId = max($newPostId, $post[0]);
}
if (mb_strlen(trim($message)) > 0 && mb_detect_encoding($message, 'UTF-8', true)) {
    ++$newPostId;
    $dateTime = date_create("now", timezone_open("Europe/Paris"));
    $time = date_format($dateTime, 'YmdHis');
    array_unshift($newPosts, array($newPostId, $time, $info, $login, $message));
}
array_splice($newPosts, TAAB_BACKEND_MAX_POSTS);
ftruncate($file, 0);
fseek($file, 0);
foreach ($newPosts as $post) {
    fputs($file, implode("\t", $post));
    fputs($file, "\n");
}
fclose($file);

taab_echo_backend($newPosts, $lastId, $newPostId);
?>