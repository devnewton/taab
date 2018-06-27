<?php

date_default_timezone_set('Europe/Paris');

$pdo = new PDO('sqlite:./data/backend.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$pdo->query("CREATE TABLE IF NOT EXISTS posts ( 
	id    INTEGER PRIMARY KEY AUTOINCREMENT,
	time  TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
        room  TEXT DEFAULT '' NOT NULL,
	info  TEXT DEFAULT '' NOT NULL,
        login TEXT DEFAULT '' NOT NULL,
        message TEXT DEFAULT '' NOT NULL   
);");

$pdo->query("CREATE TABLE IF NOT EXISTS users ( 
        mail  TEXT NOT NULL PRIMARY KEY,
        login TEXT DEFAULT '' NOT NULL,
        token  TEXT DEFAULT '' NOT NULL
);");

define("TAAB_BACKEND_MAX_POSTS", 200);
define("TAAB_MAX_POST_LENGTH", 512);
define("TAAB_MAX_LOGIN_LENGTH", 32);
define("TAAB_MAX_INFO_LENGTH", 32);
define("TAAB_DEV", false)
?>
