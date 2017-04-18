<?php

include_once 'common.php';

$lastId = filter_input(INPUT_POST, 'lastId', FILTER_VALIDATE_INT, array('options' => array('default' => 0)));
$message = substr(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW), 0, TAAB_MAX_POST_LENGTH);
$login = trim(substr(filter_input(INPUT_POST, 'login', FILTER_SANITIZE_EMAIL), 0, TAAB_MAX_LOGIN_LENGTH));
$info = trim(substr(filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_SANITIZE_EMAIL), 0, TAAB_MAX_INFO_LENGTH));
if (strlen($login) === 0 && strlen($info) === 0) {
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
if (strlen(trim($message)) > 0) {
    ++$newPostId;
    $dateTime = date_create("now", timezone_open("Europe/Paris"));
    $time = date_format($dateTime, 'YmdHis');
    array_unshift($newPosts, array($newPostId, $time, $login, $info, $message));
}
array_splice($newPosts, TAAB_BACKEND_MAX_POSTS);
ftruncate($file, 0);
fseek($file, 0);
foreach ($newPosts as $post) {
    fputcsv($file, $post, "\t");
}
fclose($file);

taab_echo_backend($newPosts, $lastId, $newPostId);
?>