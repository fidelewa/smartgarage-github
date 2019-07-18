<?php
define('WEB_URL', 'http://127.0.0.1:8181/smartgarage-github/');
define('ROOT_PATH', 'C:\wamp64\www\smartgarage-github');

define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'gestiongarage_bdd');
$link = mysql_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD) or die(mysql_error());mysql_select_db(DB_DATABASE, $link) or die(mysql_error());?>