<?php

include_once "config.php";

function taab_echo_backend($lastId, $newPostId = NULL) {
    global $pdo;
    $posts = $pdo->prepare(
                    "SELECT id, strftime('%Y%m%d%H%M%S', time) as time, login, info, message
         FROM posts
         WHERE id > :lastId
         ORDER BY id DESC
         LIMIT :maxPosts");
    $posts->execute(array("lastId" => $lastId, "maxPosts" => TAAB_BACKEND_MAX_POSTS));
    header("Content-Type: text/tab-separated-values");
    if ($newPostId !== NULL) {
        header('X-Post-Id: ' . $newPostId);
    }
    $outstream = fopen("php://output", 'w');
    while($post = $posts->fetch(PDO::FETCH_OBJ)) {
        fputs($outstream, $post->id);
        fputs($outstream, "\t");
        fputs($outstream, $post->time);
        fputs($outstream, "\t");
        fputs($outstream, $post->info);
        fputs($outstream, "\t");
        fputs($outstream, $post->login);
        fputs($outstream, "\t");
        fputs($outstream, $post->message);
        fputs($outstream, "\n");
    }
    fclose($outstream);
}

?>