<?php

include_once "config.php";

function taab_echo_backend($posts, $lastId, $newPostId = NULL) {
    header("Content-Type: text/tab-separated-values");
    if ($newPostId !== NULL) {
        header('X-Post-Id: ' . $newPostId);
    }
    $outstream = fopen("php://output", 'w');
    foreach ($posts as $post) {
        if ($post[0] > $lastId) {
            fputs($outstream, implode("\t", $post));
            fputs($outstream, "\n");
        }
    }
    fclose($outstream);
}

?>