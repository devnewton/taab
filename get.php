<?php

include_once 'common.php';

$room = filter_input(INPUT_GET, 'room', FILTER_VALIDATE_REGEXP, array('options' => array('default' => '', 'regexp' => "/\w+/")));
$lastId = filter_input(INPUT_GET, 'lastId', FILTER_VALIDATE_INT, array('options' => array('default' => 0)));

taab_echo_backend($lastId, $room);
?>