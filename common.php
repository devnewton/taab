<?php

include_once "config.php";

function taab_echo_backend($posts, $lastId, $newPostId) {
    header("Content-Type: text/tab-separated-values");
    if (isset($newPostId)) {
        header('X-Post-Id: ' . $newPostId);
    }
    $outstream = fopen("php://output", 'w');
    foreach ($posts as $post) {
        if ($post[0] > $lastId) {
            fputcsv($outstream, $post, "\t");
        }
    }
    fclose($outstream);
}

?>