<?php

include_once "config.php";

function taab_echo_backend($lastId, $room = '', $newPostId = NULL) {
    global $pdo;
    $posts = $pdo->prepare(
                    "SELECT id, strftime('%s', time) as time, login, info, message
         FROM posts
         WHERE id > :lastId
         and room = :room
         ORDER BY id DESC
         LIMIT :maxPosts");
    $posts->execute(array("lastId" => $lastId, "room" => $room, "maxPosts" => TAAB_BACKEND_MAX_POSTS));
    header("Content-Type: text/tab-separated-values");
    if ($newPostId !== NULL) {
        header('X-Post-Id: ' . $newPostId);
    }
    if($room) {
        header('X-Room: ' . $room);
    }
    $outstream = fopen("php://output", 'w');
    while($post = $posts->fetch(PDO::FETCH_OBJ)) {
        fputs($outstream, $post->id);
        fputs($outstream, "\t");
        fputs($outstream, strftime('%Y%m%d%H%M%S', $post->time));
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