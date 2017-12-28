<?php

include_once 'common.php';

$lastId = filter_input(INPUT_GET, 'lastId', FILTER_VALIDATE_INT, array('options' => array('default' => 0)));

taab_echo_backend($lastId);
?>