<?php
session_start();

// データベースの定数
// *の部分は環境に応じて設定
define('DSN', 'mysql:host=' . $_SERVER['HTTP_HOST'] . ';dbname=*****;charset=utf8mb4');
define('DB_USER', '*****');
define('DB_PASS', '*****');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
