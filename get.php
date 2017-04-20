<?php

include_once 'common.php';

$lastId = filter_input(INPUT_GET, 'lastId', FILTER_VALIDATE_INT, array('options' => array('default' => 0)));

$file = fopen(TAAB_BACKEND, "r");
$newPosts = array();
while (($post = fgetcsv($file, TAAB_MAX_BACKEND_LINE_LENGTH, "\t")) !== FALSE) {
    $newPosts[] = $post;
}
fclose($file);

taab_echo_backend($newPosts, $lastId);
?>